# HƯỚNG DẪN TRIỂN KHAI DỰ ÁN VIT2018_V11 LÊN HOSTING / SERVER PHP 8.3

Tài liệu này hướng dẫn chi tiết quy trình đưa mã nguồn website **VIT2018_v11** (nâng cấp từ Laravel 5.7 lên Laravel 11/13, chạy trên PHP 8.3) lên môi trường Production (cPanel, DirectAdmin, hoặc VPS Linux).

---

## 1. YÊU CẦU MÔI TRƯỜNG SERVER / HOSTING

* **PHP**: Phiên bản **8.3.x** trở lên.
* **PHP Extensions bắt buộc**:
  * `pdo_mysql`, `mysqli`
  * `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `curl`
  * `gd` hoặc `imagick` (để xử lý nén/resize ảnh sản phẩm)
  * `fileinfo` (để kiểm tra định dạng file upload)
* **MySQL / MariaDB**: Phiên bản MySQL 5.7+ hoặc MariaDB 10.3+ (khớp với DB `vitduct` hiện tại).
* **Web Server**: Apache 2.4 (kèm `mod_rewrite`) hoặc Nginx.

---

## 2. QUY TRÌNH TRIỂN KHAI TỪNG BƯỚC

### Bước 1: Sao lưu dữ liệu & Chuẩn bị Hosting
1. Backup toàn bộ cơ sở dữ liệu `vitduct` hiện tại (file `.sql`).
2. Trên hosting, chuyển đổi phiên bản PHP của tên miền sang **PHP 8.3**.
3. Bật đầy đủ các extension PHP cần thiết: `gd`, `fileinfo`, `mbstring`, `pdo_mysql`, `curl`, `openssl`.

### Bước 2: Tải mã nguồn lên Hosting
1. Đóng gói thư mục `C:\xampp\htdocs\projects\VIT2018_v11` thành file `.zip`:
   * **Bao gồm**: `app/`, `bootstrap/`, `config/`, `database/`, `public/`, `resources/`, `routes/`, `storage/`, `vendor/`, `composer.json`, `.env.example`.
   * **Bỏ qua (không cần nén)**: thư mục `.git/`, `.agents/`, `docs/`, `tests/`.
2. Tải file `.zip` lên hosting và giải nén.
3. Cấu hình thư mục gốc (Document Root) của Domain/Subdomain:
   * **Document Root PHẢI trỏ vào thư mục**: `public/` của dự án (ví dụ: `/home/username/public_html` trỏ tới `/home/username/VIT2018_v11/public`).

### Bước 3: Cấu hình File `.env` Production
Tạo file `.env` tại thư mục gốc của dự án trên hosting với nội dung:

```ini
APP_NAME=Vitduct
APP_ENV=production
APP_KEY=base64:feF7PtIwMip9ngrOEuUUVSpL0pOtoLAKNrFIureOz/Q=
APP_DEBUG=false
APP_URL=https://vitduct.com.vn

LOG_CHANNEL=daily

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ten_database_tren_hosting
DB_USERNAME=ten_user_tren_hosting
DB_PASSWORD=mat_khau_db_tren_hosting

BROADCAST_DRIVER=log
CACHE_STORE=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

SEO_BASE_URL=https://vitduct.com.vn
APP_DIR_IMAGE=storage/app/public/uploads/product
```

> **LƯU Ý QUAN TRỌNG**:
> * `APP_DEBUG=false` để bảo mật thông tin khi chạy thực tế.
> * `CACHE_STORE=file` và `SESSION_DRIVER=file` tuyệt đối không đổi sang `database` để không bị phụ thuộc vào bảng cache/sessions.

### Bước 4: Tạo Symbolic Link cho Media & Phân quyền Thư mục
1. Tạo symbolic link cho thư mục media:
   ```bash
   php artisan storage:link
   ```
   (Nếu hosting chặn hàm `symlink`, có thể tạo symlink thủ công từ cPanel Terminal hoặc dùng PHP script gọi `symlink()`).
2. Phân quyền ghi dữ liệu (Writable Permissions):
   * Thư mục `storage/` và tất cả thư mục con: `chmod -R 775 storage/`
   * Thư mục `bootstrap/cache/`: `chmod -R 775 bootstrap/cache/`

### Bước 5: Chạy Tối ưu hóa Hiệu năng (Production Optimization)
Chạy các lệnh Artisan sau qua SSH / Terminal:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 3. CHECKLIST KIỂM TRA SAU KHI ĐƯA LÊN HOSTING (SMOKE TEST)

* [ ] Truy cập trang chủ `https://vitduct.com.vn/` - hiển thị slide banner, hotline, danh mục sản phẩm.
* [ ] Kiểm tra ảnh sản phẩm hiển thị sắc nét từ đường dẫn `/storage/uploads/...`.
* [ ] Kiểm tra các liên kết danh mục và chi tiết sản phẩm chuẩn SEO (không lỗi 500).
* [ ] Truy cập `https://vitduct.com.vn/sitemap.xml` - trả về chuẩn XML hợp lệ.
* [ ] Truy cập `https://vitduct.com.vn/login` - đăng nhập thử tài khoản Admin.
* [ ] Vào Dashboard Admin thêm mới / chỉnh sửa 1 bài viết thử nghiệm.
* [ ] Kiểm tra file `storage/logs/laravel.log` - xác nhận không có ngoại lệ hoặc lỗi phát sinh.
