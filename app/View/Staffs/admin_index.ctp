
<?php $this->Paginator->options(array(
    'url'=> array('controller' => 'staffs',
    'action' => 'index',
    'admin' => true
))); ?>

<?php
	$this->start('extra-lib');
?>	
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
	<?= $this->Html->script('date'); ?>
	<?= $this->Html->css('date'); ?>
	<script type="text/javascript">
		$(document).ready(function() {

			// ajax get form update salary
			$('.update-salary').on('click', function(e) {

				e.preventDefault();
				var id = $(this).data('id');
				$.ajax({
					url: ADMIN+'/staffs/getById',
					type: 'POST',
					data: {id: id},
				})
				.done(function(output) {

					if(output.data.UsersProfile.salary) {
						$('#update-salary #input-salary').val(output.data.UsersProfile.salary);
					}else{
						$('#update-salary #input-salary').val('');
					}
					$('#update-salary #input-id').val(output.data.UsersProfile.id);
					if(output.data.UsersProfile.currencies_id) {
						$('#select-currency').val(output.data.UsersProfile.currencies_id);
					}
					$('#update-salary').modal('show');
				});
			});

			// ajax submit form update salary
			$('#salary').validate({
				rules : {
					salary : {
						required : true,
						number : true
					},
					currency : 'required'
				},
				submitHandler: function(form) {
			    	var salary = $('input[name="salary"]').val();
			    	var currencies_id = $('select[name="currencies_id"]').val();
			    	var id = $('input[name="id"]').val();
		    		$.ajax({
						url: ADMIN+'/staffs/updateSalary',
						type: 'POST',
						data: {salary: salary, currencies_id: currencies_id, id : id},
					}).done(function(output) {
						if(output.status == 200) {
							alert(output.data.message);
							$('#update-salary').modal('hide');
						}else{
							console.log(output);
						}
					});
			  	}
			});

			// reset password

			$('.change-pass').on('click', function(e) {
				var r = confirm('Are you sure reset password?');
				if(r == true) {
					var id = $(this).data('id');
					e.preventDefault();
					$.ajax({
						url: ADMIN+'/staffs/resetPassword',
						type: 'POST',
						data: {id: id},
					})
					.done(function(output) {
						if(output.status == 200) {
							alert(output.data.message);
						}else{
							console.log(output);
						}
					});
				}
			});	

			//update avata
			$('.update-avata').on('click', function(e) {

				e.preventDefault();
				var id = $(this).data('id');
				$('#update-avata .id').val(id);
				$('#update-avata').modal('show');
			});

			//update cv
			$('.update-cv').on('click', function(e) {

				e.preventDefault();
				var id = $(this).data('id');
				$('#update-cv .id').val(id);
				$('#update-cv').modal('show');
			});

			// Validate add method file size upload.
			$.validator.addMethod('filesize', function (value, element, param) {
			    return this.optional(element) || (element.files[0].size <= param)
			}, 'File size must be less than {0} KB');

			// Validate form upload cv
			$( "#form-cv" ).validate({
				rules: {
					'data[cv]': {
						required: true,
						extension: "doc|docx|pdf",
						filesize : 2048
					}	
				}
			});

			// Validate form upload avata
			$( "#form-avata" ).validate({
				rules: {
					'data[avata]': {
						required: true,
						extension: "gif|jpeg|png|jpg",
						filesize : 1024
					}	
				}
			});

			// Get modal set overtime
			$('.overtime').on('click', function(e) {

				e.preventDefault();
				var id = $(this).data('id');
				$('#form-overtime .id').val(id);
				$('#overtime').modal('show');
			});

		 	$(".timepicker").timepicker({
	      		showInputs: false
	    	});
	    	$('.datepicker').datepicker({
		      	autoclose: true
		    });

		    // Validate post form set overtime

		    $('#form-overtime').validate({
				submitHandler: function(form) {
			    	var time_in_date = $('input[name="time_in_date"]').val();
			    	var time_in_time = $('input[name="time_in_time"]').val();
			    	var time_out_date = $('input[name="time_out_date"]').val();
			    	var time_out_time = $('input[name="time_out_time"]').val();
			    	var id = $('#form-overtime .id').val();
			    	
		    		$.ajax({

						url: ADMIN+'/staffs/setOvertime',
						type: 'POST',
						data: {id : id, time_in_date: time_in_date, time_in_time: time_in_time, time_out_date : time_out_date, time_out_time : time_out_time},
					}).done(function(output) {
						if(output.status == 200) {
							alert('Set over time success !');
							$('#overtime').modal('hide');
							$('input[name="time_in_date"]').val('');
							$('input[name="time_in_time"]').val('');
							$('input[name="time_out_date"]').val('');
							$('input[name="time_out_time"]').val('');
						}else{
							if(output.errors.valid) {
								alert('Validate false !');
							} else {
								alert(output.errors.message);
							}
						}
					});
			  	}
		    });

		    // View detail day off

		    $('.view-overtime').on('click', function(e) {

		    	e.preventDefault();
		    	var id = $(this).data('id');
		    	console.log(id);
		    	$.ajax({
		    		url: ADMIN+'/staffs/viewOvertime',
		    		type: 'POST',
		    		data: {id: id},
		    	})
		    	.done(function(output) {
		    		console.log(output);
		    		var html = '';
		    		var total_hours = 0;
		    		if(output.status == 200) {
			    		$.each(output.data, function(index, val) {
			    			
			    			html += '<tr>';
			    			html += '<td>'+val.UsersOvertime.time_in+'</td>';
			    			html += '<td>'+val.UsersOvertime.time_out+'</td>';
			    			var hour = (Date.parse(val.UsersOvertime.time_out) - Date.parse(val.UsersOvertime.time_in)) / 3600000;
			    			html += '<td>'+ hour +'</td>';
			    			html += '</tr>';
			    			total_hours += hour;
			    		});
			    		$('#view-day-off tbody').html(html);
			    		$('#total-hours').text(total_hours);
			    		$('#view-day-off #view').attr('data-id', id);
			    		$('#view-day-off').modal('show');
			    	}else{
						if(output.errors.valid) {
							alert('Validate false !');
						} else {
							alert(output.errors.message);
						}
					}
		    	});
		    });

		    // search detail OT
		    $('#view').on('click', function(e) {

		    	e.preventDefault();
		    	var id = $(this).data('id');
		    	var month = $('#month').val();
		    	var year = $('#year').val();
		    	$.ajax({
		    		url: ADMIN+'/staffs/viewOvertime',
		    		type: 'POST',
		    		data: {id: id, month : month, year :year},
		    	})
		    	.done(function(output) {
		    		var html = '';
		    		var total_hours = 0;
		    		$.each(output.data, function(index, val) {
		    			
		    			html += '<tr>';
		    			html += '<td>'+val.UsersOvertime.time_in+'</td>';
		    			html += '<td>'+val.UsersOvertime.time_out+'</td>';
		    			var hour = (Date.parse(val.UsersOvertime.time_out) - Date.parse(val.UsersOvertime.time_in)) / 3600000;
		    			html += '<td>'+ hour +'</td>';
		    			html += '</tr>';
		    			total_hours += hour;
		    		});
		    		$('#view-day-off tbody').html(html);
		    		$('#total-hours').text(total_hours);
		    		$('#view-day-off #view').attr('data-id', id);
		    		$('#view-day-off').modal('show');
		    	});
		    });

		    // set day off
		    $('.set-day-off').on('click', function(e) {

		    	var users_id = $(this).data('id');
		    	$('#modal-day-off .users_id').val(users_id);
		    	$('#modal-day-off').modal('show');
		    });

		    //save day off
		    $('#save-date-off').on('click', function(e) {

		    	var users_id = $('#modal-day-off .users_id').val();
		    	var day_start = $('#modal-day-off #day_start').val();
		    	var days = $('#modal-day-off #number_days').val();
		    	$.ajax({
		    		url: ADMIN+'/staffs/setDaysOff',
		    		type: 'POST',
		    		data: {users_id: users_id, day_start : day_start, days : days},
		    	})
		    	.done(function(output) {

		    		if(output.status == 200) {
			    		alert(output.data.message);
			    		$('#modal-day-off').modal('hide');
			    	}else{
						if(output.errors.valid) {
							alert('Validate false !');
						} else {
							alert(output.errors.message);
							
						}
					}
		    	});
		    });

		    // set day off
		    $('.set-day-leave').on('click', function(e) {

		    	var users_id = $(this).data('id');
		    	$('#modal-day-leave .users_id').val(users_id);
		    	$('#modal-day-leave').modal('show');
		    });

		    //save day off
		    $('#save-date-leave').on('click', function(e) {

		    	var users_id = $('#modal-day-leave .users_id').val();
		    	var day_start = $('#modal-day-leave #day_start').val();
		    	var days = $('#modal-day-leave #number_days').val();
		    	console.log(users_id+' '+day_start+' '+days);
		    	$.ajax({
		    		url: ADMIN+'/staffs/setDaysLeave',
		    		type: 'POST',
		    		data: {users_id: users_id, day_start : day_start, days : days},
		    	})
		    	.done(function(output) {
		    		if(output.status == 200) {
			    		alert(output.data.message);
			    		$('#modal-day-leave').modal('hide');
			    	}else{
						if(output.errors.valid) {
							alert('Validate false !');
						} else {
							alert(output.errors.message);
							
						}
					}
		    	});
		    });
		});
	</script>

	<!-- Modal set day leave -->
	<div class="modal fade" id="modal-day-leave">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Set day leave</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<input class="users_id" value="" type="hidden"></input>
							<div class="form-group">
								<label>Day start</label>
								<input class="form-control" type="date" value="<?= date('Y-m-d') ?>" id="day_start" name="day_start"></input>
							</div>
							
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Days</label>
								<input class="form-control" type="number" value="1
								" id="number_days" name="number_days"></input>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="save-date-leave">Save</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal set day off -->
	<div class="modal fade" id="modal-day-off">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Set day off</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<input class="users_id" value="" type="hidden"></input>
							<div class="form-group">
								<label>Day start</label>
								<input class="form-control" type="date" value="<?= date('Y-m-d') ?>" id="day_start" name="day_start"></input>
							</div>
							
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Days</label>
								<input class="form-control" type="number" value="" id="number_days" name="number_days"></input>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="save-date-off">Save</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal view Overtime -->
	<div class="modal fade" id="view-day-off">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">View Overtime</h4>
				</div>
				<div class="modal-body">
					<div>
						<div class="row">
							<div class="col-sm-5">
								<div class="form-group">
									<label>Tháng</label>
									<select class="form-control" name="month" id="month">
										<?php
											for($i = 1; $i <= 12; $i++) {
										?>
											<option value="<?= $i; ?>"><?= $i; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<label>Năm</label>
									<select class="form-control" name="year" id="year">
										<?php
											for($i = 2016; $i <= date('Y', time()); $i++) {
										?>
											<option value="<?= $i; ?>"><?= $i; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<label>#</label>
								<button id="view" data-id="" class="btn btn-success">Search</button>
							</div>
						</div>						
					</div>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Time in</th>
								<th>Time out</th>
								<th>Hours</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>1</td>
								<td>1</td>
							</tr>
						</tbody>
					</table>
					<div class="text-right">
						<strong>Total hours OT : </strong><span id="total-hours"></span> hour
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<!-- <button type="button" class="btn btn-primary">Save change</button> -->
				</div>
			</div>
		</div>
	</div>

	<!-- modal update salary -->
	<div class="modal fade" id="update-salary">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Update Salary</h4>
				</div>
				<form id="salary">
					<div class="modal-body">
						<div class="form-group">
							<label>Salary</label>
							<input class="form-control" name="salary" id="input-salary"></input>
							<input class="form-control" type="hidden" name="id" id="input-id"></input>
						</div>
						<div class="form-group">
							<label>Currency</label>
							<select name="currencies_id" class="form-control" id="select-currency">
								<?php 
									foreach($currencies as $key => $value) {
										echo "<option value='$key'>$value</option>";
									}
								?>
							</select>
						</div>
					</div> 
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" data-id="">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal update avata -->
	<div class="modal fade" id="update-avata">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Update Avata</h4>
				</div>
				<form id="form-avata" action="<?= $this->Html->url(['controller' => 'staffs', 'action' => 'uploadAvata', 'admin' => true]); ?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<input class="form-control" type="file" name="data[avata]"></input>
							<input type="hidden" name="id" class="id"></input>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal update cv -->
	<div class="modal fade" id="update-cv">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Update CV</h4>
				</div>
				<form id="form-cv" action="<?= $this->Html->url(['controller' => 'staffs', 'action' => 'uploadCV', 'admin' => true]); ?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<input class="form-control" type="file" name="data[cv]"></input>
							<input type="hidden" name="id" class="id"></input>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Model set overtime -->
	<div class="modal fade" id="overtime">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Set Overtime</h4>
				</div>
				<form method="POST" action="" id="form-overtime">
					<input class="id" type="hidden" name="id"></input>
					<div class="modal-body">
						
						<div class="form-group">
							<label>Time in</label>
							<div class="row">
								<div class="col-sm-7">
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="time_in_date" class="form-control pull-right datepicker">
									</div>
								</div>
								<div class="col-sm-5">
									<div class="bootstrap-timepicker"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">05</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">15</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
										<div class="form-group">

											<div class="input-group">
												<input type="text"  name="time_in_time" class="form-control timepicker">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
											<!-- /.input group -->
										</div>
										<!-- /.form group -->
										</div>
									</div>	
								<div class="clearfix"></div>			

							</div>
						</div>
						<div class="form-group">
							<label>Time out</label>
							<div class="row">
								<div class="col-sm-7">
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="time_out_date" class="form-control pull-right datepicker">
									</div>
								</div>
								<div class="col-sm-5">
									<div class="bootstrap-timepicker"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">05</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">15</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
										<div class="form-group">
										
											<div class="input-group">
												<input type="text" name="time_out_time" class="form-control timepicker">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
											<!-- /.input group -->
										</div>
										<!-- /.form group -->
									</div>
								</div>	
								<div class="clearfix"></div>			
								
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save change</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
	$this->end();
?>

<div class="col-xs-12 bg">
	<div style="margin-bottom: 20px;">
		<a class="btn btn-success pull-right" href='<?= $this->Html->url(['controller' => 'staffs', 'action' => 'create']); ?>'>Create new Staff</a>
		<p><?= $this->Session->flash(); ?></p>
		<div class="clearfix"></div>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Email</th>
				<th>PhoneNumber</th>
				<th>Gender</th>
				<th>Operation</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<form>
					<td></td>
					<td>
						<div class="form-group" style="margin-bottom: 0;">
							<input class="form-control" name="fullname" value="<?php if(isset($this->request->query['fullname'])) { echo $this->request->query['fullname']; } ?>"></input>
						</div>
					</td>
					<td>
						<div class="form-group" style="margin-bottom: 0;">
							<input class="form-control" name="email" value="<?php if(isset($this->request->query['email'])) { echo $this->request->query['email']; } ?>"></input>
						</div>
					</td>
					<td>
						<div class="form-group" style="margin-bottom: 0;">
							<input class="form-control" name="phone_number" value="<?php if(isset($this->request->query['phone_number'])) { echo $this->request->query['phone_number']; } ?>"></input>
						</div>
					</td>
					<td>
					</td>
					<td>
						<input type="submit" class="btn btn-success" value="Search"></input>
						<i class="fa fa-close" style="color: red;" onclick="window.location.href='<?= $this->Html->url(['controller' => 'staffs', 'action' => 'index']) ?>'"></i>
					</td>
				</form>
			</tr>
			<?php if(count($data) > 0) { ?>
				
			    <?php foreach($data as $item) { ?>
		            <tr id="tr<?php echo $item['UsersProfile']['id']; ?>">
		                <td><?php echo $item['UsersProfile']['id']; ?></td>
		                <td class="name">
		                <?php 
		                	echo $this->Html->link(
								$item['UsersProfile']['fullname'],
								array(
								    'controller' => 'staffs',
								    'action' => 'show',
								    'admin' => true,
								    '?' => ['id' => $item['UsersProfile']['users_id']]
								)
							); 
						?>
</td>
		                <td><?= $item['User']['email']; ?></td>
		                
		                <td><?= $item['UsersProfile']['phone_number']; ?></td>
		                <td><?= Constants::GENDER[$item['UsersProfile']['gender']]; ?></td>
		                <td>
		                 	<div class="dropdown text-center">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									Update
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<li class="update-salary" data-id="<?php echo $item['UsersProfile']['users_id']; ?>"><a href="#">Salary</a></li>
									<li class="update-avata" data-id="<?php echo $item['UsersProfile']['id']; ?>"><a href="#" >Avata</a></li>
									<li class="update-cv" data-id="<?php echo $item['UsersProfile']['id']; ?>"><a href="#">CV</a></li>
									<li>
										<?= $this->Html->link('Profile', array(
										    'controller' => 'staffs',
										    'action' => 'view',
										    'id' => $item['UsersProfile']['id'],
										    'admin' => true
										)); ?>
									</li>
									<li><a href="" class="overtime" data-id="<?= $item['UsersProfile']['users_id']; ?>">Overtime</a></li>
									<li><a href="#" class="view-overtime" data-id="<?= $item['UsersProfile']['users_id']; ?>">View overtime</a></li>
									<li><a href="#" class="set-day-off" data-id="<?= $item['UsersProfile']['users_id']; ?>">Set day off</a></li>
									<li><a href="#" class="set-day-leave" data-id="<?= $item['UsersProfile']['users_id']; ?>">Set day leave</a></li>
									<li><a href="#" class="change-pass" data-id="<?= $item['UsersProfile']['users_id']; ?>">Reset Password</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="#">Remove</a></li>
								</ul>
							</div>
		                 	
		                 </td>
		            </tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td>No staff</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
    <?php if($this->params['paging']['UsersProfile']['pageCount'] > 1) { ?>
        <ul class="pagination">
            <?php
                echo $this->Paginator->prev(__('&laquo;'), array('tag' => 'li', 'escape' => false), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a', 'escape' => false));
                echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
                echo $this->Paginator->next(__('&raquo;'), array('tag' => 'li','currentClass' => 'disabled', 'escape' => false), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a', 'escape' => false));
            ?>
        </ul>
	<?php } ?>
</div>
<div class="clearfix"></div>
