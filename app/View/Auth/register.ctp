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
		<div class="container">
			<h1 class="text-center">Register</h1>
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<form action="" method="POST">
						<!-- <div class="group">
							<label>Fullname</label>
							<input class="form-control" type="text" name="fullname"></input>
						</div> -->
						<div class="form-group">
							<label>Email</label>
							<input class="form-control" type="email" name="email"></input>
							<?php if(isset($errors['email'])){ echo '<span class="err">'.$errors['email'][0].'</span>';} ?>
							<?php if(isset($error_mail)){ echo '<span class="err">'.$error_mail.'</span>';} ?>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input class="form-control" type="password" name="password_update"></input>
							<?php if(isset($errors['password_update'])){ echo '<span class="err">'.$errors['password_update'][0].'</span>';} ?>
						</div>
						<div class="form-group">
							<label>Confim password</label>
							<input class="form-control" type="password" name="re_password_update"></input>
							<?php if(isset($errors['re_password_update'])){ echo '<span class="err">'.$errors['re_password_update'][0].'</span>';} ?>
						</div>
						<div class="form-group">
							<label>Team</label>
							<select class="form-control" name="departments_id">
								<?php
									foreach ($teams as $item) {
								?>
									<option value="<?= $item['Department']['id']; ?>"><?= $item['Department']['name']; ?></option>
								<?php } ?>
							</select>
							<?php if(isset($errors['departments_id'])){ echo '<span class="err">'.$errors['departments_id'][0].'</span>';} ?>
						</div>
						<button type="submit" class="btn btn-primary">Register</button>
					</form>
				</div>
				<div class="col-sm-3"></div>
			</div>
		</div>
		<style type="text/css">
			.row {

			}
			.form-control {
				border-radius: 0;
			}
		</style>
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<style type="text/css">
			.err {
				color: red;
			}
		</style>
		<?php
			if (isset($success)) {
		?>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#modal-success').modal('show');
				});
				
			</script>

			
		<?php	
			}
		?>
		<div class="modal fade" id="modal-success">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Notify</h4>
					</div>
					<div class="modal-body">
						<?= $success ?>
					</div>
					<div class="modal-footer">
						<a type="button" class="btn btn-primary" href="/auth/login">Login</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>