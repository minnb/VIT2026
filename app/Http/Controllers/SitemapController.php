<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

/**
 * Sinh sitemap.xml động từ dữ liệu thật trong CSDL.
 *
 * Thay cho file sitemap.xml tĩnh cũ (sinh tay năm 2020, không tự cập nhật).
 * URL được dựng bằng chính route() + fencrypt() + makeUnicode() mà giao diện
 * đang dùng, nên luôn khớp tuyệt đối với link nội bộ và với thẻ canonical.
 */
class SitemapController extends Controller
{
    /**
     * Danh mục cha của sản phẩm và dự án trong bảng posts.
     */
    const PARENT_PRODUCT = 1;
    const PARENT_PROJECT = 2;

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = array_merge(
            $this->staticUrls(),
            $this->categoryUrls(),
            $this->postUrls()
        );

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'text/xml; charset=UTF-8');
    }

    /**
     * Các trang cố định của khu vực public.
     *
     * @return array
     */
    protected function staticUrls()
    {
        return [
            $this->url(seo_canonical('/'), '1.0', 'daily'),
            $this->url(seo_canonical(route('get.product.all')), '0.9', 'weekly'),
            $this->url(seo_canonical(route('get.project.all')), '0.8', 'weekly'),
            $this->url(seo_canonical(route('get.document.all')), '0.8', 'monthly'),
            $this->url(seo_canonical(route('get.about')), '0.6', 'yearly'),
            $this->url(seo_canonical(route('get.baohanh')), '0.4', 'yearly'),
            $this->url(seo_canonical(route('get.baomat')), '0.4', 'yearly'),
        ];
    }

    /**
     * Trang danh mục sản phẩm.
     *
     * @return array
     */
    protected function categoryUrls()
    {
        $urls = [];

        foreach (Category::getList(self::PARENT_PRODUCT) as $category) {
            $urls[] = $this->url(
                seo_canonical(route('get.product.cate', [
                    'id'   => fencrypt($category['id']),
                    'name' => makeUnicode($category['name']),
                ])),
                '0.8',
                'weekly'
            );
        }

        return $urls;
    }

    /**
     * Trang chi tiết sản phẩm và dự án đang hiển thị.
     *
     * @return array
     */
    protected function postUrls()
    {
        // Chi lay dung 4 cot can dung. Lay ca cot `content` (longtext) chi de dung
        // id + title se ngon ~1.3 MB RAM thay vi ~80 KB.
        $posts = Post::whereIn('parent', [self::PARENT_PRODUCT, self::PARENT_PROJECT])
            ->where('sttesign', 1)
            ->orderBy('id', 'DESC')
            ->get(['id', 'title', 'updated_at', 'created_at']);

        $urls = [];

        foreach ($posts as $post) {
            $urls[] = $this->url(
                seo_canonical(route('get.product.single', [
                    'id'   => fencrypt($post->id),
                    'name' => makeUnicode($post->title),
                ])),
                '0.7',
                'monthly',
                $post->updated_at ?: $post->created_at
            );
        }

        return $urls;
    }

    /**
     * Chuẩn hoá một mục <url> của sitemap.
     *
     * @param  string  $loc
     * @param  string  $priority
     * @param  string  $changefreq
     * @param  mixed   $lastmod
     * @return array
     */
    protected function url($loc, $priority, $changefreq, $lastmod = null)
    {
        // Cot updated_at/created_at co the khong ton tai trong bang posts -> fallback ve hom nay
        $stamp = $lastmod instanceof \DateTimeInterface ? \Carbon\Carbon::instance($lastmod) : now();

        return [
            'loc'        => $loc,
            'lastmod'    => $stamp->toAtomString(),
            'changefreq' => $changefreq,
            'priority'   => $priority,
        ];
    }
}
