# DANH MỤC KIỂM TRA CHUYỂN ĐỔI (MIGRATION CHECKLIST)
**Dự án:** VIT2018 -> VIT2018_v11  
**Target:** Laravel 11/13 | PHP 8.3 | MySQL  
**Trạng thái cập nhật:** 07/10/2026  

---

## 📌 HƯỚNG DẪN SỬ DỤNG
* Đánh dấu `[x]` vào các mục đã hoàn thành và kiểm thử thành công.
* Giữ nguyên `[ ]` cho các mục đang thực hiện hoặc chờ xử lý.
* Ghi chú ngày hoàn thành và người thực hiện (Dev/Tech Lead) vào cột tương ứng.

---

## 🚀 GIAI ĐOẠN 1: THIẾT LẬP NỀN TẢNG & CẤU HÌNH HẠ TẦNG

- [x] **1.1. Khởi tạo khung dự án Laravel 11/13 mới**
  - Thư mục: `C:\xampp\htdocs\projects\VIT2018_v11`
  - Phiên bản Framework: Laravel 11x / 13x
- [x] **1.2. Sao chép tài nguyên & media tĩnh**
  - Copy toàn bộ dữ liệu ảnh `storage/app/public/uploads`
  - Copy thư mục tĩnh `public/assets`, `public/home`, `public/image`, `public/images`, `public/svg`
- [x] **1.3. Cài đặt hệ thống Rule & Agent Customization**
  - Cấu hình file `CLAUDE.md` ngữ cảnh multi-root
  - Cấu hình Rule `.agents/rules/laravel11-migration.md`
  - Cấu hình Skills `.agents/skills/laravel5-to-11-migrator` & `seo-and-view-verifier`
- [x] **1.4. Thiết lập tài liệu & kế hoạch chuyển đổi**
  - Tạo `docs/converts/MIGRATION_PLAN.md`
  - Tạo `docs/converts/CHECKLIST.md`
- [x] **1.5. Cấu hình file `.env` kết nối Database**
  - Trỏ `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` về MySQL hiện tại
  - Khai báo `APP_DIR_IMAGE=storage/app/public/uploads/product`
  - Khai báo `SEO_BASE_URL`
- [x] **1.6. Đăng ký Autoload Custom Helper**
  - Bổ sung `"files": ["app/Library/Functions.php"]` vào `composer.json`
  - Chạy `composer dump-autoload`
- [x] **1.7. Cấu hình Symbolic Link cho Media**
  - Chạy lệnh `php artisan storage:link`
- [x] **1.8. Cấu hình `bootstrap/app.php`**
  - Đăng ký alias middleware `'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class`
  - Cấu hình tuyến web và console

---

## 🗄️ GIAI ĐOẠN 2: TINH CHỈNH TẦNG DỮ LIỆU (ELOQUENT MODELS)

- [x] **2.1. Model `app/Models/User.php`**
  - Kiểm tra trait Authenticatable, hàm kiểm tra quyền `isAdmin()`
- [x] **2.2. Model `app/Models/Category.php`**
  - Kiểm tra quan hệ `hasMany(Post::class)`, danh mục cha/con, hàm `linkRootId()`
- [x] **2.3. Model `app/Models/Post.php`**
  - Chuyển `protected $dates = ['deleted_at']` sang `protected $casts = ['deleted_at' => 'datetime']`
  - Kiểm tra scope `scopePublished()`
  - Kiểm tra static helpers: `getListForAdmin()`, `getList()`, `getPostByCateId()`, `getRandomDocuments()`, `CountPostByCateId()`
- [x] **2.4. Model `app/Models/Images.php`**
  - Kiểm tra quan hệ `belongsTo(Post::class)`, trường `sort`
- [x] **2.5. Model `app/Models/Setting.php`**
  - Rà soát các hàm cấu hình hotline, công ty
- [x] **2.6. Model `app/Models/Slide.php`**
  - Rà soát hàm lấy danh sách banner trình chiếu
- [x] **2.7. Model `app/Models/Tag.php` & `app/Models/Post_Tag.php`**
  - Kiểm tra bảng liên kết thẻ bài viết

---

## 🔐 GIAI ĐOẠN 3: XÁC THỰC & PHÂN QUYỀN (AUTH & MIDDLEWARE)

- [x] **3.1. Tuyến đăng nhập / đăng xuất Quản trị**
  - Thiết lập tuyến GET `login` qua `HomeController@getLogin`
  - Thiết lập tuyến POST `login` xử lý đăng nhập qua `Auth::attempt`
  - Thiết lập tuyến POST `logout` xử lý đăng xuất an toàn (invalidate session, CSRF refresh)
- [x] **3.2. Controller `app/Http/Controllers/Auth/LoginController.php`**
  - Refactor loại bỏ phụ thuộc vào trait cũ `AuthenticatesUsers`
- [x] **3.3. Middleware `app/Http/Middleware/EnsureUserIsAdmin.php`**
  - Kiểm tra session đăng nhập và vai trò quản trị
  - Xử lý redirect và flash message khi không đủ quyền
