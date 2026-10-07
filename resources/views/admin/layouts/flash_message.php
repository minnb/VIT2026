<?php if(Session::has('flash_message')){ ?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="flash-message">
		<div class="card mb-3">
			<div class="card-body">
				<div class="alert alert-primary" role="alert">
					<?php echo  Session::get('flash_message') ; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
