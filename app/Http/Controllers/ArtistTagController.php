<?php

namespace App\Http\Controllers;

use App\Models\ArtistTag;
use App\Models\ArtistTagcat;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArtistTagRequest;

class ArtistTagController extends Controller
{
    public function __construct()
    {
        $this->middleware('FormInputSingleSpace:tag_name')->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artist_tagcats = ArtistTagcat::with('artistTag')->get();
        return view('artist_tag.index', compact('artist_tagcats'));
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
     * @param  StoreArtistTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtistTagRequest $request)
    {
        ArtistTag::create([
            'tagcat_id' => $request->input('tagcat_id'),
            'tag_name' => $request->input('tag_name'),
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArtistTag  $artist_tag
     * @return \Illuminate\Http\Response
     */
    public function show($artist_tag)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ArtistTag  $artist_tag
     * @return \Illuminate\Http\Response
     */
    public function edit(ArtistTag $artist_tag)
    {
        return view('artist_tag.edit', compact('artist_tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreArtistTagRequest  $request
     * @param  \App\Models\ArtistTag  $artist_tag
     * @return \Illuminate\Http\Response
     */
    public function update(StoreArtistTagRequest $request, ArtistTag $artist_tag)
    {
        $artist_tag->tag_name = $request->input('tag_name');
        $artist_tag->save();
        return redirect()->route('artist-tag.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArtistTag  $artist_tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArtistTag $artist_tag)
    {
        // 防止刪除此標籤，如果有藝人正在使用此標籤
        // if ('將來填入有多少藝人使用此標籤')
        // {
        //     return back();
        // }

        $artist_tag->delete();
        return redirect()->route('artist-tag.index');
    }
}
