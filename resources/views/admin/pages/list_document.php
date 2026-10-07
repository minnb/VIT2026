<?php
 require __DIR__.'/../layouts/header.php';
 require __DIR__.'/../layouts/left.php';
?>
<div class="content-page">
    <div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12">
					<div class="breadcrumb-holder">
						<h1 class="main-title float-left">Danh sách tài liệu</h1>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item">Dashboard</li>
							<li class="breadcrumb-item active">Danh sách tài liệu</li>
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
											<th>Name</th>
											<th>Category</th>
											<th>Link google driver</th>
											<th>
												<a href="<?php echo route('get.admin.add.document'); ?>" class="btn btn-danger"><i class="fa fa-fw fa-plus"></i> Thêm mới</button>
											</th>
										</tr>
									</thead>										
									<tbody>
										<?php foreach($data as $key=>$item) { ?>
										<tr>
											<td><?php echo $key + 1; ?></td>
											<td><?php echo $item['title']; ?></td>
											<td><?php echo App\Models\Category::getNameById($item['categorieID']); ?></td>
											<td>
												<a target="_bank" href="<?php echo $item['description']; ?>"><i class="fa fa-low-vision bigfonts"></i> Xem</a>
											</td>
											<td>
												<a href="<?php echo route('get.admin.edit.document',['id'=>$item['id']]); ?>"><i class="fa fa-fw fa-edit"></i> Edit </a>
												<a href="<?php echo route('get.admin.delete.document',['id'=>$item['id']]); ?>" style="color:red" onclick="return alertDelete();"><i class="fa fa-fw fa-trash"></i> Delete</a>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>														
					</div>
				</div>				
			</div>
        </div>
	</div>
</div>
<?php
  require __DIR__.'/../layouts/footer.php';
?>
</body>
</html>