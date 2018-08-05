<?php

namespace App\Http\Controllers;

use App\Models\ArtistTagcat;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArtistTagcatRequest;

class ArtistTagcatController extends Controller
{
    public function __construct()
    {
        $this->middleware('FormInputRemoveEol:tagcat_name')->only(['store', 'update']);
        $this->middleware('FormInputSingleSpace:tagcat_name')->only(['store', 'update']);
    }

    /**
     * 顯示首頁
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artist_tagcats = ArtistTagcat::withCount('artistTag')->get();
        return view('artist_tagcat.index', compact('artist_tagcats'));
    }

    /**
     * 建立藝人的標籤分類
     *
     * @param  StoreArtistTagcatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtistTagcatRequest $request)
    {
        ArtistTagcat::create([
            'tagcat_name' => $request->input('tagcat_name'),
        ]);

        return back();
    }

    /**
     * 顯示編輯藝人標籤分類的表格
     *
     * @param  \App\Models\ArtistTagcat  $artist_tagcat
     * @return \Illuminate\Http\Response
     */
    public function edit(ArtistTagcat $artist_tagcat)
    {
        return view('artist_tagcat.edit', compact('artist_tagcat'));
    }

    /**
     * 更新藝人的標籤分類
     *
     * @param  StoreArtistTagcatRequest  $request
     * @param  \App\Models\ArtistTagcat  $artist_tagcat
     * @return \Illuminate\Http\Response
     */
    public function update(StoreArtistTagcatRequest $request, ArtistTagcat $artist_tagcat)
    {
        $artist_tagcat->tagcat_name = $request->input('tagcat_name');
        $artist_tagcat->save();
        return redirect()->route('artist-tagcat.index');
    }

    /**
     * 刪除藝人的標籤分類
     *
     * @param  \App\Models\ArtistTagcat  $artist_tagcat
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArtistTagcat $artist_tagcat)
    {
        // 防止刪除有標籤的分類
        if ($artist_tagcat->artistTag->count())
        {
            return back();
        }

        $artist_tagcat->delete();
        return redirect()->route('artist-tagcat.index');
    }
}
