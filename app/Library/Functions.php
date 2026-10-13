<?php

function print_result($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
function makeUnicode($str){
  	        if(!$str) return false;
  	        $unicode = array(
        'a'=>array('á','à','ả','ã','ạ','ă','ắ','ặ','ằ','ẳ','ẵ','â','ấ','ầ','ẩ','ẫ','ậ'),
  	            'A'=>array('Á','À','Ả','Ã','Ạ','Ă','Ắ','Ặ','Ằ','Ẳ','Ẵ','Â','Ấ','Ầ','Ẩ','Ẫ','Ậ'),
  	            'd'=>array('đ'),
  	            'D'=>array('Đ'),
  	            'e'=>array('é','è','ẻ','ẽ','ẹ','ê','ế','ề','ể','ễ','ệ'),
  	            'E'=>array('É','È','Ẻ','Ẽ','Ẹ','Ê','Ế','Ề','Ể','Ễ','Ệ'),
  	            'i'=>array('í','ì','ỉ','ĩ','ị'),
  	            'I'=>array('Í','Ì','Ỉ','Ĩ','Ị'),
  	            'o'=>array('ó','ò','ỏ','õ','ọ','ô','ố','ồ','ổ','ỗ','ộ','ơ','ớ','ờ','ở','ỡ','ợ'),
  	            '0'=>array('Ó','Ò','Ỏ','Õ','Ọ','Ô','Ố','Ồ','Ổ','Ỗ','Ộ','Ơ','Ớ','Ờ','Ở','Ỡ','Ợ'),
  	            'u'=>array('ú','ù','ủ','ũ','ụ','ư','ứ','ừ','ử','ữ','ự'),
  	            'U'=>array('Ú','Ù','Ủ','Ũ','Ụ','Ư','Ứ','Ừ','Ử','Ữ','Ự'),
  	            'y'=>array('ý','ỳ','ỷ','ỹ','ỵ'),
  	            'Y'=>array('Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
  	            '-'=>array(' ','&quot;','.',"'",'"','[',']','/','---','--','-–-'),
                '+'=>array('?','(',')'),
                '�'=>array('')
  	        );

  	        foreach($unicode as $nonUnicode=>$uni){
  	        	foreach($uni as $value)
            	$str = str_replace($value,$nonUnicode,$str);
  	        }
			$str=trim(strtolower($str));
      $str=rtrim($str,"-");
    	return $str;
}

function getImageInContent($content){
	$first_img = '';
	ob_start();
	ob_end_clean();
	try{
         if(strlen($content) > 0){
            $output = preg_match_all('/.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
            if(count($matches) > 0){
              $first_img = $matches[1][0];
            }
          }else{
            $first_img = '';
          }	    
	}catch (Exception $e) {
	    $first_img = '';
	}

	if(empty($first_img)){
    $first_img = "http://vitduct.com.vn/public/home/images/logoVIT.png";
	}
	
	if (strlen(strstr($first_img, "youtube")) > 0) {
		return "http://i.ytimg.com/vi/".substr($first_img,30)."/0.jpg";
	}
  else
  {
		return $first_img;
	}

}

function fdecrypt($string) {
    $key ='789632145';
    $result = '';
    $string = base64_decode($string);
    for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
    }
    return $result;
}

function fencrypt($string) {
    $key ='789632145';
    $result = '';
    for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)+ord($keychar));
    $result.=$char;
    }
    return base64_encode($result);
}

function menuMulti ($data,$parent_id = 0,$str="---|",$select=0) {
  foreach ($data as $val) {
    $id = $val["id"];
    $name = $val["name"];
    if ($val["parent"] == $parent_id) {
      if ($select != 0 && $id == $select) {
        echo '<option value="'.$id.'" selected>'.$str." ".$name.'</option>';
      } else {
        echo '<option value="'.$id.'" >'.$str." ".$name.'</option>';
      }
      $space ="---";
      menuMulti ($data,$id,$space." ---|",$select);
    }
  }
}

function checkFolderImage(){
  // Doc qua config: env() goi ngoai file config se tra null sau `artisan config:cache`.
  $path = config('upload.dir');

  if ($path === null || $path === '') {
    $path = 'storage/app/public/uploads/product';
  }

  if (!file_exists($path)) {
    mkdir($path, 0755, true);
  }

  return $path;
}

/**
 * Dung URL hien thi cho mot duong dan anh luu trong DB.
 *
 * Du lieu cu ton tai o hai dang: URL tuyet doi (http://vitduct.com.vn/...) va
 * duong dan tuong doi so voi thu muc goc du an. Ham xu ly ca hai, va tra ve
 * anh thay the khi ban ghi khong co anh.
 */
