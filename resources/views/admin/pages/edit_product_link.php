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
						<h1 class="main-title float-left">Thêm mới sản phẩm liên kết</h1>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item">Dashboard</li>
							<li class="breadcrumb-item active">Thêm mới sản phẩm liên kết</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<?php require __DIR__.'/../layouts/flash_message.php'; ?>
		<div class="container-fluid backgroud_white">
			<form name="create-question" action="<?php echo route('post.admin.edit.product.link',['id'=>$post_id]); ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
				<div class="row backgroud_white">
					<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
						<div class="form-group">
							<label>Thương hiệu</label>
							<input type="text" name="name" class="form-control" required="required" value="<?php echo old('name',isset($data) ? $data['title'] : ''); ?>"/>
						</div>
						<div class="form-group">
							<label>Tên sản phẩm</label>
							<input type="text" name="description" class="form-control" required="required" value="<?php echo old('description',isset($data) ? $data['description'] : ''); ?>" />
						</div>
						<div class="form-group">
							<label>Hình ảnh</label>
							<input type="file" name="fileImage[]" id="filer_example2" multiple="multiple">
						</div>
						<?php 	$img = App\Models\Images::checkImageByPostId($post_id); 
								if(isset($img)) { 
								foreach($img as $key=>$item){
						?>
							<div class="form-group" id='<?php echo $key; ?>'>
								<label>Hình sản phẩm</label><br>
								<img class="img-responsive dis-image-from-database-detail" src="<?php echo url('/').'/'.$item->image; ?>" id='<?php echo $key; ?>' idHinh="<?php echo $item->id; ?>">
								<a id="del-imge-detail" class="btn btn-danger icon-del" href="javascript:void(0)" type="button"><i class="fa fa-times"></i></a>
							</div>
						<?php } } ?>
						<div class="form-group">
							<label>Giới thiệu về sản phẩm</label>
							<textarea id="content" name="content" class="form-control" rows="30"><?php echo old('content',isset($data) ? $data['content'] : ''); ?></textarea>
						</div>
					</div>
				</div>
				<div class="row backgroud_white">
					<div class="col-md-12 col-lg-12">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i>  Lưu thay đổi</button>
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