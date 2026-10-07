<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\Category;
use App\Models\Images;

/**
 * Gom các thao tác chuẩn bị dữ liệu dùng chung cho view khu quản trị.
 *
 * Trước đây view tự gọi Model để lấy tên danh mục / đếm bài viết / lấy ảnh
 * (vi phạm MVC và gây N+1 query). Các helper dưới đây đưa việc đó về Controller.
 */
trait PreparesViewData
{
    /**
     * Map [id danh mục => tên danh mục] cho danh sách bài viết,
     * tránh gọi Category::getNameById() trong vòng lặp của view.
     *
     * @param  array|\Illuminate\Support\Collection  $posts
     * @return array
     */
    protected function cateNamesFor($posts)
    {
        $ids = [];

        foreach ($posts as $post) {
            $ids[] = $post['categorieID'];
        }

        $ids = array_unique(array_filter($ids));

        if (empty($ids)) {
            return [];
        }

        return Category::whereIn('id', $ids)->pluck('name', 'id')->toArray();
    }

    /**
     * Map [id danh mục => số bài viết] cho trang quản lý danh mục.
     *
     * @param  array  $categories
     * @return array
     */
    protected function catePostCountFor($categories)
    {
        $ids = [];

        foreach ($categories as $category) {
            $ids[] = $category['id'];
        }

        // Mot truy van GROUP BY cho ca trang, thay vi mot truy van moi danh muc.
        $counts = Category::countPostForMany($ids);

        foreach ($ids as $id) {
            $counts[$id] = isset($counts[$id]) ? (int) $counts[$id] : 0;
        }

        return $counts;
    }

    /**
     * Map [id bài viết => ảnh đại diện] cho một danh sách, bằng MỘT truy vấn.
     * Thay cho việc gọi Images::checkImageProduct() trong vòng lặp của view.
     *
     * @param  array|\Illuminate\Support\Collection  $posts
     * @return array
     */
    protected function firstImagesFor($posts)
    {
        $ids = [];

        foreach ($posts as $post) {
            $ids[] = $post['id'];
        }

        return Images::firstImageForMany($ids);
    }

    /**
     * Danh sach anh cua mot bai viet, luon tra ve mang/collection duyet duoc.
     *
     * @param  int  $postId
     * @return mixed
     */
    protected function imagesFor($postId)
    {
        $images = Images::checkImageByPostId($postId);

        return $images ?: [];
    }
}