function getImage($link){
  $link = trim((string) $link);

  if ($link === '') {
    return asset(config('upload.placeholder'));
  }

  if (preg_match('#^https?://#i', $link)) {
    return function_exists('seo_abs') ? seo_abs($link) : $link;
  }

  return asset(ltrim($link, '/'));
}

function delete_image_by_path($image,$path){
  $img = $path.'/'.$image;
  if(File::exists($img)){
      File::delete($img);
  }
}
function delete_image_no_path($img){
  if(File::exists($img)){
      File::delete($img);
  }
}

function randomString($length = 10){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
/*
|--------------------------------------------------------------------------
| SEO helpers
|--------------------------------------------------------------------------
| Quy tắc áp dụng: .claude/rules/seo-standards.md
| Cấu hình giá trị: config/seo.php
*/

/**
 * Thu nhỏ ảnh vừa upload NGAY TRÊN FILE ĐÃ LƯU, nếu nó vượt quá khung cho phép.
 *
 * Lý do: khung hiển thị sản phẩm chỉ cao 180-240px, nhưng ảnh người dùng upload
 * thường 3000-5000px / vài MB. Trình duyệt vẫn phải tải trọn file rồi mới thu nhỏ
 * -> tốn băng thông và kéo tụt LCP trên mobile.
 *
 * Đặc điểm:
 *   - Giữ nguyên tỉ lệ (contain), KHÔNG cắt, KHÔNG phóng to ảnh nhỏ.
 *   - Ảnh đã nằm trong khung thì bỏ qua hẳn, không mã hoá lại (tránh mất chất lượng).
 *   - Giữ độ trong suốt cho PNG / GIF / WebP.
 *   - Thiếu ext GD, ảnh lỗi, hoặc không đủ RAM -> trả false và GIỮ NGUYÊN file gốc.
 *     Upload không bao giờ hỏng chỉ vì khâu thu nhỏ thất bại.
 *
 * @param  string  $path     Đường dẫn file ảnh trên đĩa
 * @param  int     $maxW     Chiều rộng tối đa
 * @param  int     $maxH     Chiều cao tối đa
 * @param  int     $quality  Chất lượng JPEG/WebP (0-100)
 * @return bool              true nếu đã thu nhỏ và ghi đè thành công
 */
function resize_uploaded_image($path, $maxW = 1600, $maxH = 1600, $quality = 82)
{
    if (!function_exists('imagecreatetruecolor') || !is_file($path) || !is_writable($path)) {
        return false;
    }

    $info = @getimagesize($path);

    if ($info === false) {
        return false; // khong phai anh hoac file hong
    }

    list($width, $height) = $info;
    $type = $info[2];

    if ($width <= 0 || $height <= 0) {
        return false;
    }

    // Da nam trong khung -> khong dung toi, tranh mat chat luong do ma hoa lai
    if ($width <= $maxW && $height <= $maxH) {
        return false;
    }

    if (!resize_image_memory_ok($width, $height)) {
        return false; // anh qua lon so voi memory_limit -> giu nguyen con hon lam chet request
    }

    $readers = [
        IMAGETYPE_JPEG => 'imagecreatefromjpeg',
        IMAGETYPE_PNG  => 'imagecreatefrompng',
        IMAGETYPE_GIF  => 'imagecreatefromgif',
        IMAGETYPE_WEBP => 'imagecreatefromwebp',
    ];

    if (!isset($readers[$type]) || !function_exists($readers[$type])) {
        return false;
    }

    $src = @$readers[$type]($path);

    if (!$src) {
        return false;
    }

    // Ti le thu nho theo canh bi vuot nhieu hon -> anh luon lot gon trong khung
    $ratio    = min($maxW / $width, $maxH / $height);
    $newWidth = max(1, (int) round($width * $ratio));
    $newHeight= max(1, (int) round($height * $ratio));

    $dst = imagecreatetruecolor($newWidth, $newHeight);

    if (!$dst) {
        imagedestroy($src);
        return false;
    }

    if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP], true)) {
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        imagefill($dst, 0, 0, imagecolorallocatealpha($dst, 0, 0, 0, 127));
    }

    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Ghi ra file tam roi moi thay the: loi giua chung khong lam mat anh goc
    $tmp = $path . '.resizing';

    switch ($type) {
        case IMAGETYPE_JPEG: $ok = imagejpeg($dst, $tmp, $quality); break;
        case IMAGETYPE_PNG:  $ok = imagepng($dst, $tmp, 6);         break;
        case IMAGETYPE_GIF:  $ok = imagegif($dst, $tmp);            break;
        case IMAGETYPE_WEBP: $ok = imagewebp($dst, $tmp, $quality); break;
        default:             $ok = false;
    }

    imagedestroy($src);
    imagedestroy($dst);

    if (!$ok || !is_file($tmp)) {
        @unlink($tmp);
        return false;
    }

    if (!@rename($tmp, $path)) {
        @unlink($tmp);
        return false;
    }

    return true;
}

