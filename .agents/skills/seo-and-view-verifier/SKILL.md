---
name: seo-and-view-verifier
description: >-
  Kiểm tra và đảm bảo các tiêu chuẩn SEO, thẻ canonical, OpenGraph meta, schema JSON-LD và tối ưu hóa ảnh cho giao diện Blade.
---

# SEO and View Verifier Skill

Dùng kỹ năng này để kiểm tra và tối ưu file Blade views trong dự án VIT2018_v11.

## Đánh giá SEO bắt buộc
1. Thẻ <title>: Luôn chứa tên sản phẩm/bài viết + suffix tên công ty từ config('seo.title_suffix').
2. Thẻ Canonical: Đảm bảo sử dụng helper seo_canonical() hoặc seo_current_url().
3. Thẻ Meta Description: Dùng seo_description().
4. Ảnh nội dung: Đi qua helper seo_content() để tự động gắn loading="lazy" và decoding="async".
