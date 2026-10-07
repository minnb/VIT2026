<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'title', 'slug', 'description', 'content', 'parent', 'type',
        'categorieID', 'userID', 'sttesign', 'price',
    ];

    protected $casts = [
        'deleted_at'  => 'datetime',
        'parent'      => 'int',
        'type'        => 'int',
        'categorieID' => 'int',
        'userID'      => 'int',
        'sttesign'    => 'int',
        'viewed'      => 'int',
        'votes'       => 'int',
    ];

    /**
     * Danh muc cua bai viet.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categorieID');
    }

    /**
     * Nguoi tao bai viet.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    /**
     * Anh dinh kem, sap theo cot sort.
     */
    public function images()
    {
        return $this->hasMany(Images::class, 'post_id')->orderBy('sort')->orderBy('id');
    }

    /**
     * Chi lay bai dang hien thi.
     */
    public function scopePublished($query)
    {
        return $query->where('sttesign', 1);
    }

    /**
     * Danh sach cho khu quan tri: co phan trang va KHONG tai cot `content`.
     */
    public static function getListForAdmin($parent, $perPage = 20)
    {
        return Post::where('parent', $parent)
            ->where('sttesign', 1)
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['id', 'title', 'slug', 'description', 'parent', 'categorieID', 'price', 'created_at']);
    }

    public static function getList($parent)
    {
        return Post::where([
            ['parent', $parent],
            ['sttesign', 1],
        ])->orderBy('id')->get()->toArray();
    }

    public static function getPostByCateId($cate_id, $limit = '')
    {
        if ($limit === '') {
            return Post::where([
                ['categorieID', $cate_id],
                ['sttesign', 1],
            ])->inRandomOrder()->first();
        }

        return Post::where([
            ['categorieID', $cate_id],
            ['sttesign', 1],
        ])->orderBy('id')->limit($limit)->get()->toArray();
    }

    public static function getRandomPost($parent, $limit = '')
    {
        if ($limit === '') {
            return Post::where([
                ['parent', $parent],
                ['sttesign', 1],
            ])->inRandomOrder()->first();
        }

        return Post::where([
            ['parent', $parent],
            ['sttesign', 1],
        ])->inRandomOrder()->limit($limit)->get()->toArray();
    }

    /**
     * San pham lien ket.
     */
    public static function getProductLink($parent, $limit = '')
    {
        $linkRoot = Category::linkRootId();

        if ($linkRoot > 0) {
            $parent = $linkRoot;
        }

        if ($limit === '') {
            return Post::where([
                ['parent', $parent],
                ['sttesign', 1],
            ])->inRandomOrder()->first();
        }

        return Post::where([
            ['parent', $parent],
            ['sttesign', 1],
        ])->inRandomOrder()->limit($limit)->get()->toArray();
    }

    public static function getRandomPostByCate($cate, $limit = '')
    {
        if ($limit === '') {
            return Post::where([
                ['categorieID', '=', $cate],
                ['sttesign', 1],
            ])->inRandomOrder()->first();
        }

        return Post::where([
            ['categorieID', '=', $cate],
            ['sttesign', 1],
        ])->inRandomOrder()->limit($limit)->get()->toArray();
    }

    /**
     * Tai lieu dung cho card quang cao o trang chu.
     */
    public static function getRandomDocuments(int $limit = 5): array
    {
        return Post::where('parent', 11)
            ->where('sttesign', 1)
            ->whereNotNull('description')
            ->where('description', '<>', '')
            ->inRandomOrder()
            ->limit($limit)
            ->get(['id', 'title', 'description', 'categorieID'])
            ->toArray();
    }

    public static function CountPostByCateId($cate)
    {
        return Post::where([
            ['categorieID', $cate],
            ['sttesign', 1],
        ])->count();
    }
}