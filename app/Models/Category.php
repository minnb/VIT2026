<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = ['name', 'slug', 'parent', 'sort', 'userID'];

    protected $casts = [
        'deleted_at' => 'datetime',
        'parent'     => 'int',
        'sort'       => 'int',
        'userID'     => 'int',
    ];

    /**
     * Bai viet thuoc danh muc nay.
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'categorieID');
    }

    /**
     * Danh muc con.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent');
    }

    /**
     * Danh muc cha.
     */
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent');
    }

    /**
     * Slug cua danh muc danh cho "San pham lien ket".
     */
    const LINK_SLUG = 'san-pham-lien-ket';

    /**
     * Id danh muc "San pham lien ket".
     *
     * @return int
     */
    public static function linkRootId()
    {
        static $id;

        if ($id === null) {
            $id = (int) Category::where('slug', self::LINK_SLUG)->value('id');
        }

        return $id;
    }

    /**
     * Bo nho dem trong pham vi mot request.
     *
     * @var array
     */
    protected static $listCache = [];

    /** @var array */
    protected static $countCache = [];

    public static function getList($parent)
    {
        if (isset(self::$listCache[$parent])) {
            return self::$listCache[$parent];
        }

        $data = Category::where([
            ['parent', $parent],
        ])->orderBy('sort')->orderBy('id')->get()->toArray();

        return self::$listCache[$parent] = $data;
    }

    public static function getListTop($parent, $limit)
    {
        return Category::where([
            ['parent', $parent],
        ])->orderBy('sort')->orderBy('id')->limit($limit)->get()->toArray();
    }

    public static function countPost($cate_id)
    {
        if (isset(self::$countCache[$cate_id])) {
            return self::$countCache[$cate_id];
        }

        return self::$countCache[$cate_id] = Post::where([
            ['categorieID', $cate_id],
            ['sttesign', 1],
        ])->count();
    }

    /**
     * Dem bai viet cho nhieu danh muc bang MOT truy van (chong N+1).
     *
     * @param  array  $cateIds
     * @return array
     */
    public static function countPostForMany(array $cateIds)
    {
        if (empty($cateIds)) {
            return [];
        }

        $counts = Post::whereIn('categorieID', $cateIds)
            ->where('sttesign', 1)
            ->selectRaw('categorieID, COUNT(*) as total')
            ->groupBy('categorieID')
            ->pluck('total', 'categorieID')
            ->toArray();

        foreach ($cateIds as $id) {
            self::$countCache[$id] = isset($counts[$id]) ? (int) $counts[$id] : 0;
        }

        return $counts;
    }

    public static function getNameById($cate_id)
    {
        $category = Category::find($cate_id);

        return $category ? $category->name : '';
    }

    /**
     * Ten danh muc CHA cua danh muc dang xet.
     */
    public static function getParentNameByCateId($cate_id)
    {
        $category = Category::find($cate_id);

        if (! $category) {
            return '';
        }

        $parent = Category::find($category->parent);

        return $parent ? $parent->name : '';
    }
}