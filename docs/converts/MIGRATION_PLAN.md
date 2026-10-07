# KẾ HOẠCH CHUYỂN ĐỔI HỆ THỐNG TỪ LARAVEL 5.7 SANG LARAVEL 11/13
**Mã dự án:** VIT2018_v11  
**Mục tiêu môi trường:** PHP 8.3 | MySQL 5.7/8.0  
**Vai trò:** Tech Lead & Senior Laravel Developer  
**Phiên bản tài liệu:** 1.0  
**Ngày lập:** 07/10/2026  

---

## I. TỔNG QUAN & MỤC TIÊU DỰ ÁN

### 1. Bối cảnh
Website giới thiệu và quản trị sản phẩm của Công ty Cổ phần VITDUCT hiện đang chạy trên nền tảng **Laravel 5.7** (PHP 7.1). Để đáp ứng việc nâng cấp hạ tầng hosting lên **PHP 8.3**, hệ thống cần được nâng cấp toàn diện lên **Laravel 11.x (hoặc 13.x)**.

### 2. Mục tiêu trọng tâm
1. **Zero Data Loss:** Giữ nguyên 100% cơ sở dữ liệu MySQL hiện tại, không thay đổi schema làm mất dữ liệu lịch sử.
2. **Media Preservation:** Bảo toàn nguyên vẹn thư viện ảnh tải lên (`storage/app/public/uploads` và `public/uploads`).
3. **SEO Continuity:** Giữ nguyên 100% cấu trúc URL tĩnh, động, sitemap XML và các chuẩn SEO/OpenGraph hiện tại.
4. **Code Modernization:** Nâng cấp toàn bộ codebase tương thích hoàn toàn với PHP 8.3, tuân thủ chuẩn PSR-12, tối ưu hóa truy vấn và loại bỏ các thành phần legacy/deprecated.
5. **Zero Downtime Migration:** Xây dựng dự án mới song song (`VIT2018_v11`), kiểm thử độc lập trước khi switch trên môi trường production.

---

## II. ĐÁNH GIÁ HIỆN TRẠNG & MA TRẬN KHÁC BIỆT KỸ THUẬT (TECH GAP)

| Thành phần | Hệ thống cũ (VIT2018 - L5.7 / PHP 7.1) | Hệ thống mới (VIT2018_v11 - L11/13 / PHP 8.3) | Giải pháp xử lý |
|---|---|---|---|
| **Cấu trúc Bootstrap** | `app/Http/Kernel.php`, `app/Console/Kernel.php`, `Exceptions/Handler.php` | Tinh gọn hoàn toàn vào `bootstrap/app.php` | Đăng ký Middleware alias, Exception và Routing trực tiếp trong `bootstrap/app.php`. |
| **Routing Syntax** | Chuỗi ký tự: `'uses' => 'HomeController@index'` | Cú pháp callable: `[HomeController::class, 'index']` | Chuyển đổi toàn bộ route sang dạng callable class hoặc nhóm namespace controller. |
| **Authentication** | `Auth::routes()`, Trait `AuthenticatesUsers` | Không kèm sẵn trong framework core (trừ khi dùng Breeze/laravel/ui) | Tự xây dựng route đăng nhập/đăng xuất Admin tinh gọn, sử dụng Facade `Auth` chuẩn. |
| **Eloquent Date Casting** | Khai báo `protected $dates = ['deleted_at']` | Deprecated, thay bằng `protected $casts = ['deleted_at' => 'datetime']` | Cập nhật toàn bộ các Model có sử dụng SoftDeletes. |
| **Helper Functions** | `str_slug()`, `array_get()`, `str_limit()` | Đã bị loại bỏ khỏi core helpers | Thay bằng `Str::slug()`, `Arr::get()`, `Str::limit()` trong `Illuminate\Support`. |
| **Dynamic Properties** | Cho phép gán thuộc tính động trên class | Bị Deprecated trong PHP 8.2 và Fatal Warning trong PHP 8.3 | Khai báo tường minh các thuộc tính trên Controller/Service. |
| **Custom Functions** | Tự load qua `files` trong `composer.json` | Cần tiếp tục duy trì tương tự | Đăng ký `app/Library/Functions.php` vào `autoload.files` của `composer.json`. |
| **Assets & Uploads** | Thư mục `public/` và `storage/` | Yêu cầu symbolic link chuẩn | Tạo symlink qua lệnh `php artisan storage:link`. |

---

## III. KIẾN TRÚC MỤC TIÊU (TARGET ARCHITECTURE)

