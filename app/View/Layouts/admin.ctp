<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>AdminLTE 2 | Dashboard</title>
		<!-- Tell the browser to be responsive to screen width -->
		<!-- Load css -->
		<?php echo $this->element('/admin/css') ?>

	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<header class="main-header">
				<?php echo $this->element('/admin/top-header') ?>
			</header>
			<!-- Left side column. contains the logo and sidebar -->
			<aside class="main-sidebar">
				<!-- sidebar: style can be found in sidebar.less -->
				<?php echo $this->element('/admin/nav') ?>
				<!-- /.sidebar -->
			</aside>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<?php echo $this->element('/admin/content-header') ?>
				<!-- Main content -->
				<section class="content">
					<!-- Small boxes (Stat box) -->
					<?php echo $this->fetch('content'); ?>
					<!-- /.row (main row) -->
				</section>
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<b>Version</b> 2.3.8
				</div>
				<strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
				reserved.
			</footer>
			
		</div>
		<!-- ./wrapper -->
		<!-- lib javascript -->
        <?php echo $this->element('/admin/script') ?>
	</body>
</html>