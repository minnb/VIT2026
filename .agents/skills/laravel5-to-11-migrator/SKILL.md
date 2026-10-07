---
name: laravel5-to-11-migrator
description: >-
  Quy trình và danh sách kiểm tra (checklist) nâng cấp và porting code từ Laravel 5.7 (VIT2018) sang Laravel 11/13 (VIT2018_v11) chuẩn PHP 8.3.
---

# Laravel 5.7 to 11 Migration Skill

Kỹ năng này hướng dẫn quy trình chuyển đổi và đối chiếu code giữa hai dự án.

## Quy Trình Chuyển Đổi Từng Thành Phần

### 1. Eloquent Models
- Đọc file tương ứng tại C:\xampp\htdocs\projects\VIT2018\app\Models\<ModelName>.php.
- Kiểm tra các mối quan hệ elongsTo, hasMany.
- Chuyển khai báo $dates sang $casts.
- Đảm bảo giữ lại các custom static method như getListForAdmin(), getPostByCateId().

### 2. Controllers & Request Handling
- Đọc file tương ứng tại C:\xampp\htdocs\projects\VIT2018\app\Http\Controllers\.
- Đảm bảo tất cả validation dùng \Illuminate\Http\Request hoặc Form Request.
- Kiểm tra lại các hàm gọi edirect(), with() để đảm bảo flash message hiển thị đúng ở View.

### 3. Routes
- Khai báo route trong outes/web.php và outes/admin.php.
- Ưu tiên cú pháp Controller Class: Route::get('/path', [HomeController::class, 'method'])->name('route.name');.

### 4. Verification
- Chạy thử route hoặc kiểm tra cú pháp bằng php -l <filepath>.
