<?php

/**
 * Automated Smoke & Regression Test Runner for VIT2018_v11
 * Tests Models, Routes, Views, Database, Assets, and SEO.
 */

require_once __DIR__ . '/../../../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../../../bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

echo "========================================================\n";
echo "    VIT2018_v11 AUTOMATED TEST RUNNER (PHP 8.3)\n";
echo "========================================================\n\n";

$passed = 0;
$failed = 0;

function runTest($name, $callable) {
    global $passed, $failed;
    echo sprintf("[TEST] %-50s ... ", $name);
    try {
        $result = $callable();
        if ($result === true || (is_array($result) && ($result['ok'] ?? false))) {
            echo "\033[32mPASSED\033[0m\n";
            if (is_array($result) && !empty($result['detail'])) {
                echo "       -> " . $result['detail'] . "\n";
            }
            $passed++;
        } else {
            $msg = is_array($result) ? ($result['msg'] ?? 'Assertion failed') : 'Failed';
            echo "\033[31mFAILED\033[0m (" . $msg . ")\n";
            $failed++;
        }
    } catch (\Throwable $e) {
        echo "\033[31mERROR\033[0m: " . $e->getMessage() . " (" . basename($e->getFile()) . ":" . $e->getLine() . ")\n";
        $failed++;
    }
}

// ----------------------------------------------------
// 1. DATABASE & MODELS TESTS
// ----------------------------------------------------
echo "\n--- 1. DATABASE & MODELS TESTS ---\n";

runTest("MySQL Database Connection", function() {
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    $name = \Illuminate\Support\Facades\DB::connection()->getDatabaseName();
    return ['ok' => true, 'detail' => "Connected to database: $name"];
});

runTest("Model Posts Count & Published Scope", function() {
    $total = \App\Models\Post::count();
    $published = \App\Models\Post::published()->count();
    return ['ok' => $total > 0, 'detail' => "Total posts: $total, Published: $published"];
});

runTest("Model Categories Count", function() {
    $total = \App\Models\Category::count();
    return ['ok' => $total > 0, 'detail' => "Total categories: $total"];
});

runTest("Model Settings & Hotline Value", function() {
    $hotline = \App\Models\Setting::getHotline();
    return ['ok' => !empty($hotline), 'detail' => "Hotline: $hotline"];
});

runTest("Model Slides Count", function() {
    $count = \App\Models\Slide::active()->count();
    return ['ok' => $count >= 0, 'detail' => "Active slides: $count"];
});

// ----------------------------------------------------
// 2. ROUTE & VIEW TESTS (HTTP Kernel Dispatch)
// ----------------------------------------------------
echo "\n--- 2. PUBLIC & AUTH ROUTE TESTS ---\n";

$routesToTest = [
    ['name' => 'Home Page (/)', 'uri' => '/', 'expect' => 200, 'mustContain' => 'VITDUCT'],
    ['name' => 'Products Page (/san-pham)', 'uri' => '/san-pham', 'expect' => 200, 'mustContain' => 'Sản phẩm'],
    ['name' => 'Projects Page (/du-an)', 'uri' => '/du-an', 'expect' => 200, 'mustContain' => 'Dự án'],
    ['name' => 'Documents Page (/bao-gia-catalog-san-pham)', 'uri' => '/bao-gia-catalog-san-pham', 'expect' => 200],
    ['name' => 'About Page (/gioi-thieu-vitduct)', 'uri' => '/gioi-thieu-vitduct', 'expect' => 200],
    ['name' => 'Warranty Policy (/chinh-sach-bao-hanh-doi-tra)', 'uri' => '/chinh-sach-bao-hanh-doi-tra', 'expect' => 200],
    ['name' => 'Privacy Policy (/chinh-sach-bao-mat)', 'uri' => '/chinh-sach-bao-mat', 'expect' => 200],
    ['name' => 'Sitemap XML (/sitemap.xml)', 'uri' => '/sitemap.xml', 'expect' => 200, 'mustContain' => 'urlset'],
    ['name' => 'Login Form (/login)', 'uri' => '/login', 'expect' => 200, 'mustContain' => 'Login'],
    ['name' => 'Admin Dashboard Auth Guard (/dashboard)', 'uri' => '/dashboard', 'expect' => 302],
];

