<?php

/*
|--------------------------------------------------------------------------
| Cấu hình SEO
|--------------------------------------------------------------------------
|
| Nguồn sự thật duy nhất cho toàn bộ thẻ meta, Open Graph và Schema.org
| của khu vực public. View KHÔNG được hardcode lại các giá trị này.
|
| Xem thêm: .claude/rules/seo-standards.md
|
*/

return [

    /*
    | Tên miền chính thức dùng để dựng URL tuyệt đối (canonical, og:url,
    | sitemap, JSON-LD). Bỏ dấu "/" ở cuối.
    */
    'base_url' => rtrim(env('SEO_BASE_URL', env('APP_URL', 'https://vitduct.com.vn')), '/'),

    /*
    | Nhận diện thương hiệu.
    */
    'brand'        => 'VITDUCT',
    'title_suffix' => 'CÔNG TY CỔ PHẦN VITDUCT',

    /*
    | Giá trị mặc định khi trang không khai @section riêng.
    */
    'default_title'       => 'CÔNG TY CỔ PHẦN VITDUCT',
    'default_description' => 'Nhà sản xuất ống gió, van gió, cửa gió tiêu chuẩn ISO. Thi công lắp đặt hệ thống thông gió, điều hòa không khí và cơ điện ME trọn gói cho công trình.',

    /*
    | Ảnh chia sẻ mạng xã hội mặc định (đường dẫn tương đối tính từ gốc site).
    */
    'default_og_image' => '/home/images/logo.jpg',
    'og_image_width'   => 592,
    'og_image_height'  => 592,

    'fb_app_id'    => '1547540628876392',
    'twitter_card' => 'summary_large_image',

    /*
    | Dữ liệu cho JSON-LD Organization (schema.org).
    */
    'organization' => [
        'legal_name'    => 'CÔNG TY CỔ PHẦN VITDUCT',
        'logo'          => '/home/images/logo.jpg',
        'founding_date' => '2001',
        'email'         => 'contact@vitduct.com.vn',
        'phones'        => ['024 3645 4199'],

        // Trụ sở chính
        'address' => [
            'street'      => 'Số 16, Ngõ 85, Đường Lĩnh Nam, P. Mai Động, Q. Hoàng Mai',
            'locality'    => 'Hà Nội',
            'postal_code' => '100000',
            'country'     => 'VN',
        ],

        // Nhà máy sản xuất — khai bằng schema Place, không nhân bản Organization
        'locations' => [
            [
                'name'        => 'Nhà máy miền Bắc',
                'street'      => 'Cụm CN Yên Bình, Xã Yên Bình, H. Thạch Thất',
                'locality'    => 'Hà Nội',
                'postal_code' => '100000',
                'country'     => 'VN',
            ],
            [
                'name'        => 'Nhà máy miền Nam',
                'street'      => 'Cụm CN Đức Hoà Đông, Xã Đức Hoà Đông, H. Đức Hoà',
                'locality'    => 'Long An',
                'postal_code' => '850000',
                'country'     => 'VN',
            ],
        ],

        'same_as' => [
            'https://www.facebook.com/vitduct.com.vn',
        ],
    ],

];
