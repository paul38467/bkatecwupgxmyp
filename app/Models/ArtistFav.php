<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistFav extends Model
{
    protected $table = 'artist_fav'; // 設定資料表名稱
    protected $fillable = ['artist_name'];
}
