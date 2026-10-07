<div class="home-tab">
  <div class="col-sm-12 col-md-12 jtv-best-sale special-pro">
      <div class="jtv-best-sale-list">
        <div class="wpb_wrapper">
          <div class="best-title text-left">
            <h2>Sản phẩm liên kết</h2>
          </div>
        </div>
        <div class="slider-items-products">
          <div id="jtv-best-sale-slider" class="product-flexslider">
            <div class="slider-items">
              <?php 
                $productLink = App\Models\Post::getProductLink(999,9); 
                foreach($productLink as $key=>$item) 
                {
              ?>
              <div class="product-item">
                <div class="item-inner">
                  <div class="product-thumbnail">
                    <center>
                      <div class="pr-img-area product-image"> <a title="<?php echo e($item['title']); ?>" href="<?php echo route('get.product.single',['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['title'])]) ?>">
                        <figure> 
                          <img class="first-img" src="<?php echo App\Models\Images::checkImageProduct($item['id']); ?>" alt="<?php echo e($item['title']); ?>">
                        </figure>
                        </a> 
                      </div>
                    </center>
                  </div>
                  <div class="item-info">
                    <div class="info-inner">
                      <div class="item-title">
                        <a title="<?php echo e($item['title']); ?>" href="<?php echo route('get.product.single',['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['title'])]) ?>">
                          <strong><?php echo e($item['title']); ?></strong>
                        </a>
                      </div>
                      <div class="item-content">
                        <div class="item-price">
                          <div class="price-box"> <span class="regular-price"><span class="price">
                          </span><?php echo $item['description']; ?></span>
                          </div>
                        </div>
                        <div class="pro-action">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>