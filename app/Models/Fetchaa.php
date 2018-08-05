<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fetchaa extends Model
{
    protected $table = 'fetchaa'; // 設定資料表名稱
    protected $fillable = [
        'fetch_date',
        'is_read',
        'is_focus',
        'is_merge',
        'thread_type',
        'regdate',
        'tid',
        'title',
        'artist',
        'av_icode',
        'urls',
        'clear_code'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_focus' => 'boolean',
        'is_merge' => 'boolean',
        'urls' => 'array'
    ];

    /*
    ** Mutator
    */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim(str_limit($value, 245));
    }

    public function setArtistAttribute($value)
    {
        $this->attributes['artist'] = trim(str_limit($value, 390));
    }

    public function setAvIcodeAttribute($value)
    {
        $this->attributes['av_icode'] = trim(str_limit($value, 245));
    }

    /**
     * update is_read to 1
     *
     * @param  array $ids
     * @return int          [num of affected rows]
     */
    public static function updateIsReadByIds($ids)
    {
        return static::whereIn('id', $ids)->update(['is_read' => 1]);
    }

    /**
     * get last tid
     *
     * @return int
     */
    public static function getLastTid()
    {
        $lastThread = static::orderBy('tid', 'desc')->first();
        return is_null($lastThread) ? 0 : $lastThread->tid;
    }

    /**
     * get all duplicate AV Icode records
     *
     * @param  string $avIcode
     * @return object
     */
    public static function getThreadsByAvIcode($avIcode)
    {
        return static::where('av_icode', $avIcode)->orderBy('id', 'asc')->get();
    }
}
