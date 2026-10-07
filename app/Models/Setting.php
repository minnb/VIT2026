<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    protected $table = 'setting';

    protected $fillable = ['type', 'name', 'address', 'phone', 'fax', 'email', 'alias', 'sort', 'status'];

    protected $casts = [
        'sort'   => 'int',
        'status' => 'int',
    ];

    /** Hotline mac dinh khi bang `setting` chua co du lieu. */
    const DEFAULT_HOTLINE = '0985.912.033';

    /** @var array Bo nho dem trong pham vi mot request. */
    protected static $cache = [];

    public static function getHotline($limit = 1)
    {
        if (isset(self::$cache['hotline'][$limit])) {
            return self::$cache['hotline'][$limit];
        }

        $hotline = self::DEFAULT_HOTLINE;
        $data = Setting::where('type', 'HOTLINE')->limit($limit)->get();
        if ($data->count() > 0) {
            $hotline = $data[0]->phone;
        }
        $hotline = ($hotline !== '') ? $hotline : self::DEFAULT_HOTLINE;

        return self::$cache['hotline'][$limit] = $hotline;
    }

    public static function getComName($alias = 'COM')
    {
        if (isset(self::$cache['com'][$alias])) {
            return self::$cache['com'][$alias];
        }

        return self::$cache['com'][$alias] = Setting::where('alias', $alias)->get()->toArray();
    }
}