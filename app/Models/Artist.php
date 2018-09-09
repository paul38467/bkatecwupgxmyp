<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artist'; // 設定資料表名稱
    protected $guarded = [];
    protected $casts = [
        'gender' => 'boolean',
        'is_fav' => 'boolean'
    ];

    /*
    ** Relationships
    */

    // 我這個(表artist) 和 對方(表artist_aka) 的關係
    public function artistAka()
    {
        /*
            第一個參數是對方 Model 的檔案位置 'App\Models\ArtistAka'
            由於現在這個檔案開頭宣告了 namespace App\MyModels; , 而 ArtistAka.php 和這個檔案(Artist.php)放在同一目錄
            所以可以這樣寫 ArtistAka::class
            第二個參數是對方 'artist_aka' 資料表裡的 artist_id 欄位名稱
        */

        // 我這個(表artist) 的 id欄位 會出現多筆記錄在 對方(表artist_aka) 的 artist_id欄位
        return $this->hasMany(ArtistAka::class, 'artist_id')->orderBy('aka_order');
    }

    // 我這個(表artist) 和 對方(表artist_tag) 透過 中樞(表artist_pivot_tag) 建立關係
    public function artistTag()
    {
        /*
            第二個參數是中樞資料表名稱 'artist_pivot_tag'
            第三個參數是 Foreign Key
            第四個參數是 Local Key
        */

        // 我這個 (表artist) 的 id欄位 會出現多筆記錄在 中樞(表artist_pivot_tag) 的 artist_id欄位
        // 對方 (表artist_tag) 的 id欄位 會出現多筆記錄在 中樞(表artist_pivot_tag) 的 tag_id欄位
        return $this->belongsToMany(ArtistTag::class, 'artist_pivot_tag', 'artist_id', 'tag_id')->withTimestamps();
    }

    // 我這個(表artist) 和 對方(表region) 的關係
    public function region()
    {
        // 我這個(表artist) 的 region_id欄位 是屬於 對方(表region) 的 id欄位
        return $this->belongsTo(Region::class, 'region_id');
    }

    /*
    ** Mutator
    */
    public function setScreenNameAttribute($value)
    {
        $this->attributes['screen_name'] = $value ?? '';
    }

    public function setOldIdAttribute($value)
    {
        $this->attributes['old_id'] = $value ?? '';
    }

    public function setWikiAttribute($value)
    {
        $this->attributes['wiki'] = urldecode($value) ?? '';
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value ?? '';
    }

    /*
    ** Accessor
    */
    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['birth_date'])->diff(\Carbon\Carbon::parse($this->attributes['death_date']))->format('%y');
    }

    public function getFoundAtAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['found_at'])->diffForHumans();
    }

    public function getBirthAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['birth_date'])->diffForHumans();
    }

    public function getDeathAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['death_date'])->diffForHumans();
    }

    public function getCreatedAtAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    public function getUpdatedAtAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }

    public function getProfilePathAttribute()
    {
        // return 2017-11/profile-1-n
        return sprintf('%s/profile-%d-n', \Carbon\Carbon::parse($this->attributes['created_at'])->format('Y-m'), $this->attributes['id']);
    }

    public function getAvatarUrlAttribute()
    {
        return \Storage::disk('artist')->url($this->attributes['avatar']);
    }
}
