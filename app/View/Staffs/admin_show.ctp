<div class="col-xs-12 bg">
	<div style="margin-bottom: 20px;">
		<a class="btn btn-success pull-right" href='<?= $this->Html->url(['controller' => 'staffs', 'action' => 'create']); ?>'>Create new Staff</a>
		<p><?= $this->Session->flash(); ?></p>
		<div class="clearfix"></div>
	</div>
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Ho tên</th>
					<th width="30%"></th>
					<th>Ghi chú</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><strong>Thông tin lương thỏa thuận</strong></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Lương cơ bản</td>
					<td><?= number_format($data['Salary']['salary']) ?></td>
					<td></td>
				</tr>
				<tr>
					<td>Phụ cấp chức vụ</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Phụ cấp tiếng nhật</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Phụ cấp dự án</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>Tổng lương</strong></td>
					<td><?= number_format($data['Salary']['salary']) ?></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>Thông tin ngày công</strong></td>
					<td><?= $day ?></td>
					<td></td>
				</tr>
				<tr>
					<td>Công định mức</td>
					<td><?= $day ?></td>
					<td></td>
				</tr>
				<tr>
					<td>Ngày công thực tế </td>
					<td>
						<?php
							$dayTotal = $day;
							$dayOff = 0;
							$dayLeave = 0;
							if (count($data['UsersDaysOff'])) {

								$dayOff = $data['UsersDaysOff'][0]['UsersDaysOff'][0]['total'];
							}
							if (count($data['UsersDaysLeave'])) {

								$dayLeave = $data['UsersDaysLeave'][0]['UsersDaysLeave'][0]['total'];
							}

							echo $dayTotal =  $dayTotal - $dayLeave - $dayOff. ' ( '.$dayOff.' ngày nghỉ)';
						?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>Ngày phép</td>
					<td>
						<?=
							$dayLeave;
						?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td><strong>Thông tin lương</strong></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Tổng lương + phụ cấp</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Tổng lương thực tế</td>
					<td>
						<?php
							$salaryOneDay = $data['Salary']['salary'] / $day;
							echo number_format($salaryOneDay * ($dayTotal+$dayLeave));
						?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>Lương thêm giờ</td>
					<td>
						- Ngày thường
						<strong><?= $overtime['day_normal']; ?></strong>h = 
						<?php
							$salary_normal = round($overtime['day_normal'] * $salaryOneDay/ 8 * 1,5);
							echo number_format($salary_normal);
						?>
						<br/>
						- Ngày nghỉ
						<strong><?= $overtime['day_off']; ?></strong>
						h = 
						<?php
							$salary_off = round($overtime['day_off'] * $salaryOneDay * 2);
							echo number_format($salary_off ); 
						?> 
						<br/>
						- Ngày lễ
						<strong><?= $overtime['holiday']; ?></strong>
						h = 
						<?php
							$salary_holiday = round($overtime['holiday'] * $salaryOneDay * 3);
							echo number_format($salary_holiday); 
						?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>Công tác phí</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>Các khoản khấu trừ vào lương</strong></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Lương cơ bản</td>
					<td>
						<?php
							if(isset($data['UsersSalarysSocialInsurance'][0]['salary'])) {
								echo number_format($data['UsersSalarysSocialInsurance'][0]['salary']); 
							}
						?>
					</td>
				</tr>
				<tr>
					<td>BHXH <i>8%</i></td>
					<td>
						<?php
							if(isset($data['UsersSalarysSocialInsurance'][0]['salary'])) {
								$bhxh = $data['UsersSalarysSocialInsurance'][0]['salary'] * 8 /100;
								echo number_format($bhxh);
							}
						?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>BHYT <i>1.5%</i></td>
					<td>
						<?php
							if(isset($data['UsersSalarysSocialInsurance'][0]['salary'])) {
								$bhyt = $data['UsersSalarysSocialInsurance'][0]['salary'] * 15 /1000;
								echo number_format($bhyt);
							}
							// else {
							//	$bhyt = $data['Salary']['salary']* 15 /1000;
							//	echo number_format($bhyt);
							//}
						?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>BHTN <i>1%</i></td>
					<td>
						<?php
							if(isset($data['UsersSalarysSocialInsurance'][0]['salary'])) {
								$bhtn = $data['UsersSalarysSocialInsurance'][0]['salary'] /100;
								echo number_format($bhtn);
							}
						?>

					</td>
					<td></td>
				</tr>
				<tr>
					<td>Thuế TNCN</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Tạm ứng</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Còn nhận</td>
					<td>
						<strong>
							
						</strong>
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="clearfix"></div>
