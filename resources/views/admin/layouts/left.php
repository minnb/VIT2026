<!-- Left Sidebar -->
<div class="left main-sidebar">
	<div class="sidebar-inner leftscroll">
		<div id="sidebar-menu">
		<ul>
			<li class="submenu">
				<a class="active" href="<?php echo route('dashboard') ?>"><i class="fa fa-fw fa-bars"></i><span> Dashboard </span> </a>
            </li>

            <li class="submenu">
                <a href="<?php echo route('get.admin.list.product') ; ?>"><i class="fa fa-fw fa-star"></i><span> Sản phẩm </span> </a>
            </li>
            <li class="submenu">
                <a href="<?php echo route('get.admin.list.product.link') ; ?>"><i class="fa fa-fw fa-star"></i><span> Sản phẩm liên kết </span> </a>
            </li>
            <li class="submenu">
                <a href="<?php echo route('get.admin.list.document') ; ?>"><i class="fa fa-fw fa-book"></i><span> Tài liệu </span> </a>
            </li>
            <li class="submenu">
                <a href="<?php echo route('get.admin.list.project') ; ?>"><i class="fa fa-fw fa-building"></i><span> Dự án </span> </a>
            </li>
            <li class="submenu">
                <a href="<?php echo route('get.admin.list.news') ; ?>"><i class="fa fa-fw fa-newspaper-o"></i><span> Tin tức </span> </a>
            </li>
            <li class="submenu">
                <a href="<?php echo route('get.admin.setting.slide.list') ; ?>"><i class="fa fa-fw fa-newspaper-o"></i><span> Hình ảnh slide </span> </a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-cog bigfonts"></i><span> Landing Page </span>  <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo route('get.admin.list.about') ; ?>">Giới thiệu công ty</a></li>
                        <li><a href="<?php echo route('get.admin.list.baohanh') ; ?>">Chính sách bảo hành</a></li>
                        <li><a href="<?php echo route('get.admin.list.baomat') ; ?>">Chính sách bảo mật</a></li>

                    </ul>
            </li>
             <li class="submenu">
                <a href="#"><i class="fa fa-cog bigfonts"></i><span> Cài đặt </span>  <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo route('get.admin.setting.hotline') ; ?>">Hotline</a></li>
                        <li><a href="<?php echo route('get.admin.setting.company') ; ?>">Thông tin công ty</a></li>
                    </ul>
            </li>
			<li class="submenu">
                <a href="#"><i class="fa fa-fw fa-table"></i> <span> Danh mục </span> <span class="menu-arrow"></span></a>
					<ul class="list-unstyled">
                        <li><a href="<?php echo route('get.admin.cate.product.list') ; ?>">Sản phẩm</a></li>
                        <li><a href="<?php echo route('get.admin.cate.project.list') ; ?>">Dự án</a></li>
                        <li><a href="<?php echo route('get.admin.cate.document.list') ; ?>">Tài liệu</a></li>
                        <li><a href="<?php echo route('get.admin.cate.new.list') ; ?>">Tin tức</a></li>
					</ul>
            </li>		
             <li class="submenu">
                <a href="#"><i class="fa fa-fw fa-user"></i><span> Users </span> </a>
            </li>
        </ul>
        <div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
	<!-- End Sidebar -->