<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistTagcat extends Model
{
    protected $table = 'artist_tagcat'; // 設定資料表名稱
    protected $fillable = ['tagcat_name', 'tag_total'];

    /*
    ** Relationships
    */

    // 我這個(表artist_tagcat) 和 對方(表artist_tag) 的關係
    public function artistTag()
    {
        // 我這個(表artist_tagcat) 的 id欄位 會出現多筆記錄在 對方(表artist_tag) 的 tagcat_id欄位
        return $this->hasMany(ArtistTag::class, 'tagcat_id');
    }

    /*
    ** Mutator
    */
    public function setCreatedAtAttribute()
    {
        $this->attributes['created_at'] = \Carbon\Carbon::parse('-12 year')->toDateTimeString();
    }

    public function setUpdatedAtAttribute()
    {
        $this->attributes['updated_at'] = \Carbon\Carbon::parse('-12 year')->toDateTimeString();
    }
}
