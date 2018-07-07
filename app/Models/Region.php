<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'region'; // 設定資料表名稱
    protected $fillable = ['region_name', 'artist_total', 'av_total', 'movie_total'];

    /*
    ** Relationships
    */

    // 我這個(表region) 和 對方(表artist) 的關係
    public function artist()
    {
        // 我這個(表region) 的 id欄位 會出現多筆記錄在 對方(表artist) 的 region_id欄位
        return $this->hasMany(Artist::class, 'region_id');
    }

    /*
    ** Mutator
    */
    public function setCreatedAtAttribute()
    {
        $this->attributes['created_at'] = \Carbon\Carbon::parse('-13 year')->toDateTimeString();
    }

    public function setUpdatedAtAttribute()
    {
        $this->attributes['updated_at'] = \Carbon\Carbon::parse('-13 year')->toDateTimeString();
    }

    /*
    ** Accessor
    */
    public function getCategoryDataTotalAttribute()
    {
        return $this->attributes['artist_total'] + $this->attributes['av_total'] + $this->attributes['movie_total'];
    }
}
