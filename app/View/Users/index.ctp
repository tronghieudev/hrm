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
		<h1 class="text-center"><?= $data['UsersProfile']['0']['fullname']; ?></h1>
		<div class="text-center">
			<p>
				<strong>Số ngày nghỉ có lương còn lại : </strong>
				<?= $data['User']['days_leave'].'/'. (12 + 1 - date('m')) .' tháng'; ?> - 
				Bạn có thể nghỉ <strong><?= ($data['User']['days_leave'] >= 12 + 1 - date('m')) ? $day_leave =  ($data['User']['days_leave'] + 1) - (12 + 1 - date('m')) : $day_leave =  0; ?></strong> ngày.
			</p>
			<p>
				<strong>Thời gian OT trong tháng : </strong>
				<a class="" data-toggle="modal" href='#overtime'>Request OT</a>
				<br />
				Ngày thường : <?= $overtime['day_normal'] ;?>h <br />
				Ngày nghỉ : <?= $overtime['day_off'] ;?>h <br />
				Ngày lễ : <?= $overtime['holiday'] ;?>h
			</p>
			<p>
				<strong>Số ngày nghỉ có lương trong tháng : </strong>
				<?php 
					if (isset($data['UsersDaysLeave']['0'])) { 
						echo $data['UsersDaysLeave']['0']['UsersDaysLeave'][0]['total'];
					} else {
						echo 0;
					} 
				?> ngày 
				<?php
					if ($day_leave > 0) {
				?>
					<a class="" data-toggle="modal" href='#modal-leave'>Request day leave</a>
				<?php
					}
				?>
			</p>
			<p>
				<strong>Số ngày nghỉ không lương trong tháng : </strong>
				<?php 
					if (isset($data['UsersDaysOff']['0'])) {
						echo  $data['UsersDaysOff']['0']['UsersDaysOff'][0]['total'];
					} else {
						echo 0;
					} 
				?> ngày 
				<a class="" data-toggle="modal" href='#modal-off'>Request day off</a>
			</p>
			
		</div>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
		<?= $this->Html->script('date'); ?>
		<?= $this->Html->css('date'); ?>

		<script type="text/javascript">
			$(document).ready(function() {
				
				$(".timepicker").timepicker({
		      		showInputs: false
		    	});
		    	$('.datepicker').datepicker({
			      	autoclose: true
			    });

			    //save day off
			    $('#save-date-off').on('click', function(e) {

			    	var users_id = $('#modal-off .users_id').val();
			    	var day_start = $('#modal-off #day_start').val();
			    	var days = $('#modal-off #number_days').val();
			    	$.ajax({
			    		url: '/users/dayOff',
			    		type: 'POST',
			    		data: {users_id: users_id, day_start : day_start, days : days},
			    	})
			    	.done(function(output) {

			    		if(output.status == 200) {
				    		alert(output.data.message);
				    		$('#modal-off').modal('hide');
				    	}else{
							if(output.errors.valid) {
								alert('Validate false !');
							} else {
								alert(output.errors.message);
								
							}
						}
			    	});
			    });

			    $('#save-date-leave').on('click', function(e) {

			    	var users_id = $('#modal-leave .users_id').val();
			    	var day_start = $('#modal-leave #day_start').val();
			    	var days = $('#modal-leave #number_days').val();
			    	console.log(users_id+' '+day_start+' '+days);
			    	$.ajax({
			    		url: '/users/dayLeave',
			    		type: 'POST',
			    		data: {users_id: users_id, day_start : day_start, days : days},
			    	})
			    	.done(function(output) {
			    		if(output.status == 200) {
				    		alert(output.data.message);
				    		$('#modal-leave').modal('hide');
				    	}else{
							if(output.errors.valid) {
								alert('Validate false !');
							} else {
								alert(output.errors.message);
								
							}
						}
			    	});
			    });

			    // Validate post form set overtime

			    $('#form-overtime').validate({
					submitHandler: function(form) {
				    	var time_in_date = $('input[name="time_in_date"]').val();
				    	var time_in_time = $('input[name="time_in_time"]').val();
				    	var time_out_date = $('input[name="time_out_date"]').val();
				    	var time_out_time = $('input[name="time_out_time"]').val();
				    	var type = $('input[name="type"]:checked').val();
				    	var id = $('#form-overtime .id').val();
				    	console.log(type);
			    		$.ajax({

							url: '/users/overtime',
							type: 'POST',
							data: {id : id, time_in_date: time_in_date,type :type, time_in_time: time_in_time, time_out_date : time_out_date, time_out_time : time_out_time},
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

			});
		</script>

		<!-- Modal ot -->
		<div class="modal fade" id="overtime">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Set Overtime</h4>
					</div>
					<form method="POST" action="" id="form-overtime">
						<input class="id" type="hidden" name="id" value="<?= $data['User']['id'] ?>"></input>
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
									<div class="col-sm-12">
										<label class="radio-inline">
											<input type="radio" name="type" id="" value="1" checked=""> Ngày bình thường
										</label>
										<label class="radio-inline">
											<input type="radio" name="type" id="" value="2"> Ngày nghỉ
										</label>
										<label class="radio-inline">
											<input type="radio" name="type" id="" value="3"> Ngày lễ
										</label>
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

		<!-- Modal day leave -->
		<div class="modal fade" id="modal-leave">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Set day leave</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<input class="users_id" value="<?= $data['User']['id'] ?>" type="hidden"></input>
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

		<!-- Modal day off -->
		<div class="modal fade" id="modal-off">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Set day off</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<input class="users_id" value="<?= $data['User']['id'] ?>" type="hidden"></input>
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
	</body>
</html>