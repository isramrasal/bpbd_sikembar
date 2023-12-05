<body class="md-skin">
    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
					<div class="dropdown profile-element"> <span>
						<img alt="image" class="img-circle" src="<?php echo base_url(); ?><?php echo $foto_user; ?>" />
						 </span>
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $email; ?></strong>
						 </span> <span class="text-muted text-xs block"><?php echo $role_user; ?> <b class="caret"></b></span> </span> </a>
						<ul class="dropdown-menu animated fadeInRight m-t-xs">
							<li><a href="#">Terakhir login:
							</br><?php echo $last_login; ?></a></li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url(); ?>index.php/log_aktivitas">Log Aktivitas</a></li>
							<li><a href="<?php echo base_url(); ?>index.php/ganti_password">Ganti Password</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url(); ?>index.php/auth/logout">Logout</a></li>
						</ul>
					</div>