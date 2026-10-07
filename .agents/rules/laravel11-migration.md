# Quy Tắc Chuyển Đổi Dự Án VIT2018 (Laravel 5.7 -> Laravel 11/13)

## 1. Ngữ Cảnh Dự Án Multi-root
- **Dự án gốc**: C:\xampp\htdocs\projects\VIT2018 (Laravel 5.7, PHP 7.1)
- **Dự án mới**: C:\xampp\htdocs\projects\VIT2018_v11 (Laravel 11/13, PHP 8.3)
- **Database & Media**: Dùng chung Database MySQL và giữ nguyên toàn bộ file đính kèm trong storage/app/public/uploads/.

## 2. Quy Tắc Code PHP 8.3 & Laravel 11/13
- Không sử dụng các helper function bị gỡ bỏ của Laravel cũ:
  - Thay str_slug() bằng \Illuminate\Support\Str::slug()
  - Thay rray_get(, 'key') bằng \Illuminate\Support\Arr::get(, 'key')
- Trong Eloquent Models:
  - Thay protected  = ['deleted_at']; bằng protected  = ['deleted_at' => 'datetime'];
- Đảm bảo giữ nguyên các helper trong pp/Library/Functions.php (getImage(), sset_v(), seo_content(), 	elLink()).
