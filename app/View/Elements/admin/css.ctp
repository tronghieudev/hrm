<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />

<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

<style type="text/css">
	label.error {
		color: #a90000;
	}
	.bg {
		background: #fff;
		padding: 15px 0;
	}
	i.requi {
		color :red;
	}
</style>
<?php
    echo $this->Html->css([
        'admin_lib/bootstrap/css/bootstrap.min.css',
        'admin_lib/dist/css/AdminLTE.min.css',
        'admin_lib/dist/css/skins/_all-skins.min.css'
    ]);
?>
<?php
    echo $this->fetch('extra-style');
?>