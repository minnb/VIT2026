<?php
 require __DIR__.'/../layouts/header.php';
 require __DIR__.'/../layouts/left.php';
?>
<div class="content-page" ng-controller="CompanyController">
    <div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12">
					<div class="breadcrumb-holder">
						<h1 class="main-title float-left">Cài đặt thông tin</h1>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item">Dashboard</li>
							<li class="breadcrumb-item active">Cài đặt thông tin</li>
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
							<form action="<?php echo route('post.admin.setting.slide.list'); ?>" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
								<div class="form-group">
									<label>File hình ảnh</label>
									<input class="form-control" type="file" name="fileImage[]">
									<br>
									<button type="submit" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i>  Upload </button>
								</div>
							</form>
						</div>														
					</div><!-- end card-->	
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
											<th>Hình ảnh</th>
											<th>Diễn giải</th>
											<th></th>
										</tr>
									</thead>	
									<tbody>
									<?php foreach($data as $key=>$item) { ?>
										<tr>
											<td><?php echo $item['id']; ?></td>
											<td>
												<img src="<?php echo asset($item['image']); ?>" style="max-height: 120px;">
											</td>
											<td><?php echo $item['description']; ?></td>
											<td>
												<a href="<?php echo route('get.admin.setting.slide.delete',['id'=>$item['id']]); ?>" style="color:red" onclick="return alertDelete();"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
</div>
<?php
  require __DIR__.'/../layouts/footer.php';
?>
<script src="<?php echo asset('public/js/angular/controller/SettingController.js') ; ?>"></script>	
</body>
</html>