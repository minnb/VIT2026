{{-- $com, $man được cung cấp bởi App\Providers\ViewComposerServiceProvider --}}
{{-- Mọi giá trị SEO lấy từ config/seo.php, trang con ghi đè bằng @section. Xem .claude/rules/seo-standards.md --}}
@php
    // Laravel escape san noi dung cua @section('x', 'gia tri') dang mot dong (Factory::startSection goi e()).
    // Giai ma nguoc mot lan de {{ }} ben duoi khong escape lan hai (loi &amp;amp;).
    $seoValue = function ($section) use ($__env) {
        return trim(html_entity_decode($__env->yieldContent($section), ENT_QUOTES, 'UTF-8'));
    };

    $seoSuffix    = config('seo.title_suffix');
    $seoTitle     = $seoValue('title');
    $seoFull      = $seoTitle !== '' ? $seoTitle . ' | ' . $seoSuffix : config('seo.default_title');
    $seoDesc      = $seoValue('meta_description') ?: config('seo.default_description');

    // Canonical luon dung ten mien chinh thuc (config/seo.php) de tranh trung lap
    // giua www/non-www, http/https hoac truy cap bang IP.
    $seoCanonical = $seoValue('canonical') ?: seo_current_url();

    $seoRobots    = $seoValue('robots') ?: 'index,follow';
    $seoOgType    = $seoValue('og_type') ?: 'website';
    $seoOgTitle   = $seoValue('og_title') ?: $seoFull;
    $seoOgDesc    = $seoValue('og_description') ?: $seoDesc;
    $seoOgImage   = seo_abs($seoValue('og_image') ?: config('seo.default_og_image'));
@endphp
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icons/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/icons/favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/icons/apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<meta name="theme-color" content="#2F5085">
<meta name="msapplication-TileColor" content="#2F5085">
<meta name="msapplication-TileImage" content="{{ asset('assets/icons/android-chrome-192x192.png') }}">

<title>{{ $seoFull }}</title>
<meta name="description" content="{{ $seoDesc }}">
<meta name="robots" content="{{ $seoRobots }}">
<link rel="canonical" href="{{ $seoCanonical }}">
<meta name="author" content="{{ config('seo.organization.legal_name') }}">
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-title" content="{{ config('seo.brand') }}"/>

<!-- OPEN GRAPH / FACEBOOK -->
<meta property="fb:app_id" content="{{ config('seo.fb_app_id') }}"/>
<meta property="og:site_name" content="{{ config('seo.organization.legal_name') }}"/>
<meta property="og:locale" content="vi_VN"/>
<meta property="og:type" content="{{ $seoOgType }}"/>
<meta property="og:url" content="{{ $seoCanonical }}"/>
<meta property="og:title" content="{{ $seoOgTitle }}"/>
<meta property="og:description" content="{{ $seoOgDesc }}"/>
<meta property="og:image" content="{{ $seoOgImage }}"/>
<meta property="og:image:width" content="{{ config('seo.og_image_width') }}"/>
<meta property="og:image:height" content="{{ config('seo.og_image_height') }}"/>

<!-- TWITTER CARD -->
<meta name="twitter:card" content="{{ config('seo.twitter_card') }}"/>
<meta name="twitter:title" content="{{ $seoOgTitle }}"/>
<meta name="twitter:description" content="{{ $seoOgDesc }}"/>
<meta name="twitter:image" content="{{ $seoOgImage }}"/>

@include('home.partials.jsonld')
@stack('jsonld')

<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
<link rel="dns-prefetch" href="https://www.google-analytics.com">
<link rel="dns-prefetch" href="https://sp.zalo.me">
{{-- Gan ?v=<thoi diem sua file> de trinh duyet khong dung ban CSS cu trong cache --}}
<link rel="stylesheet" href="{{ asset_v('home/style.css') }}">
<link rel="stylesheet" href="{{ asset_v('home/css/vit-ui.css') }}">
@stack('styles')

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-173467050-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-173467050-1');
</script>
</head>