```
VIT2018_v11/
├── app/
│   ├── Console/Commands/        # FixContentImageUrls, SyncImagesFromContent
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # 7 Admin Controllers + Concerns
│   │   │   ├── Auth/            # LoginController
│   │   │   ├── HomeController.php
│   │   │   └── SitemapController.php
│   │   └── Middleware/
│   │       └── EnsureUserIsAdmin.php
│   ├── Library/
│   │   └── Functions.php        # Custom helpers (getImage, seo_content, telLink...)
│   └── Models/                  # 8 Eloquent Models (Category, Post, User,...)
├── bootstrap/
│   └── app.php                  # Cấu hình Routing, Middleware alias ('admin')
├── config/
│   ├── database.php
│   ├── seo.php                  # Cấu hình SEO & Branding công ty
│   └── upload.php               # Cấu hình thư mục upload
├── docs/converts/               # Tài liệu & Checklist chuyển đổi
├── public/                      # Static assets (home, admin, assets, uploads)
├── resources/views/             # Toàn bộ Blade templates
├── routes/
│   ├── admin.php                # Tuyến quản trị dashboard
│   ├── console.php
│   └── web.php                  # Tuyến public
└── storage/app/public/uploads/  # Kho dữ liệu ảnh upload
```

---

## IV. LỘ TRÌNH THỰC HIỆN CHI TIẾT (6 GIAI ĐOẠN)

### Giai đoạn 1: Thiết lập Nền tảng & Cấu hình Hạ tầng
* **Mục tiêu:** Đảm bảo framework Laravel 11/13 khởi động chuẩn trên PHP 8.3, kết nối thông suốt với DB cũ.
* **Các bước triển khai:**
  1. Cấu hình `.env`:
     - Thiết lập kết nối MySQL trỏ trực tiếp đến Database hiện tại của `VIT2018`.
     - Cấu hình `APP_URL`, `APP_ENV=local`, `APP_DEBUG=true`.
     - Bổ sung cấu hình bổ trợ: `APP_DIR_IMAGE=storage/app/public/uploads/product`, `SEO_BASE_URL`.
  2. Cập nhật `composer.json`:
     - Bổ sung `"files": ["app/Library/Functions.php"]` vào phần `autoload`.
     - Chạy `composer dump-autoload` để nhận diện hàm toàn cục.
  3. Cấu hình symbolic link:
     - Chạy `php artisan storage:link` để ánh xạ thư mục ảnh sang `public/storage`.
  4. Cấu hình `bootstrap/app.php`:
     - Đăng ký alias middleware `'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class`.
     - Cấu hình load các file route `routes/web.php` và `routes/admin.php`.

### Giai đoạn 2: Tinh chỉnh Tầng Dữ liệu (Eloquent Models)
* **Mục tiêu:** 8 Models hoạt động chuẩn xác với Eloquent mới, không sinh lỗi deprecation.
* **Danh sách file rà soát:**
  1. `app/Models/User.php`: Kiểm tra implements `Authenticatable`, hàm `isAdmin()`.
  2. `app/Models/Category.php`: Quan hệ `hasMany(Post::class)`, các hàm cây danh mục, hàm `linkRootId()`.
  3. `app/Models/Post.php`:
     - Chuyển `protected $dates = ['deleted_at']` sang `protected $casts = ['deleted_at' => 'datetime', ...]`.
     - Kiểm tra các query scope `scopePublished` và các static helpers (`getListForAdmin`, `getPostByCateId`, `getRandomDocuments`).
  4. `app/Models/Images.php`: Quan hệ `belongsTo(Post::class)`.
  5. `app/Models/Setting.php`: Các hàm lấy cài đặt hotline, công ty.
  6. `app/Models/Slide.php`: Xử lý banner trang chủ.
  7. `app/Models/Tag.php` & `app/Models/Post_Tag.php`: Quản lý thẻ tag.

### Giai đoạn 3: Hệ thống Xác thực & Phân quyền (Auth & Middleware)
* **Mục tiêu:** Hệ thống đăng nhập Admin an toàn, tương thích session PHP 8.3.
* **Các bước triển khai:**
  1. Xây dựng phương thức xác thực chuẩn trong `LoginController.php` & `HomeController.php`:
     - Tuyến GET `login` hiển thị form đăng nhập.
     - Tuyến POST `login` xử lý qua `Auth::attempt(['username' => $username, 'password' => $password])` hoặc email.
     - Tuyến POST `logout` gọi `Auth::logout()`, invalidate session và regenerate token.
  2. Tinh chỉnh `EnsureUserIsAdmin.php`:
     - Kiểm tra trạng thái đăng nhập và quyền hạn user (`isAdmin()`).
     - Redirect về `login` kèm thông báo flash message chuẩn nếu không hợp lệ.

