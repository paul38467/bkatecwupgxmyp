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
        $this->middleware('FormInputRemoveEol:tag_name')->only(['store', 'update']);
        $this->middleware('FormInputSingleSpace:tag_name')->only(['store', 'update']);
    }

    /**
     * 顯示首頁
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artist_tagcats = ArtistTagcat::with('artistTag')->get();
        return view('artist_tag.index', compact('artist_tagcats'));
    }

    /**
     * 建立藝人的標籤
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
     * 顯示編輯藝人標籤的表格
     *
     * @param  \App\Models\ArtistTag  $artist_tag
     * @return \Illuminate\Http\Response
     */
    public function edit(ArtistTag $artist_tag)
    {
        return view('artist_tag.edit', compact('artist_tag'));
    }

    /**
     * 更新藝人的標籤
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
     * 刪除藝人的標籤
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
