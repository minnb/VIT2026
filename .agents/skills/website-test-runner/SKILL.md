---
name: website-test-runner
description: >-
  Kỹ năng tự động kiểm thử toàn diện (Smoke Test, Regression Test & Live Apache HTTP Test) cho website VIT2018_v11 trên nền tảng Laravel 11/13 và PHP 8.3: kiểm tra kết nối Database MySQL, toàn bộ routes Public/Admin, Dynamic Product/Category pages, chức năng tìm kiếm sản phẩm, giao diện quản trị Admin, định dạng XML Sitemap, static assets, SEO tags và kết nối Apache thực tế.
---

# Website Automated Test Runner Skill

Kỹ năng này cung cấp quy trình và kịch bản kiểm thử tự động toàn diện cho dự án **VIT2018_v11** chạy trên PHP 8.3 và Laravel 11/13.

## Cách chạy kiểm thử nhanh

Có thể thực thi trực tiếp qua lệnh PowerShell hoặc PHP CLI từ bất kỳ thư mục nào:

```powershell
php C:\xampp\htdocs\projects\VIT2018_v11\.agents\skills\website-test-runner\scripts\run-smoke-tests.php
```

Hoặc khi đang ở thư mục workspace `C:\xampp\htdocs\projects\VIT2018`:
```powershell
php .agents/skills/website-test-runner/scripts/run-smoke-tests.php
```

---

## 7 Nhóm kiểm thử (Test Suites)

### 1. Database & Eloquent Models
- **MySQL Connection**: Kiểm tra kết nối PDO tới database `vitduct`.
- **Model Posts**: Đếm số bài viết (`Post::count()`) và kiểm tra `published()` scope.
- **Model Categories**: Kiểm tra bảng danh mục sản phẩm/dự án (`Category::count()`).
- **Model Settings**: Kiểm tra cấu hình số hotline và công ty (`Setting::getHotline()`).
- **Model Slides**: Kiểm tra danh sách banner trình chiếu (`Slide::active()`).

### 2. HTTP Routes & View Rendering (Laravel Kernel)
- `GET /`: Trang chủ (HTTP 200).
- `GET /san-pham`: Danh sách sản phẩm (HTTP 200).
- `GET /du-an`: Danh sách dự án (HTTP 200).
- `GET /bao-gia-catalog-san-pham`: Tài liệu báo giá (HTTP 200).
- `GET /gioi-thieu-vitduct`: Giới thiệu công ty (HTTP 200).
- `GET /chinh-sach-bao-hanh-doi-tra`: Chính sách bảo hành (HTTP 200).
- `GET /chinh-sach-bao-mat`: Chính sách bảo mật (HTTP 200).
- `GET /sitemap.xml`: XML Sitemap động (HTTP 200, chứa `<urlset>`).
- `GET /login`: Form đăng nhập trang quản trị (HTTP 200).
- `GET /dashboard`: Tuyến bảo vệ Admin Auth Guard (HTTP 302 chuyển hướng về `/login`).

### 3. Dynamic Product & Category Pages
- **Dynamic Product Detail Page**: Truy vấn sản phẩm thực tế từ Database, mã hóa ID bằng `fencrypt()`, tạo URL chuẩn SEO `route('get.product.single', ['id' => ..., 'name' => ...])` và kiểm tra render view chi tiết (HTTP 200).
- **Dynamic Category Page**: Truy vấn danh mục thực tế từ Database, tạo URL `route('get.product.cate', ['id' => ..., 'name' => ...])` và kiểm tra render view danh mục (HTTP 200).

### 4. Search & CSRF Form Handling
- `POST /result`: Kiểm tra tính năng tìm kiếm sản phẩm với từ khóa tiếng Việt có dấu, xác thực CSRF Token và Session Store.

### 5. Admin Authenticated Views
- **Admin Dashboard View**: Render view tổng quan (`/dashboard`).
- **Admin Product List View**: Render view danh sách sản phẩm (`/dashboard/lists/products`).
- **Admin Add Product Form**: Render view form thêm mới sản phẩm (`/dashboard/add/product`).
- **Admin Category List View**: Render view danh mục sản phẩm (`/dashboard/cate/product/lists`).
- **Admin Slides Management View**: Render view quản lý banner (`/dashboard/setting/slide/list`).

### 6. Assets & SEO Integrity
- **Static CSS Files**: Kiểm tra sự tồn tại của `style.css` và `vit-ui.css`.
- **Media Symlink & Uploads**: Kiểm tra liên kết thư mục `public/storage` và thư mục hình ảnh uploads `storage/app/public/uploads`.
- **SEO Meta Tags**: Kiểm tra thẻ `<title>`, `<meta name="description">`, `<link rel="canonical">`, và OpenGraph (`og:title`) trên trang chủ.

### 7. Live Apache Web Server (End-to-End)
- Kiểm tra cổng 80 Apache XAMPP.
- Thực hiện HTTP request trực tiếp tới `http://localhost/projects/VIT2018_v11/public/` để kiểm tra toàn bộ pipeline: Apache Web Server -> mod_php / PHP 8.3 TS -> MySQL -> Blade Compiler.

---

## Tiêu chí Đạt chuẩn (Acceptance Criteria)
- Tất cả 7 Test Suites đều trả về **PASSED** (0 Failed).
- Mã thoát (exit code) là `0`.
- Báo cáo kết quả đầy đủ cho người dùng trước khi bàn giao bất kỳ tính năng nào.
