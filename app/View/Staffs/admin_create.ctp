<?php 
	$this->start('extra-lib');
?>
	<script type="text/javascript">
		$(document).ready(function() {

			$('#staff-create').validate({
				rules : {
					email : {
						email : true
					},
					phone_number: "PHONE"
				}
			});
		});
	</script>
<?php
	$this->end();
?>
<div class="col-xs-12 bg">
	<h3>Create Staff</h3>
	<div>
		<?php 
			if(isset($errors)) { 
				foreach($errors as $val) {
					foreach($val as $v) {
		?>
						<p style="color: red;"> - <?= $v; ?></p>
		<?php 
					}
				}
			} 
		?>
	</div>
	<div class="row">
		<form action="" id="staff-create" method="post" enctype="multipart/form-data">
			<div class="col-sm-6">
				<div class="form-group">
					<label>Fullname <i class="requi">*</i></label>
					<input class="form-control" name="fullname" required="required"></input>
				</div>
				<div class="form-group">
					<label>Email  <i class="requi">*</i></label>
					<input class="form-control" name="email" required="required"></input>
				</div>
				<div class="form-group">
					<label>Position <i class="requi">*</i></label>
					<select class="form-control" name="positions_id" required="required">
						<?php foreach($listPostions as $key => $item) { ?>
							<option value="<?= $key ?>"><?= $item ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Department <i class="requi">*</i></label>
					<select class="form-control" name="departments_id" required="required">
						<?php foreach($listDepartments as $key => $item) { ?>
							<option value="<?= $key ?>"><?= $item ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Address <i class="requi">*</i></label>
					<input class="form-control" name="address" required="required"></input>
				</div>

				<div class="form-group">
					<label>PhoneNumber <i class="requi">*</i></label>
					<input class="form-control" name="phone_number" required="required"></input>
				</div>
				<div class="form-group">
					<label>Salary <i class="requi">*</i></label>
					<input class="form-control" type="number" name="salary" required="required"></input>
				</div>
				<div class="form-group">
					<label>Ăn Trưa</label>
					<input class="form-control" name="money_lunch" ></input>
				</div>
				<div class="form-group">
					<label>Điện Thoại</label>
					<input class="form-control" name="money_phone" ></input>
				</div>
				<div class="form-group">
					<label>Trợ cấp trang phục</label>
					<input class="form-control" name="money_costume"></input>
				</div>
				
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Xăng Xe</label>
					<input class="form-control" name="money_gasoline"></input>
				</div>
				<div class="form-group">
					<label>Hỗ trợ nhà ở</label>
					<input class="form-control" name="money_house" ></input>
				</div>
				<div class="form-group">
					<label>Hệ số hoàn thành công việc</label>
					<input class="form-control" name="money_complete"></input>
				</div>
				<div class="form-group">
					<label>Lương theo hiệu quả công việc</label>
					<input class="form-control" name="money_efficiency"></input>
				</div>
				<div class="form-group">
					<label>ATM</label>
					<input class="form-control" name="atm"></input>
				</div>
				<div class="form-group">
					<label>Birthday:</label>

					<div class="row">
						<div class="col-sm-4">
							<select class="form-control" name="birthday[d]" required="required">
								<?php foreach(range(1, 31) as $d) { ?>
									<option value="<?= $d; ?>"><?= $d; ?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-4">
							<select class="form-control" name="birthday[m]" required="required">
								<?php foreach(range(1, 12) as $m) { ?>
									<option value="<?= $m; ?>"><?= $m; ?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-4">
							<select class="form-control" name="birthday[y]" required="required">
								<?php foreach(range(1970, date('Y', time())) as $y) { ?>
									<option value="<?= $y; ?>"><?= $y; ?></option>
								<?php }?>
							</select>
						</div>
					</div>
				<!-- /.input group -->
				</div>
				<div class="form-group">
					<label>Gender <i class="requi">*</i></label>
					<select class="form-control" name="gender" required="required">
						<option value="0">FeMale</option>
						<option value="1" selected="">Male</option>
					</select>
				</div>
				
				<div class="form-group">
					<label>Description</label>
					<textarea class="form-control" name="description" rows="9" style="resize : none;"></textarea>
				</div>
			</div>
			<div class="col-sm-12">
				<button class="btn btn-success pull-right">Create new</button>
				
			</div>
			<div class="clearfix"></div>
		</form>
	</div>
</div>
<div class="clearfix"></div>
