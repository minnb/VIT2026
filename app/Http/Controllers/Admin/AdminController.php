<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Đếm một lần bằng count() thay vì get()->count() (không tải toàn bộ bản ghi)
        $counts = Post::published()
            ->selectRaw('parent, COUNT(*) as total')
            ->groupBy('parent')
            ->pluck('total', 'parent')
            ->toArray();

        $stats = [
            [
                'label' => 'Sản phẩm',
                'count' => $counts[1] ?? 0,
                'icon'  => 'fa-file-text-o',
                'bg'    => 'bg-default',
                'note'  => 'Tổng số sản phẩm',
            ],
            [
                'label' => 'Báo giá & Catalog',
                // Tai lieu nam o parent = 11 (danh muc "Download tai lieu"),
                // ban cu doc $counts[0] nen o nay luon hien 0.
                'count' => $counts[11] ?? 0,
                'icon'  => 'fa-bar-chart',
                'bg'    => 'bg-warning',
                'note'  => 'Tổng số tài liệu',
            ],
            [
                'label' => 'Dự án',
                'count' => $counts[2] ?? 0,
                'icon'  => 'fa-user-o',
                'bg'    => 'bg-info',
                'note'  => 'Dự án đã triển khai',
            ],
            [
                'label' => 'Tin tức',
                'count' => $counts[3] ?? 0,
                'icon'  => 'fa-bell-o',
                'bg'    => 'bg-danger',
                'note'  => 'Tổng số tin tức',
            ],
        ];

        return view('admin.pages.index', compact('stats'));
    }
}
