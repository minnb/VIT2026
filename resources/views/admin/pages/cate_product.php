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
						<h1 class="main-title float-left">Danh mục sản phẩm</h1>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item">Dashboard</li>
							<li class="breadcrumb-item active">Danh mục sản phẩm</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
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
											<th>Parent</th>
											<th>Count</th>
											<th>Create date</th>
											<th>Action</th>
										</tr>
									</thead>										
									<tbody>
										<?php foreach($data as $key=>$item) { ?>
										<tr>
											<td><?php echo $key + 1; ?></td>
											<td><?php echo $item['name'].' #'.$item['id']; ?></td>
											<td><?php echo $item['parent']; ?></td>
											<td><?php echo App\Models\Category::countPost($item['id']); ?></td>
											<td><?php echo $item['created_at']; ?></td>
											<td>
												<a href="#"><i class="fa fa-fw fa-edit"></i> Edit </a>
												<a href="#" style="color:red"><i class="fa fa-fw fa-trash"></i> Delete</a>
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