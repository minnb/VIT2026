<!DOCTYPE html>
<html lang="vn">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="<?php echo asset('public/favicon.ico'); ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo asset('public/assets/icons/favicon-32x32.png'); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo asset('public/assets/icons/apple-touch-icon.png'); ?>">
<?php 
    $com = App\Models\Setting::getComName('COM');
    $man = App\Models\Setting::getComName('MAN');
 ?>
<title><?php if(isset($title)){ echo $title; } else { echo $com[0]['name']; } ?></title>
<meta name="description" content="CÔNG TY CỔ PHẦN VITDUCT - Thi công lắp đặt các hệ thống ME cho các tòa nhà và nhà máy công nghiệp">
<meta name="keywords" content="Sản xuất: Ống thông gió, van gió, cửa gió. Lò xo chống rung giảm chấn các loại. Cung cấp, thi công Hệ thống điều hòa không khí và thông gió"/>
 <meta property="fb:app_id" content="1547540628876392"/>
 <meta name="apple-mobile-web-app-capable" content="yes"/>
 <meta name="apple-mobile-web-app-title" content="Vitduct.com.vn"/>
 <meta name="tt_article_id" content="1000000"/>
 <meta name="tt_page_type" content="site"/>
 <meta name="tt_category_id" content="1000000"/>
 <meta name="tt_site_id" content="1000000"/>
<!-- META FOR FACEBOOK -->
<meta property="og:site_name" content="vitduct.com.vn"/>
<meta property="og:rich_attachment" content="true"/>
<meta property="og:type" content="website"/>
<meta property="og:url" itemprop="url" content="https://vitduct.com.vn"/>
<meta property="og:image" itemprop="thumbnailUrl" content="https://vitduct.com.vn/public/home/images/logo.jpg"/>
<meta property="og:image:width" content="800"/>
<meta property="og:image:height" content="354"/>
<meta content="CÔNG TY CỔ PHẦN VITDUCT" itemprop="headline" property="og:title"/>
<meta content="Sản xuất: Ống thông gió, van gió, cửa gió. Lò xo chống rung giảm chấn các loại. Cung cấp, thi công Hệ thống điều hòa không khí và thông gió" itemprop="description" property="og:description"/>
<!-- END META FOR FACEBOOK -->
<!-- GOOGLE SEARCH META GOOGLE SEARCH STRUCTURED DATA FOR ARTICLE && GOOGLE BREADCRUMB STRUCTURED DATA-->
<script type="application/ld+json"> { "@context" : "http://schema.org", "@type" : "WebSite", "name" : "CÔNG TY CỔ PHẦN VITDUCT", "alternateName" : "Sản xuất: Ống thông gió, van gió, cửa gió. Lò xo chống rung giảm chấn các loại. Cung cấp, thi công Hệ thống điều hòa không khí và thông gió", "url": "https://vitduct.com.vn", "potentialAction": { "@type": "SearchAction", "target": "https://vitduct.com.vn/?q={search_term_string}", "query-input": "required name=search_term_string" } } </script> 
<script type="application/ld+json"> { "@context": "https://schema.org", "@type": "Organization", "name": "CÔNG TY CỔ PHẦN VITDUCT", "url": "https://vitduct.com.vn", "logo": "https://vitduct.com.vn/public/home/images/logo.jpg", "foundingDate": "2001", "founders": [ { "@type": "Person", "name": "Sản xuất: Ống thông gió, van gió, cửa gió" }, { "@type": "Person", "name": "VITDUCT" } ], "address": [ { "@type": "PostalAddress", "streetAddress": "Cụm CN Yên Bình, xã Yên Bình, Thạch Thất, Hà Nội", "addressLocality": "Hà Nội", "addressRegion": "Northeast", "postalCode": "100000", "addressCountry": "VNM" }, { "@type": "PostalAddress", "streetAddress": "Cụm CN Yên Bình, xã Yên Bình, Thạch Thất, Hà Nội", "addressLocality": "TP Hà Nội", "addressRegion": "Southeast", "postalCode": "70000", "addressCountry": "VNM" } ], "contactPoint": [ { "@type": "ContactPoint", "telephone": "024 3645 4199", "contactType": "customer service" }, { "@type": "ContactPoint", "telephone": "024 3645 4199", "contactType": "customer service" } ], "sameAs": [ "https://www.facebook.com/vitduct.com.vn"] } </script> 
<link rel="stylesheet" href="<?php echo asset('public/home/style.css') ?>">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-173467050-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-173467050-1');
</script>

</head>
 