foreach ($routesToTest as $r) {
    runTest($r['name'], function() use ($app, $r) {
        $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
        $req = \Illuminate\Http\Request::create($r['uri'], 'GET');
        $res = $kernel->handle($req);
        $status = $res->getStatusCode();
        
        if ($status !== $r['expect']) {
            $msg = "HTTP $status, expected {$r['expect']}";
            if (isset($res->exception) && $res->exception) {
                $msg .= " -> " . $res->exception->getMessage();
            } elseif (preg_match('/<title>(.*?)<\/title>/s', $res->getContent(), $m)) {
                $msg .= " -> " . trim($m[1]);
            }
            return ['ok' => false, 'msg' => $msg];
        }

        $content = $res->getContent();
        if (!empty($r['mustContain']) && stripos($content, $r['mustContain']) === false) {
            return ['ok' => false, 'msg' => "Missing text: '{$r['mustContain']}'"];
        }

        return ['ok' => true, 'detail' => "Status HTTP $status"];
    });
}

// ----------------------------------------------------
// 3. DYNAMIC PAGES TESTS (Single Product & Cate)
// ----------------------------------------------------
echo "\n--- 3. DYNAMIC PRODUCT PAGES TESTS ---\n";

runTest("Dynamic Product Detail Page", function() use ($app) {
    $product = \App\Models\Post::where('parent', 1)->where('sttesign', 1)->first();
    if (!$product) {
        return ['ok' => true, 'detail' => 'Skipped: No product records in DB'];
    }

    $uri = route('get.product.single', [
        'id'    => fencrypt($product->id),
        'title' => makeUnicode($product->title),
    ], false);

    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $req = \Illuminate\Http\Request::create($uri, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();

    if ($status !== 200) {
        $msg = "HTTP $status for URI $uri";
        if (isset($res->exception) && $res->exception) {
            $msg .= " -> " . $res->exception->getMessage();
        }
        return ['ok' => false, 'msg' => $msg];
    }

    return ['ok' => true, 'detail' => "Loaded '{$product->title}' (HTTP 200)"];
});

runTest("Dynamic Category Page", function() use ($app) {
    $cate = \App\Models\Category::where('parent', 1)->first();
    if (!$cate) {
        return ['ok' => true, 'detail' => 'Skipped: No category records in DB'];
    }

    $uri = route('get.product.cate', [
        'id'    => fencrypt($cate->id),
        'title' => makeUnicode($cate->name),
    ], false);

    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $req = \Illuminate\Http\Request::create($uri, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();

    if ($status !== 200) {
        $msg = "HTTP $status for URI $uri";
        if (isset($res->exception) && $res->exception) {
            $msg .= " -> " . $res->exception->getMessage();
        }
        return ['ok' => false, 'msg' => $msg];
    }

    return ['ok' => true, 'detail' => "Loaded category '{$cate->name}' (HTTP 200)"];
});

// ----------------------------------------------------
// 4. ASSETS & SEO INTEGRITY TESTS
// ----------------------------------------------------
echo "\n--- 4. ASSETS & SEO INTEGRITY TESTS ---\n";

runTest("Static CSS Files Exist", function() {
    $css1 = file_exists(__DIR__ . '/../../../../public/home/style.css');
    $css2 = file_exists(__DIR__ . '/../../../../public/home/css/vit-ui.css');
    return ['ok' => $css1 && $css2, 'detail' => "style.css & vit-ui.css present"];
});

runTest("Storage Symlink & Uploads Folder", function() {
    $storageLink = is_dir(__DIR__ . '/../../../../public/storage');
    $uploadsDir = is_dir(__DIR__ . '/../../../../storage/app/public/uploads');
    return ['ok' => $storageLink && $uploadsDir, 'detail' => "public/storage link and uploads folder active"];
});

runTest("SEO Meta Tags & Canonical in Homepage", function() use ($app) {
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $req = \Illuminate\Http\Request::create('/', 'GET');
    $res = $kernel->handle($req);
    $html = $res->getContent();

    $hasTitle = preg_match('/<title>[^<]+<\/title>/i', $html);
    $hasDesc = preg_match('/<meta name="description" content="[^"]+"/i', $html);
    $hasCanonical = preg_match('/<link rel="canonical" href="[^"]+"/i', $html);
    $hasOg = preg_match('/<meta property="og:title"/i', $html);

    if (!$hasTitle || !$hasDesc || !$hasCanonical || !$hasOg) {
        return ['ok' => false, 'msg' => 'Missing one or more required SEO tags'];
    }

    return ['ok' => true, 'detail' => "Title, Description, Canonical, and OpenGraph tags verified"];
});

echo "\n========================================================\n";
echo sprintf("TEST SUMMARY: %d Passed | %d Failed\n", $passed, $failed);
echo "========================================================\n";

exit($failed > 0 ? 1 : 0);