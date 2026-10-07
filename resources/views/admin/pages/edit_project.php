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
						<h1 class="main-title float-left">Chỉnh sửa sản phẩm</h1>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item">Dashboard</li>
							<li class="breadcrumb-item active">Chỉnh sửa sản phẩm</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<?php require __DIR__.'/../layouts/flash_message.php'; ?>
		<div class="container-fluid backgroud_white">
			<form name="create-question" action="<?php echo route('post.admin.edit.project',['id'=>$post_id]); ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
				<div class="row backgroud_white">
					<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
						<div class="form-group">
							<label>Tên sản phẩm</label>
							<input type="text" name="name" class="form-control" value="<?php echo old('name',isset($data) ? $data['title'] : ''); ?>" required="required"/>
						</div>
						<div class="form-group">
							<label>Chi tiết sản phẩm</label>
							<textarea id="content" name="content" class="form-control" rows="30" required="required"><?php echo old('content',isset($data) ? $data['content'] : ''); ?></textarea>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
						<div class="form-group">
							<label>Danh mục</label>
							<select class="form-control" name="cate_id">
								<?php echo menuMulti(App\Models\Category::getList(2),2,"--",old('cate_id', isset($data) ? $data['categorieID'] : 0 )); ?>
							</select>
						</div>
						<div class="form-group">
							<label>Upload hình ảnh</label>
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
					</div>
				</div>
				<div class="row backgroud_white">
					<div class="col-md-12 col-lg-12">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i>  Lưu chỉnh sửa</button>
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