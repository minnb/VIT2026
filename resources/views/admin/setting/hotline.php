<?php
 require __DIR__.'/../layouts/header.php';
 require __DIR__.'/../layouts/left.php';
?>
<div class="content-page" ng-controller="SettingController">
    <div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12">
					<div class="breadcrumb-holder">
						<h1 class="main-title float-left">Cài đặt hotline</h1>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item">Dashboard</li>
							<li class="breadcrumb-item active">Cài đặt hotline</li>
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
											<th>Liên hệ</th>
											<th>Số điện thoại</th>
											<th>Email</th>
											<th>Trạng thái</th>
											<th>
												<button class="btn btn-info btn-sm" ng-click="modal('add')"><i class="fa fa-plus-square-o bigfonts" aria-hidden="true"></i> Thêm mới</button>
											</th>
										</tr>
									</thead>	
									<tbody>
										<tr ng-repeat="sv in dsphone">
											<td>{{ sv.id }}</td>
											<td>{{ sv.name }}</td>
											<td>{{ sv.phone }}</td>
											<td>{{ sv.email }}</td>
											<td>{{ sv.status }}</td>
											<td>
												<a class="btn btn-primary btn-sm" id="btn-edit" ng-click="modal('edit',sv.id)"><i class="fa fa-fw fa-edit"></i> Edit </a>
												<a class="btn btn-danger btn-sm" ng-click="confirmDelete(sv.id)"><i class="fa fa-fw fa-trash"></i> Delete</a>
											</td>
										</tr>
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
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	 	<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ frmTitle }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="addHotline('exit')">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="frmAddHotline" name="frmAddHotline">
				<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					  <div class="modal-body">
							<div class="form-group">
								<label for="exampleInputEmail1">Họ tên</label>
								<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Họ tên" required ng-model="hotline.name">
						  	</div>
						  	<div class="form-group">
								<label for="exampleInputEmail1">Số điện thoại</label>
								<input type="text" class="form-control" placeholder="Số điện thoại" required ng-model="hotline.phone">
						  	</div>
						  	<div class="form-group">
								<label for="exampleInputEmail1">Địa chỉ email</label>
								<input type="email" class="form-control" placeholder="Email" ng-model="hotline.email">
						  	</div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" ng-click="addHotline('exit')">Thoát</button>
						<button type="submit" class="btn btn-primary" ng-disabled="frmAddHotline.$invalid" ng-click="addHotline(state,id)">Lưu</button>
					  </div>
				</form>
			</div>
		 </div>
	</div>
</div>
<?php
  require __DIR__.'/../layouts/footer.php';
?>
<script src="<?php echo asset('public/js/angular/controller/SettingController.js') ; ?>"></script>	
</body>
</html>