---
name: website-test-runner
description: >-
  Kỹ năng tự động chạy kiểm thử toàn diện (Smoke Test & Regression Test) cho website VIT2018_v11: kiểm tra kết nối Database, tất cả routes Public/Admin, Dynamic Product/Category pages, định dạng XML Sitemap, static assets và chuẩn SEO.
---

# Website Automated Test Runner Skill

Kỹ năng này cung cấp quy trình và kịch bản kiểm thử tự động cho dự án VIT2018_v11 trên nền tảng Laravel 11/13 và PHP 8.3.

## Cách chạy kiểm thử nhanh

Chạy script test thông qua PHP CLI:

```powershell
php .agents/skills/website-test-runner/scripts/run-smoke-tests.php
```

## Các hạng mục được kiểm thử tự động

1. **Database & Model Layer**:
   - Kiểm tra kết nối PDO MySQL tới database `vitduct`.
   - Kiểm tra số lượng bài viết `Post::count()` và scope `published()`.
   - Kiểm tra bảng danh mục `Category::count()`.
   - Kiểm tra dữ liệu cài đặt `Setting::getHotline()`.
   - Kiểm tra danh sách banner `Slide::active()`.

2. **Routes & Views (HTTP Kernel)**:
   - Trang chủ (`/`) - HTTP 200.
   - Trang danh sách sản phẩm (`/san-pham`) - HTTP 200.
   - Trang danh sách dự án (`/du-an`) - HTTP 200.
   - Trang tài liệu kỹ thuật (`/bao-gia-catalog-san-pham`) - HTTP 200.
   - Trang giới thiệu (`/gioi-thieu-vitduct`) - HTTP 200.
   - Trang chính sách bảo hành (`/chinh-sach-bao-hanh-doi-tra`) - HTTP 200.
   - Trang chính sách bảo mật (`/chinh-sach-bao-mat`) - HTTP 200.
   - Trang XML Sitemap (`/sitemap.xml`) - HTTP 200 kèm cấu trúc `<urlset>`.
   - Trang đăng nhập quản trị (`/login`) - HTTP 200.
   - Tuyến bảo vệ Admin (`/dashboard`) - HTTP 302 chuyển hướng về `/login`.

3. **Dynamic Pages**:
   - Trang chi tiết sản phẩm động: Kiểm tra resolve URL mã hóa `fencrypt()`, lấy dữ liệu và render view chi tiết.
   - Trang danh mục sản phẩm động: Kiểm tra hiển thị danh mục theo ID mã hóa.

4. **Assets & SEO Integrity**:
   - Kiểm tra tồn tại của các file CSS core (`style.css`, `vit-ui.css`).
   - Kiểm tra symbolic link `public/storage` và thư mục uploads.
   - Kiểm tra thẻ SEO `<title>`, `<meta name="description">`, `<link rel="canonical">`, OpenGraph trên HTML output.