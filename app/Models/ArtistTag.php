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

    // 我這個(表artist_tag) 和 對方(表artist_tagcat) 的關係
    public function artistTagcat()
    {
        // 我這個(表artist_tag) 的 tagcat_id欄位 是屬於 對方(表artist_tagcat) 的 id欄位
        return $this->belongsTo(ArtistTagcat::class, 'tagcat_id');
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
