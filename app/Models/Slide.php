<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Slide extends Model
{
    protected $table = 'slide';

    protected $fillable = ['image', 'description', 'alias', 'sort', 'status'];

    protected $casts = [
        'sort'   => 'int',
        'status' => 'int',
    ];

    /**
     * Slide dang bat, theo dung thu tu hien thi.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('sort')->orderBy('id');
    }
}