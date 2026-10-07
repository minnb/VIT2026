<!DOCTYPE html>
<html lang="en" ng-app="app-VIT">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard - VITDUCT</title>
	<meta name="description" content="Vitduct">
	<meta name="author" content="Vitduct">
	<link rel="icon" type="image/x-icon" href="<?php echo asset('public/favicon.ico'); ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo asset('public/assets/icons/favicon-32x32.png'); ?>">
	<link href="<?php echo asset('public/assets/css/bootstrap.min.css') ; ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset('public/assets/font-awesome/css/font-awesome.min.css') ; ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset('public/assets/css/style.css') ; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset('public/assets/plugins/jquery.filer/css/jquery.filer.css') ; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset('public/assets/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') ; ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
    <script type="text/javascript">
        var baseURL = "<?php echo url('/'); ?>";
        window.setTimeout(function() {
            $("#flash-message").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
            });
        }, 5000);
    </script>
</head>
<body class="adminbody">
<div id="main">
	<!-- top bar navigation -->
	<div class="headerbar">
		<!-- LOGO -->
        <div class="headerbar-left">
			<a href="<?php echo route('dashboard') ?>" class="logo"><span><b>VITDUCT</b></span></a>
        </div>
        <nav class="navbar-custom">
                    <ul class="list-inline float-right mb-0">
                        <li class="list-inline-item dropdown notif">
                            <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="<?php echo asset('public/assets/images/avatars/admin.png') ?>" alt="Profile image" class="avatar-rounded">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="text-overflow"><small>Hello, <?php echo Auth::user()->name ?></small> </h5>
                                </div>
                               <!-- item-->
                                <a href="<?php echo route('logout') ?>" class="dropdown-item notify-item" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off"></i> <span> Logout</span>
                                </a>
								<form id="logout-form" action="<?php echo route('logout') ?>" method="POST" style="display: none;">
                                     <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                                </form>
                            </div>
                        </li>
                    </ul>
                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left">
								<i class="fa fa-fw fa-bars"></i>
                            </button>
                        </li>                        
                    </ul>
        </nav>
	</div>
	<!-- End Navigation -->
