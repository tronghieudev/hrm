<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		
		<div class="container-fuild">
			<div class="form-login">
				<div class="logo">
					<img src="http://nal.vn/wp-content/uploads/cropped-logo11.png" width="220" height="75" alt="">
				</div>
				<?php
					echo $this->Session->flash();
				?>
				<?php echo $this->Form->create('User'); ?>
					
					<div class="form-group">
						<?php echo $this->Form->input('email', ['class' => 'form-control', 'placeholder' => 'Email']); ?>
					</div>
					<div class="form-group">
						<?php echo $this->Form->input('password', ['class' => 'form-control', 'placeholder' => 'Password']);?>
					</div>
					
					<div class="form-group">
						<div class="checkbox">
							<input type="checkbox" name="Remember" value="1" style="margin-left: 0px;">
							<label class="">Remember</label>
						</div>
						<button type="submit" class="btn btn-primary pull-right">Submit</button>
					</div>
					
				<?php echo $this->Form->end(); ?>
				<div class="clearfix"></div>
				<div class="over">
					<div class="border">
						<p><a href="/auth/register">Register account</a></p>
						<p><a href="">Forgot password ?</a></p>
					</div>
				</div>
			</div>
		</div>
		<style type="text/css">
			.over{
				margin: 0 -20px;
			}
			.border{
				padding: 20px 20px 0;
				margin-top: 10px;
				border-top: 1px solid #ccc;
				text-align: center;
			}
			.border p{
				margin-bottom: 0;
			}
			input[type=checkbox].css-checkbox:checked + label.css-label {
				background-image: url('/public/frontend/images/icon/is_check.png');
			}
			.css-checkbox{
				display: none;
			}
			input[type=checkbox].css-checkbox + label.css-label {
				padding-left: 25px;
				height: 15px;
				display: inline-block;
				line-height: 15px;
				background-repeat: no-repeat;
				background-position: 0 0;
				font-size: 15px;
				vertical-align: middle;
				cursor: pointer;
				background-image: url('/public/frontend/images/icon/not_check.png');
			}
			body {
				background: #f4f4f4;
			}
			.container-fuild{
				padding: 100px 0;
			}
			.form-login{
				max-width: 400px;
				margin: auto;
				padding: 20px;
				border: 1px solid #ccc;
				background: #fff;
				border-top: 3px solid #4d7496;
			}
			.logo{
				text-align: center;
				margin-bottom: 10px;
			}
			.form-control{
				height: 38px;
				border-radius: 0;
				border-left: 3px solid #4d7496;
			}
			.btn{
				border-radius: 0;
				padding: 6px 20px;
				background: #3968c6;
			}
			#flashMessage {
				color: #f00;
			}
		</style>
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	</body>
</html>