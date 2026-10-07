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
						<h1 class="main-title float-left">Thêm mới tài liệu</h1>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item">Dashboard</li>
							<li class="breadcrumb-item active">Thêm mới tài liệu</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<?php require __DIR__.'/../layouts/flash_message.php'; ?>
		<div class="container-fluid backgroud_white">
			<form name="create-question" action="<?php echo route('post.admin.add.document'); ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
				<div class="row backgroud_white">
					<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
						<div class="form-group">
							<label>Tên sản phẩm</label>
							<input type="text" name="name" class="form-control" required="required" />
						</div>
						<div class="form-group">
							<label>Danh mục</label>
							<select class="form-control" name="cate_id">
								<?php echo menuMulti(App\Models\Category::getList(11),11,"--",0); ?>
							</select>
						</div>
						<div class="form-group">
							<label>Link Google Driver</label>
							<input type="text" name="description" class="form-control" required="required"/>
						</div>
					</div>
				</div>
				<div class="row backgroud_white">
					<div class="col-md-12 col-lg-12">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i>  Thêm mới</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
  require __DIR__.'/../layouts/footer.php';
?>
<script type="text/javascript">
	$(document).ready(function(){
	'use-strict';
	    $('#filer_example2').filer({
	        limit: 3,
	        maxSize: 3,
	        extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd'],
	        changeInput: true,
	        showThumbs: true,
	        addMore: true
	    });
	});
	$(document).ready(function(){
        ckeditor('content')
        $('.textarea').wysihtml5();
      });
</script>
</body>
</html>