### Giai đoạn 4: Refactor Controller & Logic Nghiệp vụ
* **Mục tiêu:** Toàn bộ Controller chạy mượt mà, không sử dụng helper deprecated, upload file chuẩn.
* **Các bước triển khai:**
  1. **Frontend Controllers:**
     - `HomeController.php`: Trang chủ, danh mục sản phẩm, chi tiết sản phẩm, giới thiệu, dự án, tài liệu, bảo hành, tìm kiếm.
     - `SitemapController.php`: Render sitemap XML động với định dạng chuẩn, tương thích kiểu dữ liệu trả về `Response::make(..., 200, ['Content-Type' => 'text/xml'])`.
  2. **Admin Controllers:**
     - `AdminController.php`: Dashboard thống kê.
     - `CateController.php`: CRUD danh mục sản phẩm, dự án, tin tức, tài liệu.
     - `ProductController.php`: Quản lý sản phẩm & sản phẩm liên kết, tải lên nhiều ảnh kèm sắp xếp thứ tự.
     - `ProjectController.php`: CRUD dự án.
     - `DocumentController.php`: CRUD tài liệu, catalogue, bảng báo giá.
     - `NewController.php`: CRUD bài viết tin tức, trang tĩnh (giới thiệu, chính sách).
     - `CommonController.php`: Quản lý hotline, thông tin công ty, slide banner.
  3. **File Upload & Image Resizing:**
     - Kiểm tra hàm `resize_uploaded_image()` trong `app/Library/Functions.php` trên extension GD của PHP 8.3.
     - Đảm bảo quyền ghi (write permission) thư mục `storage/app/public/uploads`.

### Giai đoạn 5: Tầng Giao diện & Định tuyến (Routes & Blade Views)
* **Mục tiêu:** Giao diện hiển thị sắc nét, chuẩn SEO, không lỗi 500 Blade template.
* **Các bước triển khai:**
  1. Chuẩn hóa `routes/web.php` & `routes/admin.php`:
     - Sử dụng cú pháp Controller đầy đủ hoặc đặt trong namespace chuẩn.
     - Rà soát thứ tự route (route cụ thể đặt trước route catch-all `{id}/{title}`).
  2. Rà soát Blade Templates (`resources/views/`):
     - Kiểm tra các directive `@csrf`, `@method` trong form.
     - Kiểm tra các hàm helper SEO: `seo_content()`, `seo_canonical()`, `asset_v()`, `getImage()`.
     - Đảm bảo hiển thị phân trang (`{{ $data->links() }}`) tương thích Bootstrap 4 trong Laravel 11/13 (`Paginator::useBootstrapFour()`).
  3. Kiểm tra Assets tĩnh:
     - Đảm bảo CSS, JS, Fonts trong `public/home/`, `public/admin/`, `public/assets/` nạp đầy đủ.

### Giai đoạn 6: Kiểm thử Toàn diện (Testing), UAT & Kế hoạch Rollout
* **Mục tiêu:** Đảm bảo hệ thống đạt độ tin cậy 100% trước khi đưa lên Hosting PHP 8.3.
* **Các kịch bản kiểm thử:**
  1. **Kiểm thử Public:**
     - Trang chủ nạp đủ slide, danh mục, sản phẩm nổi bật, tin tức, tài liệu.
     - Trang danh mục và trang chi tiết sản phẩm hiển thị đầy đủ hình ảnh, mô tả, thẻ meta SEO, schema JSON-LD.
     - Tính năng tìm kiếm sản phẩm hoạt động chính xác.
     - Đường dẫn `/sitemap.xml` trả về XML hợp lệ, HTTP status 200.
  2. **Kiểm thử Quản trị (Admin):**
     - Đăng nhập/Đăng xuất thành công.
     - Thêm mới, chỉnh sửa, xóa sản phẩm kèm upload ảnh (kiểm tra ảnh có thu nhỏ và lưu đúng thư mục không).
     - Thêm/sửa danh mục, hotline, thông tin liên hệ.
  3. **Kế hoạch Rollout lên Hosting:**
     - Bước 1: Sao lưu mã nguồn và cơ sở dữ liệu trên Hosting.
     - Bước 2: Nâng cấp PHP trên Hosting lên phiên bản 8.3.
     - Bước 3: Đưa bộ mã nguồn `VIT2018_v11` lên hosting.
     - Bước 4: Thiết lập file `.env` production (`APP_DEBUG=false`, `APP_ENV=production`).
     - Bước 5: Chạy các lệnh tối ưu hóa:
       ```bash
       php artisan config:cache
       php artisan route:cache
       php artisan view:cache
       php artisan storage:link
       ```
     - Bước 6: Smoke test trên tên miền chính thức.

---

## V. QUẢN LÝ RỦI RO & PHƯƠNG ÁN DỰ PHÒNG (FALLBACK)

1. **Rủi ro lỗi cú pháp Blade / Helper chưa tương thích:**
   - *Biện pháp:* Bật `APP_DEBUG=true` trong quá trình dev local, kiểm tra log tại `storage/logs/laravel.log`.
2. **Rủi ro ảnh không hiển thị sau khi chuyển đổi:**
   - *Biện pháp:* Đã copy toàn bộ dữ liệu ảnh sang cả `public/` và `storage/app/public/`. Luôn đảm bảo `php artisan storage:link` đã được khởi tạo.
3. **Rủi ro rollback nếu hosting gặp sự cố:**
   - *Biện pháp:* Thư mục dự án cũ `VIT2018` vẫn được giữ nguyên độc lập. Nếu phát sinh lỗi ngoài dự kiến trên hosting, chỉ cần hạ PHP về bản cũ và trỏ lại thư mục nguồn `VIT2018` trong vòng 2 phút.
