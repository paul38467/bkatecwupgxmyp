<?php

namespace App\Http\Controllers;

use App\Models\ArtistTagcat;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArtistTagcatRequest;

class ArtistTagcatController extends Controller
{
    public function __construct()
    {
        $this->middleware('FormInputSingleSpace:tagcat_name')->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artist_tagcats = ArtistTagcat::all();
        return view('artist_tagcat.index', compact('artist_tagcats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreArtistTagcatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtistTagcatRequest $request)
    {
        ArtistTagcat::create([
            'tagcat_name' => $request->input('tagcat_name'),
            'tag_total' => 0,
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArtistTagcat  $artist_tagcat
     * @return \Illuminate\Http\Response
     */
    public function show($artist_tagcat)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ArtistTagcat  $artist_tagcat
     * @return \Illuminate\Http\Response
     */
    public function edit(ArtistTagcat $artist_tagcat)
    {
        return view('artist_tagcat.edit', compact('artist_tagcat'));
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArtistTagcat  $artist_tagcat
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArtistTagcat $artist_tagcat)
    {
        // 防止刪除有標籤的分類
        if ($artist_tagcat->tag_total)
        {
            return back();
        }

        $artist_tagcat->delete();
        return redirect()->route('artist-tagcat.index');
    }
}
