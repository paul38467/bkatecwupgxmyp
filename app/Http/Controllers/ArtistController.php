<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\ArtistAka;
use App\Models\ArtistTagcat;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreArtistRequest;
use DB;
use App\Traits\MyStorage;

class ArtistController extends Controller
{
    use MyStorage;

    public function __construct()
    {
        $this->middleware('FormInputRemoveEol:en_name,screen_name')->only(['store', 'update']);
        $this->middleware('FormInputSingleSpace:en_name,screen_name')->only(['store', 'update']);
    }

    /**
     * 顯示首頁
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artists = Artist::orderBy('id', 'asc')->paginate(60);
        return view('artist.index', compact('artists'));
    }

    /**
     * 顯示建立藝人的表格
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::all();
        return view('artist.create', compact('regions'));
    }

    /**
     * 建立藝人
     *
     * @param  StoreArtistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtistRequest $request)
    {
        return $this->storeOrUpdate($request, (new Artist), 'store');
    }

    /**
     * 顯示指定的藝人
     *
     * @param  mixed  $artist
     * @return \Illuminate\Http\Response
     */
    public function show($artist)
    {
        $artist = Artist::with(['artistAka', 'artistTag', 'region'])->findOrFail($artist);
        $artistTagcats = ArtistTagcat::with('artistTag')->get();
        return view('artist.show', compact('artist', 'artistTagcats'));
    }

    /**
     * 顯示編輯藝人的表格
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function edit(Artist $artist)
    {
        $regions = Region::all();
        return view('artist.edit', compact('artist', 'regions'));
    }

    /**
     * 更新藝人
     *
     * @param  StoreArtistRequest  $request
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(StoreArtistRequest $request, Artist $artist)
    {
        return $this->storeOrUpdate($request, $artist, 'update');
    }

    /**
     * 刪除藝人
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artist        $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Artist $artist)
    {
        $this->validate($request, [
            'confirm_delete' => 'required|in:delete',
        ]);

        $deletedProfilePath = sprintf('%s/%s_deleted_at_%s',
                                    config('cfg.artist.deletedProfilePath'),
                                    $artist->profile_path,
                                    \Carbon\Carbon::now()->format('Y-m-d_H-i-s')
                              );

        if (! $this->myStorageMoveDir('artist', $artist->profile_path, $deletedProfilePath) )
        {
            return back()->withErrors(['error' => '無法刪除，因為不能變更此藝人的 profile 目錄為 ' . $deletedProfilePath]);
        }

        $artist->delete();
        return redirect()->route('artist.index');
    }

    /**
     * 同步更新藝人的標籤
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artist        $artist
     * @return \Illuminate\Http\Response
     */
    public function updateTags(Request $request, Artist $artist)
    {
        $this->validate($request, [
            'artist_tags' => 'sometimes|array',
            'artist_tags.*' => 'distinct|exists:artist_tag,id'
        ]);

        try
        {
            $artist->artistTag()->sync($request->input('artist_tags'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('artist.show', $artist);
    }

    /**
     * 建立或更新藝人的程序
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artist        $artist
     * @param  string                    $action    "store|update"
     * @return \Illuminate\Http\Response
     */
    private function storeOrUpdate($request, $artist, $action)
    {
        $artist->old_id = $request->input('old_id');
        $artist->region_id = $request->input('region_id');
        $artist->en_name = $request->input('en_name');
        $artist->screen_name = $request->input('screen_name');
        $artist->gender = $request->input('gender');
        $artist->is_fav = $request->input('is_fav');
        $artist->grade = $request->input('grade');
        $artist->force_cat = $request->input('force_cat');
        $artist->need_focus = $request->input('need_focus');
        $artist->birth_date = $request->input('birth_date');
        $artist->death_date = $request->input('death_date');
        $artist->wiki = $request->input('wiki');
        $artist->description = $request->input('description');
        $artist->found_at = $request->input('found_at') ?? date("Y-m-d");

        if ($action == 'store')
        {
            $artist->avatar = config('cfg.artist.defaultAvatar');
        }

        $akaNames = is_null($request->input('aka_names'))
                         ? []
                         : array_values(string_to_array_filter($request->input('aka_names'), true));

        // Begin Transaction
        DB::beginTransaction();
        try
        {
            $artist->save();

            // 如果 aka_name 有變動, 更新 artist 的 'updated_at'
            $oldAkaNames = $artist->artistAka->pluck('aka_name')->toArray();

            if ($akaNames <> $oldAkaNames)
            {
                $artist->touch();
            }

            // 先刪除此藝人的所有別名
            $artist->artistAka()->delete();

            // 然後將所有別名儲存為新記錄
            // foreach (array_values($akaNames) as $key => $akaName)
            foreach ($akaNames as $key => $akaName)
            {
                $artistAka = new ArtistAka;
                $artistAka->artist_id = $artist->id;
                $artistAka->aka_name = $akaName;
                $artistAka->aka_order = $key + 1;
                $artistAka->save();
            }

            if ($request->hasFile('avatar_image'))
            {
                // save avatar image to disk
                $avatar = $request->file('avatar_image');
                $avatarExtension = strtolower($avatar->getClientOriginalExtension());
                $avatarFileName = sprintf('avatar-small_%s.%s', $artist->id, $avatarExtension);
                $savedPath = $avatar->storeAs($artist->profile_path, $avatarFileName, 'artist'); // 'artist' is disk name

                // save avatar path to db
                $artist->timestamps = false;
                $artist->avatar = $savedPath;
                $artist->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
        // End Transaction

        if ($action == 'store')
        {
            Storage::disk('artist')->makeDirectory($artist->profile_path . '/avatar_large');    // 保留用來製作 avatar 的大圖
            Storage::disk('artist')->makeDirectory($artist->profile_path . '/gallery');         // 暫時存放 gallery
            Storage::disk('artist')->makeDirectory($artist->profile_path . '/old_avatar_130');  // 保留舊的 avatar 小圖
        }

        return redirect()->route('artist.show', $artist);
    }
}
