<?php  require __DIR__.'/../layouts/header.php'; ?>
<body class="">
<?php require __DIR__.'/../layouts/nav.php'; ?>
<div class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <ul>
          <li class="home"> <a title="Go to Home Page" href="<?php echo route('index'); ?>">Trang chủ</a><span>&raquo;</span></li>
          <li class=""> <a title="Go to Home Page" href="#">Báo giá & Catalog sản phẩm</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<section class="main-container col2-right-layout">
    <div class="main container">
      <div class="row">
        <div class="col-main col-sm-12 col-xs-12">
          <div class="my-account">
            <div class="page-title">
              <h2>Báo giá & Catalog sản phẩm</h2>
              <br>
            </div>
            <br>
            <div class="table-responsive"> 
              <table id="example1" class="table table-bordered table-hover display">
                <thead>
                  <tr> 
                    <th>#</th>
                    <th>Tên tài liệu</th>
                    <th>Tải file</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($data as $key=>$item) { ?>
                  <tr> 
                      <td data-title="Tên tài liệu"><?php echo $key+1; ?></td>
                      <td data-title="Tải file"><?php echo $item['title'];  ?></td>
                      <td data-title="Tải file"><a target="_bank" href="<?php echo $item['description']; ?>"><i class="fa fa-download"></i> <u> Download </u></a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
  </div>
 </div>
</section>
<?php
  require __DIR__.'/../layouts/service.php';
  require __DIR__.'/../layouts/footer.php';
?>
</div>
  <script type="text/javascript" src="<?php echo asset('public/home/js/jquery.min.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/bootstrap.min.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/owl.carousel.min.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/jquery.bxslider.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/jquery.flexslider.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/mobile-menu.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/jquery-ui.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/main.js') ?>"></script> 
    <script type="text/javascript" src="<?php echo asset('public/home/js/cloud-zoom.js') ?>"></script> 
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#example1').DataTable();
      $('.counter').counterUp({
        delay: 10,
        time: 600
      });
    } );    
  </script>
</body>
</html>


