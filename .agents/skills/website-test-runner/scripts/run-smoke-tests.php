<?php

/**
 * ============================================================================
 * Automated Website Test Runner (Smoke & Regression Test Suite)
 * VIT2018_v11 - Laravel 11/13 on PHP 8.3
 * ============================================================================
 */

// Determine project root directory
$projectRoot = getenv('VIT_PROJECT_DIR');
if (!$projectRoot) {
    $possibleRoots = [
        realpath(__DIR__ . '/../../../../'),
        'C:/xampp/htdocs/projects/VIT2018_v11',
    ];
    foreach ($possibleRoots as $dir) {
        if ($dir && is_file($dir . '/bootstrap/app.php') && str_contains($dir, 'VIT2018_v11')) {
            $projectRoot = $dir;
            break;
        }
    }
}

if (!$projectRoot || !is_file($projectRoot . '/bootstrap/app.php')) {
    $projectRoot = 'C:/xampp/htdocs/projects/VIT2018_v11';
}

require_once $projectRoot . '/vendor/autoload.php';
$app = require_once $projectRoot . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

// Ensure initial Request is bound for UrlGenerator
$app->instance('request', \Illuminate\Http\Request::create('/', 'GET'));

echo "====================================================================\n";
echo "   VIT2018_v11 AUTOMATED WEBSITE TEST RUNNER (PHP 8.3 / LARAVEL 11+)\n";
echo "   Target Directory: $projectRoot\n";
echo "====================================================================\n\n";

$passed = 0;
$failed = 0;
$startTime = microtime(true);

function runTest($name, $callable) {
    global $passed, $failed;
    echo sprintf("[TEST] %-54s ... ", $name);
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
echo "\n--- [SUITE 1] DATABASE & ELOQUENT MODELS ---\n";

runTest("MySQL Database Connection", function() {
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    $name = \Illuminate\Support\Facades\DB::connection()->getDatabaseName();
    return ['ok' => true, 'detail' => "Connected to MySQL database: '$name'"];
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
    return ['ok' => !empty($hotline), 'detail' => "Hotline configured: $hotline"];
});

runTest("Model Slides Count", function() {
    $count = \App\Models\Slide::active()->count();
    return ['ok' => $count >= 0, 'detail' => "Active slides: $count"];
});

// ----------------------------------------------------
// 2. HTTP ROUTE & VIEW RENDERING TESTS
// ----------------------------------------------------
echo "\n--- [SUITE 2] HTTP ROUTE & VIEW RENDERING (KERNEL) ---\n";

$routesToTest = [
    ['name' => 'Home Page (/)', 'uri' => '/', 'expect' => 200, 'mustContain' => 'VITDUCT'],
    ['name' => 'Products Page (/san-pham)', 'uri' => '/san-pham', 'expect' => 200],
    ['name' => 'Projects Page (/du-an)', 'uri' => '/du-an', 'expect' => 200],
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
            return ['ok' => false, 'msg' => "Missing expected content text: '{$r['mustContain']}'"];
        }

        return ['ok' => true, 'detail' => "HTTP status $status verified"];
    });
}

// ----------------------------------------------------
// 3. DYNAMIC PRODUCT & CATEGORY RESOLUTION
// ----------------------------------------------------
echo "\n--- [SUITE 3] DYNAMIC PRODUCT & CATEGORY URLS ---\n";

