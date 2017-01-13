
<?php
    echo $this->Html->script([
        'plugins/jQuery/jquery-2.2.3.min.js',
        'bootstrap/js/bootstrap.min.js',
        'dist/js/app.min.js',
        'js-system.js'
    ]);
?>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<?php
    echo $this->Html->script('date.js');
?>

<?php
    echo $this->fetch('extra-lib');
?>

<div class="modal fade" id="change-password">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Change password</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
	                  <label for="inputPassword3" class="col-sm-3 control-label">New Password</label>
	                  <div class="col-sm-8">
	                    <input type="password" class="form-control" id="password_update" required="required" name="password_update" placeholder="New Password">
	                  </div>
	                </div>
	                <div class="form-group">
	                  <label for="inputPassword3" class="col-sm-3 control-label">Confim Password</label>
	                  <div class="col-sm-8">
	                    <input type="password" class="form-control" id="" name="re_password_update" placeholder="Confim Password">
	                  </div>
	                </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="changePassword">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>