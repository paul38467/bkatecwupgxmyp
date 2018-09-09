<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistAka extends Model
{
    protected $table = 'artist_aka'; // 設定資料表名稱
    protected $guarded = [];

    /*
    ** Relationships
    */

    // 我這個(表artist_aka) 和 對方(表artist) 的關係
    public function artist()
    {
        // 我這個(表artist_aka) 的 artist_id欄位 是屬於 對方(表artist) 的 id欄位
        return $this->belongsTo(Artist::class, 'artist_id');
    }
}
