<div id="mobile-menu">
  <ul>
    <li><a href="<?php echo route('index'); ?>" class="home1">Trang chủ</a></li>
<?php 
    $lstCate = App\Models\Category::getList(1); 
    foreach($lstCate as $key=>$item) {
?>
    <li><a href="<?php echo route('get.product.cate', ['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['name'])] ) ?>"><?php echo $item['name']; ?></a>
<?php } ?>
    <li><a href="#">Dự án tiêu biểu</a></li>
    <li><a href="#">Báo giá & Catalog</a></li>
    <li><a href="#">Giới thiệu</a></li>
    <li><a href="#">Hình ảnh</a></li>
    <li><a href="#">Liên hệ</a></li>
  </ul>
</div>
