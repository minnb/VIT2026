<?php
 require __DIR__.'/../layouts/header.php';
 require __DIR__.'/../layouts/left.php';
?>
<div class="content-page">
	<!-- Start content -->
    <div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12">
					<div class="breadcrumb-holder">
						<h1 class="main-title float-left">Dashboard</h1>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item">Home</li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
						<div class="card-box noradius noborder bg-default">
								<i class="fa fa-file-text-o float-right text-white"></i>
								<h6 class="text-white text-uppercase m-b-20">Sản phẩm</h6>
								<h1 class="m-b-20 text-white counter"><?php echo App\Models\Post::where('parent',1)->get()->count(); ?></h1>
								<span class="text-white">15 sản phẩm mới</span>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
						<div class="card-box noradius noborder bg-warning">
								<i class="fa fa-bar-chart float-right text-white"></i>
								<h6 class="text-white text-uppercase m-b-20">Báo giá & Catalog</h6>
								<h1 class="m-b-20 text-white counter"><?php echo App\Models\Post::where('parent',0)->get()->count(); ?></h1>
								<span class="text-white">Tỉ lệ xem tài liệu</span>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
						<div class="card-box noradius noborder bg-info">
								<i class="fa fa-user-o float-right text-white"></i>
								<h6 class="text-white text-uppercase m-b-20">Dự án</h6>
								<h1 class="m-b-20 text-white counter"><?php echo App\Models\Post::where('parent',2)->get()->count(); ?></h1>
								<span class="text-white">Dự án đã triển khai</span>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
						<div class="card-box noradius noborder bg-danger">
								<i class="fa fa-bell-o float-right text-white"></i>
								<h6 class="text-white text-uppercase m-b-20">News</h6>
								<h1 class="m-b-20 text-white counter"><?php echo App\Models\Post::where('parent',3)->get()->count(); ?></h1>
								<span class="text-white">Tin tức mới</span>
						</div>
					</div>
			</div>
        </div>
	</div>
</div>
<?php
  include('footer.php');
?>
</body>
</html>