/**
 * Ước lượng xem còn đủ RAM để giải nén ảnh ra bitmap hay không.
 *
 * GD giữ ảnh dạng truecolor 4 byte/pixel; hệ số 1.8 tính cả ảnh nguồn lẫn ảnh đích
 * và phần overhead của GD.
 *
 * @param  int  $width
 * @param  int  $height
 * @return bool
 */
function resize_image_memory_ok($width, $height)
{
    $limit = trim((string) ini_get('memory_limit'));

    if ($limit === '' || $limit === '-1') {
        return true; // khong gioi han
    }

    $unit  = strtolower(substr($limit, -1));
    $bytes = (int) $limit;

    if ($unit === 'g') {
        $bytes *= 1024 * 1024 * 1024;
    } elseif ($unit === 'm') {
        $bytes *= 1024 * 1024;
    } elseif ($unit === 'k') {
        $bytes *= 1024;
    }

    $needed = $width * $height * 4 * 1.8;

    return ($needed + memory_get_usage(true)) < $bytes;
}

/**
 * Như asset() nhưng gắn thêm ?v=<mtime> của file.
 *
 * CSS/JS khu public nạp thủ công, không đi qua Laravel Mix nên không có hash
 * trong tên file. Thiếu tham số này, trình duyệt (và CDN) giữ bản cũ rất lâu
 * sau khi deploy — đã nhiều lần gây hiểu nhầm "sửa CSS mà không thấy đổi".
 *
 * @param  string  $path
 * @return string
 */
function asset_v($path)
{
    $url  = asset($path);
    $file = base_path(ltrim($path, '/'));

    if (!is_file($file)) {
        return $url;
    }

    return $url . (strpos($url, '?') === false ? '?' : '&') . 'v=' . filemtime($file);
}

/**
 * Chuyển một đường dẫn bất kỳ thành URL tuyệt đối theo tên miền chính thức.
 * Dùng cho og:image, canonical, JSON-LD — nơi Google yêu cầu URL tuyệt đối.
 *
 * @param  string|null  $url
 * @return string
 */
function seo_abs($url)
{
    $url = trim((string) $url);

    if ($url === '') {
        return config('seo.base_url');
    }

    $base = config('seo.base_url');

    if (preg_match('#^(https?:)?//#i', $url)) {
        // URL tuyet doi cung ten mien nhung khac scheme (vd http:// trong DB cu)
        // -> ep ve scheme cua ten mien chinh thuc, tranh mixed content tren HTTPS.
        $host = parse_url($url, PHP_URL_HOST);

        if ($host && $host === parse_url($base, PHP_URL_HOST)) {
            $path = (string) parse_url($url, PHP_URL_PATH);
            $qs   = parse_url($url, PHP_URL_QUERY);

            return $base . $path . ($qs ? '?' . $qs : '');
        }

        return $url;
    }

    return $base . '/' . ltrim($url, '/');
}

/**
 * Ép một URL nội bộ (tuyệt đối hay tương đối) về tên miền chính thức,
 * giữ nguyên path + query. Dùng cho JSON-LD và sitemap để mọi URL trong
 * structured data trùng khớp với thẻ canonical, không phụ thuộc host của request.
 *
 * @param  string|null  $url
 * @return string
 */
function seo_canonical($url)
{
    $url = trim((string) $url);

    if ($url === '') {
        return config('seo.base_url');
    }

    $base  = config('seo.base_url');
    $parts = parse_url($url);
    $path  = isset($parts['path']) ? $parts['path'] : '/';
    $query = isset($parts['query']) ? '?' . $parts['query'] : '';

    // Khi ung dung chay trong thu muc con (vd may dev: localhost/projects/VIT2018),
    // route() va getRequestUri() deu kem tien to do. Production chay o goc ten mien
    // nen tien to nay khong duoc phep lot vao canonical.
    $prefix = seo_base_path();

    if ($prefix !== '' && strpos($path, $prefix) === 0) {
        $path = substr($path, strlen($prefix));
    }

    // Bo dau "/" thua o cuoi de mot trang chi co dung mot dang URL chuan.
    $path = ($path === '' || $path === '/') ? '' : '/' . trim($path, '/');

    return $base . $path . $query;
}

/**
 * Tiền tố thư mục con mà ứng dụng đang chạy dưới đó ('' nếu chạy ở gốc tên miền).
 *
 * @return string
 */
function seo_base_path()
{
    if (app()->runningInConsole() && !app()->bound('request')) {
        return '';
    }

    return rtrim((string) request()->getBaseUrl(), '/');
}

