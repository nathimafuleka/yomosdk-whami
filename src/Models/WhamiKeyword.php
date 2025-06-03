<?php

namespace Yomo7\Whami\Models;

use Illuminate\Database\Eloquent\Model;

class WhamiKeyword extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'whami_keywords';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'keyword',
        'attribution_code',
    ];

    /**
     * Get keywords by number
     *
     * @param string $number
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByNumber(string $number)
    {
        return self::where('number', $number)->get();
    }

    /**
     * Get keywords by attribution code
     *
     * @param string $attributionCode
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByAttributionCode(string $attributionCode)
    {
        return self::where('attribution_code', $attributionCode)->get();
    }

    /**
     * Get keywords by keyword
     *
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByKeyword(string $keyword)
    {
        return self::where('keyword', $keyword)->get();
    }
}
