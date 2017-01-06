<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<form style="margin-bottom: 15px;">

						<div class="form-group">
							<label>Day</label>
							<div class="row">
								<div class="col-sm-3">
									<input type="date" class="form-control" value="<?php if(isset($this->request->query['day'])) { echo $this->request->query['day'];} ?>" name="day"></input>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success">View</button>
								</div>
							</div>
							
						</div>
						
					</form>
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="text-center" style="background: #ffd78e; font-weight: bold;">
								<?php
									foreach($days as $k => $day) {
								?>
								<td>
									<?= $k.' '.$day;?> <br />
									<a href="#" class="booking btn btn-primary btn-xs" data-date="<?= $day ?>" data-th="<?= $k ?>">Booking</a>
								</td>
								
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php
									foreach($days as $th => $day) {
								?>
								<td>
									<?php
										if(isset($data[$day])){
											foreach($data[$day] as $k => $val) {
									?>
											<?php

												if($k == 0){
													$height = (strtotime($val['Calendar']['time_in']) - strtotime($day.' '.date('G:i:s', time())))/60; 
													if ($height > 0) {
											?>
												<p style="position: relative;margin-bottom: 0;height: 100px;text-align: center; color: #fff; background: url(http://www.vnphotography.org/images/StarryNight/14%20image-add-noise.jpg)">
													Free time
													<a style="position:absolute; bottom: 10px;right: 10px;" href="#" class="booking btn btn-primary btn-xs" data-date="<?= $day ?>" data-th="<?= $th ?>">Booking</a>
												</p>
											<?php
													}
												}
											?>	
											<?php
												if(isset($data[$day][$k-1])){
													$height = (strtotime($val['Calendar']['time_in']) - strtotime($data[$day][$k-1]['Calendar']['time_out']))/60; 
													if ($height > 0) {
											?>
												<p class="box-<?= $val['Calendar']['id']; ?>" style="margin-bottom: 0;height: <?= $height ?>px;text-align: center; color: #fff; background: url(http://www.vnphotography.org/images/StarryNight/14%20image-add-noise.jpg)">
													Free time
												</p>
											<?php
													}
												}
											?>
											<p class="text-center box-<?= $val['Calendar']['id']; ?>" id="" style="color: #fff;padding-bottom: 10px;margin-bottom: 0px;background:#<?= $color = substr(md5(rand()), 0, 6); ?>">
												<?= $val['User']['email'] ?> <br />
												<?= $val['User']['Department']['name'] ?><br />
												<?= date('H:i', strtotime($val['Calendar']['time_in'])) ?> -
												<?= date('H:i', strtotime($val['Calendar']['time_out'])) ?>
												<?php
													if($val['Calendar']['users_id'] == $user_id) {

												?>
														<br /> <a href="#" style="color:#fff" class="edit btn btn-primary btn-xs" data-id="<?= $val['Calendar']['id'] ?>"><i class="glyphicon glyphicon-pencil"></i></a>
														<a href="#" style="color:#fff" class="remove btn btn-danger btn-xs" data-id="<?= $val['Calendar']['id'] ?>"><i class="glyphicon glyphicon-remove"></i></a>
												<?php
													}
												?>
											</p>
											
											<?php

												if($k == count($data[$day]) - 1){
													$height = (strtotime($day.' 23:59:59') - strtotime($val['Calendar']['time_in']))/60; 
													if ($height > 0) {
											?>
												<p style="position: relative;margin-bottom: 0;height: 100px;text-align: center; color: #fff; background: url(http://www.vnphotography.org/images/StarryNight/14%20image-add-noise.jpg)">
													Free time to 24h
													<a style="position:absolute; bottom: 10px;right: 10px;" href="#" class="booking btn btn-primary btn-xs" data-date="<?= $day ?>" data-th="<?= $th ?>">Booking</a>
												</p>
											<?php
													}
												}
											?>	
											
									<?php
											}
										} else {
									?>
										<p style="position: relative;margin-bottom: 0;height: 100px;text-align: center; color: #fff; background: url(http://www.vnphotography.org/images/StarryNight/14%20image-add-noise.jpg)">
											Free time to 24h
											<a style="position:absolute; bottom: 10px;right: 10px;" href="#" class="booking btn btn-primary btn-xs" data-date="<?= $day ?>" data-th="<?= $th ?>">Booking</a>
										</p>
									<?php
										}
									?>
								</td>
								<?php } ?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
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
				$('.booking').on('click', function(e) {

					e.preventDefault();
					var date = $(this).data('date');
					var th = $(this).data('th');
					$('#time_in_date').val(date);
					$('#date_time').text(th+' '+date);
					$('#modal-booking').modal('show');
				});

				// create calendar
				$('#form-overtime').validate({
					submitHandler: function(form) {
				    	var time_in_date = $('input[name="time_in_date"]').val();
				    	var time_in_time = $('input[name="time_in_time"]').val();
				    	var time_out_time = $('input[name="time_out_time"]').val();
				    	// var id = $('#form-overtime .id').val();
				    	
			    		$.ajax({

							url: '/calendars/booking',
							type: 'POST',
							data: {time_in_date: time_in_date, time_in_time: time_in_time, time_out_time : time_out_time},
						}).done(function(output) {
							
							if(output.status == 200) {
								alert(output.data.message);
								location.reload();
							}else{
								alert(output.errors.message);
							}
						});
				  	}
			    });

				$('.edit').on('click', function (e) {

					e.preventDefault();
					var id = $(this).data('id');
					$.ajax({
						url: '/calendars/edit',
						type: 'GET',
						data: {id: id},
					})
					.done(function(output) {
						if(output.status == 200) {
							var time_in_date = $('input[name="time_in_date_edit"]').val(output.data.day);
					    	var time_in_time = $('input[name="time_in_time_edit"]').val(output.data.time_in);
					    	var time_out_time = $('input[name="time_out_time_edit"]').val(output.data.time_out);
				    		$('#modal-booking-edit #id').val(id);
				    		$('#date_time_edit').text(output.data.day);
				    		$('#modal-booking-edit').modal('show');
				    	}
					});
					
				});

				// edit calender
				$('#form-overtime-edit').validate({
					submitHandler: function(form) {
				    	var time_in_date = $('input[name="time_in_date_edit"]').val();
				    	var time_in_time = $('input[name="time_in_time_edit"]').val();
				    	var time_out_time = $('input[name="time_out_time_edit"]').val();
				    	var id = $('#form-overtime-edit #id').val();
				    	console.log(time_in_time);
			    		$.ajax({

							url: '/calendars/edit',
							type: 'POST',
							data: {id : id,time_in_date: time_in_date, time_in_time: time_in_time, time_out_time : time_out_time},
						}).done(function(output) {
							if(output.status == 200) {
								alert(output.data.message);
								location.reload();
							}else{
								alert(output.errors.message);
							}
						});
				  	}
			    });
			    // remove meeting
			    $('.remove').on('click', function(e) {

			    	e.preventDefault();
			    	var id = $(this).data('id');
			    	var r = confirm('Are you sure ?');
					if(r == true) {
						$.ajax({
							url: '/calendars/remove',
							type: 'POST',
							data: {id: id},
						})
						.done(function(output) {
							if(output.status == 200) {
								alert(output.data.message);
								$('.box-'+id).remove();
							}else{
								alert(output.errors.message);
							}
						});
					}
			    });
			});
		</script>
		<div class="modal fade" id="modal-booking">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Booking</h4>
					</div>
					<form method="POST" action="/calendars/booking" id="form-overtime">
						<input class="id" type="hidden" name="id"></input>
						<div class="modal-body">
							
							<div class="form-group">
								<p>You are booking the meeting room on <strong id="date_time"></strong> .Please choose the time frame of your meeting below.</p>
								<label>Time :</label>
								<div class="row">
									<!-- <div class="col-sm-12">
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" name="time_in_date" class="form-control pull-right datepicker">
										</div>
									</div> -->
									<input type="hidden" id="time_in_date" name="time_in_date" class="form-control pull-right datepicker">
									<p style="clear:both;max-width: 15px"></p>
									<div class="col-sm-6">
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
									<div class="col-sm-6">
										<div class="bootstrap-timepicker"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">05</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">15</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
											<div class="form-group">

												<div class="input-group">
													<input type="text"  name="time_out_time" class="form-control timepicker">

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
		<div class="modal fade" id="modal-booking-edit">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Booking</h4>
					</div>
					<form method="POST" action="/calendars/edit" id="form-overtime-edit">
						<input class="id" type="hidden" name="id" value=""></input>
						<div class="modal-body">
							
							<div class="form-group">
								<p>You are edit booking the meeting room on <strong id="date_time_edit"></strong> .Please choose the time frame of your meeting below.</p>
								<label>Time :</label>
								<div class="row">
									<input type="hidden" id="time_in_date" name="time_in_date_edit" class="form-control pull-right datepicker">
									<input type="hidden" id="id" name="id" class="form-control pull-right">
									<p style="clear:both;max-width: 15px"></p>
									<div class="col-sm-6">
										<div class="bootstrap-timepicker"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">05</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">15</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
											<div class="form-group">

												<div class="input-group">
													<input type="text"  name="time_in_time_edit" class="form-control timepicker">

													<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
													</div>
												</div>
												<!-- /.input group -->
											</div>
											<!-- /.form group -->
											</div>
										</div>	
									<div class="col-sm-6">
										<div class="bootstrap-timepicker"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">05</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">15</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
											<div class="form-group">

												<div class="input-group">
													<input type="text"  name="time_out_time_edit" class="form-control timepicker">

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
	</body>
</html>