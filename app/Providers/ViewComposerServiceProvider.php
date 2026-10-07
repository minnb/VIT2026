<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Cung cấp dữ liệu dùng chung cho các view thuộc khu vực public (home.*).
 *
 * Trước đây các view gọi thẳng Model để truy vấn DB (vi phạm MVC).
 * Provider này gom toàn bộ truy vấn đó về một chỗ và đẩy sang view
 * dưới dạng biến, giúp view chỉ còn nhiệm vụ hiển thị.
 */
class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['home.layouts.*', 'home.pages.*', 'home.partials.*'],
            function ($view) {
                $view->with($this->sharedData());
            }
        );
    }

    /**
     * Dữ liệu dùng chung cho layout public (header, nav, footer, service).
     *
     * @return array
     */
    protected function sharedData()
    {
        $lstCate = Category::getList(1);

        // Đếm sẵn số bài viết mỗi danh mục để view không phải truy vấn
        // trong vòng lặp (tránh N+1 query).
        $catePostCount = [];
        foreach ($lstCate as $item) {
            $catePostCount[$item['id']] = Category::countPost($item['id']);
        }

        return [
            'com'            => Setting::getComName('COM'),
            'man'            => Setting::getComName('MAN'),
            'hotline'        => Setting::getHotline(),
            'lstCate'        => $lstCate,
            'catePostCount'  => $catePostCount,
            'lstDoc'         => Category::getList(11),
            'lstCateFooter'  => Category::getListTop(1, 9),
        ];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