runTest("Dynamic Product Detail Page", function() use ($app) {
    $product = \App\Models\Post::where('parent', 1)->where('sttesign', 1)->first();
    if (!$product) {
        return ['ok' => true, 'detail' => 'Skipped: No product records in DB'];
    }

    $uri = route('get.product.single', [
        'id'   => fencrypt($product->id),
        'name' => makeUnicode($product->title),
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
        'id'   => fencrypt($cate->id),
        'name' => makeUnicode($cate->name),
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
// 4. SEARCH FEATURE & CSRF FORM HANDLING
// ----------------------------------------------------
echo "\n--- [SUITE 4] SEARCH & CSRF POST HANDLING ---\n";

runTest("Product Search POST (/result)", function() use ($app) {
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $session = $app->make('session.store');
    $session->start();
    $token = $session->token();

    $req = \Illuminate\Http\Request::create('/result', 'POST', [
        '_token' => $token,
        'search' => 'Ống gió',
    ]);
    $req->setLaravelSession($session);
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();

    if ($status !== 200) {
        return ['ok' => false, 'msg' => "HTTP $status received"];
    }

    $content = $res->getContent();
    if (!str_contains($content, 'Kết quả tìm kiếm')) {
        return ['ok' => false, 'msg' => 'Expected search title missing from view'];
    }

    return ['ok' => true, 'detail' => "Search executed successfully (HTTP 200)"];
});

// ----------------------------------------------------
// 5. ADMIN AUTHENTICATED VIEWS
// ----------------------------------------------------
echo "\n--- [SUITE 5] ADMIN AUTHENTICATED VIEWS ---\n";

$adminViewsToTest = [
    ['name' => 'Admin Dashboard View', 'uri' => '/dashboard'],
    ['name' => 'Admin Product List View', 'uri' => '/dashboard/lists/products'],
    ['name' => 'Admin Add Product Form', 'uri' => '/dashboard/add/product'],
    ['name' => 'Admin Category List View', 'uri' => '/dashboard/cate/product/lists'],
    ['name' => 'Admin Slides Management View', 'uri' => '/dashboard/setting/slide/list'],
];

foreach ($adminViewsToTest as $av) {
    runTest($av['name'], function() use ($app, $av) {
        $user = \App\Models\User::first();
        if (!$user) {
            return ['ok' => false, 'msg' => 'No user found in DB to test admin views'];
        }
        $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
        $session = $app->make('session.store');
        $session->start();

        $req = \Illuminate\Http\Request::create($av['uri'], 'GET');
        $req->setLaravelSession($session);
        $app->instance('request', $req);
        \Illuminate\Support\Facades\Auth::setUser($user);
        $req->setUserResolver(function() use ($user) { return $user; });

        $res = $kernel->handle($req);
        $status = $res->getStatusCode();

        if ($status !== 200) {
            $msg = "HTTP $status";
            if (isset($res->exception) && $res->exception) {
                $msg .= " -> " . $res->exception->getMessage();
            }
            return ['ok' => false, 'msg' => $msg];
        }

        return ['ok' => true, 'detail' => "HTTP 200 OK (Rendered " . strlen($res->getContent()) . " bytes)"];
    });
}

// ----------------------------------------------------
// 6. ASSETS & SEO INTEGRITY
// ----------------------------------------------------
echo "\n--- [SUITE 6] ASSETS & SEO INTEGRITY ---\n";

runTest("Static CSS Files Exist", function() use ($projectRoot) {
    $css1 = file_exists($projectRoot . '/public/home/style.css');
    $css2 = file_exists($projectRoot . '/public/home/css/vit-ui.css');
    return ['ok' => $css1 && $css2, 'detail' => "style.css & vit-ui.css present"];
});

runTest("Storage Symlink & Uploads Folder", function() use ($projectRoot) {
    $storageLink = is_dir($projectRoot . '/public/storage');
    $uploadsDir = is_dir($projectRoot . '/storage/app/public/uploads');
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

// ----------------------------------------------------
// 7. LIVE APACHE WEB SERVER TESTS (End-to-End)
// ----------------------------------------------------
echo "\n--- [SUITE 7] LIVE APACHE WEB SERVER (END-TO-END) ---\n";

$apacheBaseUrl = 'http://localhost/projects/VIT2018_v11/public';
$apacheAvailable = false;

$socket = @fsockopen('127.0.0.1', 80, $errno, $errstr, 1);
if ($socket) {
    fclose($socket);
    $apacheAvailable = true;
}

if (!$apacheAvailable) {
    echo "       (Apache Port 80 not responding, skipping live HTTP suite)\n";
} else {
    $liveUrls = [
        'Live Homepage'    => "$apacheBaseUrl/",
        'Live Products'    => "$apacheBaseUrl/san-pham",
        'Live Sitemap XML' => "$apacheBaseUrl/sitemap.xml",
        'Live Login Form'  => "$apacheBaseUrl/login",
    ];

    foreach ($liveUrls as $testName => $url) {
        runTest("$testName ($url)", function() use ($url) {
            $ctx = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'follow_location' => 0,
                    'ignore_errors' => true,
                ],
            ]);
            $response = @file_get_contents($url, false, $ctx);
            if ($response === false) {
                return ['ok' => false, 'msg' => 'Failed to connect to Apache URL'];
            }
            $statusLine = $http_response_header[0] ?? '';
            preg_match('/HTTP\/\S+\s+(\d+)/', $statusLine, $matches);
            $statusCode = isset($matches[1]) ? (int)$matches[1] : 0;
            if ($statusCode !== 200) {
                return ['ok' => false, 'msg' => "Received status $statusCode instead of 200"];
            }
            return ['ok' => true, 'detail' => "HTTP 200 OK, bytes: " . strlen($response)];
        });
    }
}

$elapsed = round(microtime(true) - $startTime, 2);

echo "\n====================================================================\n";
echo sprintf("   TEST SUMMARY: %d Passed | %d Failed (Duration: %ss)\n", $passed, $failed, $elapsed);
echo "====================================================================\n";

exit($failed > 0 ? 1 : 0);
