<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistTag extends Model
{
    protected $table = 'artist_tag'; // 設定資料表名稱
    protected $fillable = ['tagcat_id', 'tag_name'];

    /*
    ** Relationships
    */

    // 我這個(表artist_tag) 和 對方(表artist) 透過 中樞(表artist_pivot_tag) 建立關係
    public function artist()
    {
        // 我這個 (表artist_tag) 的 id欄位 會出現多筆記錄在 中樞(表artist_pivot_tag) 的 tag_id欄位
        // 對方 (表artist) 的 id欄位 會出現多筆記錄在 中樞(表artist_pivot_tag) 的 artist_id欄位
        return $this->belongsToMany(Artist::class, 'artist_pivot_tag', 'tag_id', 'artist_id')->withTimestamps();
    }

    // 我這個(表artist_tag) 和 對方(表artist_tagcat) 的關係
    public function artistTagcat()
    {
        // 我這個(表artist_tag) 的 tagcat_id欄位 是屬於 對方(表artist_tagcat) 的 id欄位
        return $this->belongsTo(ArtistTagcat::class, 'tagcat_id');
    }
}
