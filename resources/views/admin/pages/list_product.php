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
						<h1 class="main-title float-left">Danh sách sản phẩm</h1>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item">Dashboard</li>
							<li class="breadcrumb-item active">Danh sách sản phẩm</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<?php require __DIR__.'/../layouts/flash_message.php'; ?>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="card mb-3">
						<div class="card-body">
							<div class="table-responsive">
								<table id="example1" class="table table-bordered table-hover display">
									<thead>
										<tr>
											<th>#</th>
											<th>ID</th>
											<th>Name</th>
											<th>Category</th>
											<th>Price</th>
											<th>Image</th>
											<th>
												<a class="btn btn-danger" href="<?php echo route('get.admin.add.product'); ?>"><i class="fa fa-fw fa-plus"></i> Thêm mới</a>
											</th>
										</tr>
									</thead>										
									<tbody>
										<?php foreach($data as $key=>$item) { ?>
										<tr>
											<td><?php echo $key + 1; ?></td>
											<td><?php echo $item['id']; ?></td>
											<td><?php echo $item['title']; ?></td>
											<td><?php echo App\Models\Category::getNameById($item['categorieID']); ?></td>
											<td><?php echo $item['price']; ?></td>
											<td>
												<img class="img-thumbnail img-thumb" src="<?php echo getImage(App\Models\Images::checkImageProduct($item['id'])); ?>" />
											</td>
											<td>
												<a href="<?php echo route('get.admin.edit.product',['id'=>$item['id']]); ?>"><i class="fa fa-fw fa-edit"></i> Edit </a>
												<a href="<?php echo route('get.admin.delete.product',['id'=>$item['id']]); ?>" style="color:red" onclick="return alertDelete();"><i class="fa fa-fw fa-trash"></i> Delete</a>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>														
					</div><!-- end card-->	
				</div>				
			</div>
        </div>
		<!-- END container-fluid -->
	</div>
	<!-- END content -->
</div>
<!-- END content-page -->

<?php
  require __DIR__.'/../layouts/footer.php';
?>
</body>
</html>