- [x] **3.4. Kiểm thử đăng nhập thực tế**
  - Đăng nhập thử bằng tài khoản Admin sẵn có trong DB

---

## ⚙️ GIAI ĐOẠN 4: REFACTOR CONTROLLERS & LOGIC NGHIỆP VỤ

### Frontend Controllers:
- [x] **4.1. `app/Http/Controllers/HomeController.php`**
  - Trang chủ (`index`), danh mục sản phẩm (`getProductByCate`)
  - Chi tiết sản phẩm (`getProductSingle`), dự án (`getProject`)
  - Báo giá & tài liệu (`getDocument`), giới thiệu (`getAbout`)
  - Chính sách bảo hành/bảo mật, form tìm kiếm (`postSearch`)
- [x] **4.2. `app/Http/Controllers/SitemapController.php`**
  - Render sitemap XML động với định dạng chuẩn `Response::make()`

### Admin Controllers:
- [x] **4.3. `app/Http/Controllers/Admin/AdminController.php`**
  - Dashboard tổng quan hệ thống
- [x] **4.4. `app/Http/Controllers/Admin/CateController.php`**
  - CRUD danh mục: sản phẩm, dự án, tài liệu, tin tức
- [x] **4.5. `app/Http/Controllers/Admin/ProductController.php`**
  - Danh sách sản phẩm, thêm mới, sửa, xóa
  - Sản phẩm liên kết, upload nhiều ảnh kèm sắp xếp thứ tự
- [x] **4.6. `app/Http/Controllers/Admin/ProjectController.php`**
  - CRUD dự án thi công
- [x] **4.7. `app/Http/Controllers/Admin/DocumentController.php`**
  - CRUD tài liệu, catalogue, bảng báo giá
- [x] **4.8. `app/Http/Controllers/Admin/NewController.php`**
  - CRUD bài viết tin tức, giới thiệu, chính sách
- [x] **4.9. `app/Http/Controllers/Admin/CommonController.php`**
  - Quản lý hotline, thông tin doanh nghiệp, slide banner
- [x] **4.10. Thư viện xử lý ảnh `resize_uploaded_image()`**
  - Kiểm tra tương thích extension GD trên PHP 8.3

---

## 🎨 GIAI ĐOẠN 5: ĐỊNH TUYẾN, BLADE VIEWS & CHUẨN SEO

- [x] **5.1. Định tuyến `routes/web.php` & `routes/admin.php`**
  - Chuẩn hóa cú pháp route, đảm bảo không trùng lặp prefix
- [x] **5.2. Cấu hình phân trang Bootstrap 4**
  - Đăng ký `\Illuminate\Pagination\Paginator::useBootstrapFour()` trong `AppServiceProvider.php`
- [x] **5.3. Blade Views Public**
  - Layout chính `layouts/home.blade.php`
  - Kiểm tra nạp thẻ Canonical `seo_canonical()`, Meta Description `seo_description()`
  - Kiểm tra hàm render nội dung SEO `seo_content()`
- [x] **5.4. Blade Views Admin**
  - Kiểm tra layout quản trị, form nhập liệu, CKEditor
  - Kiểm tra directive `@csrf` trên mọi form POST
- [x] **5.5. Static Assets**
  - Kiểm tra CSS, JS, hình ảnh, icon nạp đầy đủ (HTTP status 200)

---

## 🧪 GIAI ĐOẠN 6: KIỂM THỬ TOÀN DIỆN & DEPLOYMENT READY

### Kiểm thử Giao diện Public:
- [ ] **6.1. Trang chủ** (Slide banner, menu danh mục, sản phẩm nổi bật, tin tức, footer)
- [ ] **6.2. Trang danh mục sản phẩm** (Hiển thị lưới sản phẩm, phân trang)
- [ ] **6.3. Trang chi tiết sản phẩm** (Thông tin kỹ thuật, thư viện ảnh phóng to, sản phẩm liên quan)
- [ ] **6.4. Trang Dự án & Tài liệu** (Hiển thị danh sách và tải file đính kèm)
- [ ] **6.5. Tìm kiếm sản phẩm** (Tìm theo từ khóa)
- [ ] **6.6. Đường dẫn `/sitemap.xml`** (Định dạng XML chuẩn)

### Kiểm thử Khu Quản trị (Admin):
- [ ] **6.7. Đăng nhập / Đăng xuất Admin**
- [ ] **6.8. Thêm mới / Chỉnh sửa / Xóa Sản phẩm** kèm upload hình ảnh
- [ ] **6.9. Thêm mới / Chỉnh sửa Danh mục**
- [ ] **6.10. Cập nhật Hotline & Thông tin Công ty**

### Chuẩn bị Triển khai Hosting PHP 8.3:
- [ ] **6.11. Chạy lệnh tối ưu hóa hiệu năng**:
  - `php artisan config:cache`
  - `php artisan route:cache`
  - `php artisan view:cache`
- [ ] **6.12. Soát lỗi trong `storage/logs/laravel.log`** (Không còn Warning/Error PHP 8.3)
- [ ] **6.13. Đóng gói mã nguồn và sẵn sàng deploy**