/**
 * URL chuẩn (canonical) của request hiện tại, đã gỡ tiền tố thư mục con
 * và giữ nguyên query string (cần cho các trang phân trang).
 *
 * @return string
 */
function seo_current_url()
{
    $path  = '/' . trim(request()->path(), '/');
    $query = request()->getQueryString();

    return seo_canonical($path . ($query ? '?' . $query : ''));
}

/**
 * Sinh meta description sạch từ một đoạn HTML (nội dung CKEditor).
 * Bỏ thẻ, giải mã entity, gộp khoảng trắng rồi cắt an toàn UTF-8.
 *
 * @param  string|null  $html
 * @param  int           $limit
 * @param  string|null   $default  Mô tả riêng của trang khi $html rỗng.
 *                                 Bỏ trống thì rơi về config('seo.default_description').
 * @return string
 */
function seo_description($html, $limit = 160, $default = null)
{
    $text = strip_tags((string) $html);
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    $text = preg_replace('/\s+/u', ' ', $text);
    $text = preg_replace('/^[\s\*\-\–\—\•\:\.]+/u', '', $text);
    $text = trim((string) $text);

    if ($text === '') {
        return $default !== null && trim($default) !== ''
            ? $default
            : config('seo.default_description');
    }

    return \Illuminate\Support\Str::limit($text, $limit, '…');
}

/**
 * Chuẩn hoá HTML do trình soạn thảo sinh ra trước khi in ra trang public:
 *   - <img>    : bổ sung loading="lazy", decoding="async", alt rỗng nếu thiếu
 *   - <iframe> : bổ sung loading="lazy"
 *   - <a target="_blank"> : bổ sung rel="noopener"
 *
 * Không sửa dữ liệu trong DB, chỉ xử lý ở tầng hiển thị.
 * Parse lỗi thì trả nguyên HTML gốc (fail-safe, không bao giờ làm trắng trang).
 *
 * @param  string|null  $html
 * @param  string       $fallbackAlt
 * @return string
 */
function seo_content($html, $fallbackAlt = '')
{
    $html = (string) $html;

    if (trim($html) === '' || !class_exists('DOMDocument')) {
        return $html;
    }

    $previous = libxml_use_internal_errors(true);

    try {
        $doc = new DOMDocument('1.0', 'UTF-8');

        // Prefix XML để libxml không hiểu nhầm UTF-8 tiếng Việt thành ISO-8859-1.
        $loaded = $doc->loadHTML(
            '<?xml encoding="utf-8" ?><div data-seo-root="1">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        if (!$loaded) {
            return $html;
        }

        foreach ($doc->getElementsByTagName('img') as $img) {
            if (!$img->hasAttribute('loading')) {
                $img->setAttribute('loading', 'lazy');
            }
            if (!$img->hasAttribute('decoding')) {
                $img->setAttribute('decoding', 'async');
            }
            if (!$img->hasAttribute('alt') || trim($img->getAttribute('alt')) === '') {
                $img->setAttribute('alt', $fallbackAlt);
            }
        }

        foreach ($doc->getElementsByTagName('iframe') as $frame) {
            if (!$frame->hasAttribute('loading')) {
                $frame->setAttribute('loading', 'lazy');
            }
            if (!$frame->hasAttribute('title')) {
                $frame->setAttribute('title', $fallbackAlt !== '' ? $fallbackAlt : 'Nội dung nhúng');
            }
        }

        foreach ($doc->getElementsByTagName('a') as $link) {
            if (strtolower($link->getAttribute('target')) === '_blank') {
                $rel = trim($link->getAttribute('rel'));
                if (stripos($rel, 'noopener') === false) {
                    $link->setAttribute('rel', trim($rel . ' noopener'));
                }
            }
        }

        $wrapper = $doc->getElementsByTagName('div')->item(0);

        if (!$wrapper || !$wrapper->hasAttribute('data-seo-root')) {
            return $html;
        }

        $output = '';
        foreach ($wrapper->childNodes as $child) {
            $output .= $doc->saveHTML($child);
        }

        return $output;
    } catch (\Throwable $e) {
        return $html;
    } finally {
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
    }
}

/**
 * Chuẩn hoá số hotline thành giá trị dùng được cho link `tel:`.
 *
 * Trường setting HOTLINE có thể chứa nhiều số ngăn cách bởi "/" hoặc "|"
 * (ví dụ: "0979 625 629/ 0983 625 429"). Giao thức tel: chỉ nhận một số,
 * nên hàm lấy số đầu tiên và loại bỏ mọi ký tự không phải chữ số.
 *
 * @param  string|null  $hotline
 * @return string
 */
function telLink($hotline): string
{
    if (empty($hotline)) {
        return '';
    }

    $first = preg_split('#[/|,]#', (string) $hotline)[0];

    return preg_replace('/[^0-9+]/', '', $first);
}
