# CLAUDE.md — Gatekeeper (Laravel 11 / PHP 8.3)

## Ngữ cảnh Dự án Multi-root
- Dự án mới: **VIT2018_v11** (C:\xampp\htdocs\projects\VIT2018_v11) — Laravel 11/13, PHP 8.3
- Dự án gốc tham chiếu: **VIT2018** (C:\xampp\htdocs\projects\VIT2018) — Laravel 5.7, PHP 7.1

## Tech Stack
| Thành phần | Version |
|---|---|
| Framework | **Laravel 11x / 13x** |
| PHP Target | **PHP 8.3** |
| Database | MySQL — Eloquent ORM (Dùng chung với VIT2018) |
| Frontend | Blade Views, Bootstrap 4, Vue.js |

## Quy tắc Chuyển đổi & Viết Code
1. Cú pháp PHP 8.3 & Laravel 11+: Không dùng helper bị khai tử (str_slug, rray_get). Dùng Str::slug(), Arr::get().
2. Eloquent Model: Thay protected  bằng protected  = ['deleted_at' => 'datetime'].
3. Tuân thủ MVC & PSR-12: Logic nghiệp vụ đặt ở Model/Service, Validate qua Request, không nhồi logic vào Blade.
4. Đảm bảo chuẩn SEO & Performance: Dùng seo_content(), sset_v(), seo_canonical() cho giao diện.
