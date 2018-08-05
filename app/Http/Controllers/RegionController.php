<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRegionRequest;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('FormInputRemoveEol:region_name')->only(['store', 'update']);
        $this->middleware('FormInputSingleSpace:region_name')->only(['store', 'update']);
    }

    /**
     * 顯示首頁
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Region::all();
        return view('region.index', compact('regions'));
    }

    /**
     * 建立地區
     *
     * @param  StoreRegionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegionRequest $request)
    {
        Region::create([
            'region_name' => $request->input('region_name'),
            'artist_total' => 0,
            'av_total' => 0,
            'movie_total' => 0,
        ]);

        return back();
    }

    /**
     * 顯示編輯地區的表格
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        return view('region.edit', compact('region'));
    }

    /**
     * 更新地區
     *
     * @param  StoreRegionRequest  $request
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRegionRequest $request, Region $region)
    {
        $region->region_name = $request->input('region_name');
        $region->save();
        return redirect()->route('region.index');
    }

    /**
     * 刪除地區
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        // 防止刪除有資料的地區
        if ($region->category_data_total)
        {
            return back();
        }

        $region->delete();
        return redirect()->route('region.index');
    }
}
