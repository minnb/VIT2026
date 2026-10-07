<!-- Slideshow  -->
  <div class="main-slider" id="home">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 banner-left hidden-xs"><img src="<?php echo asset('public/home/images/banner-left.jpg') ;?>" alt="VIT"></div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xs-12 jtv-slideshow">
          <div id="jtv-slideshow">
            <div id='rev_slider_4_wrapper' class='rev_slider_wrapper fullwidthbanner-container' >
              <div id='rev_slider_4' class='rev_slider fullwidthabanner'>
                <ul>
                  <?php 
                    $data_slide = App\Models\Slide::orderBy('id','DESC')->skip(0)->take(5)->get();
                    foreach($data_slide as $key=>$value) { 
                  ?>
                  <li data-transition='fade' data-slotamount='7' data-masterspeed='1000' data-thumb=''><img src='<?php echo asset($value->image); ?>' data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat' alt="banner"/>
                  </li>
                <?php } ?>
                </ul>
                <div class="tp-bannertimer"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>