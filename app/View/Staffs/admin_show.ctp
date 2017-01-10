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
					<td></td>
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
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>Thông tin ngày công</strong></td>
					<td><?= $day ?></td>
					<td></td>
				</tr>
				<tr>
					<td>Công định mức</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Ngày công thực tế </td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Ngày phép</td>
					<td></td>
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
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Lương thêm giờ</td>
					<td></td>
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
					<td>- BHXH <i>8%</i></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>BHYT <i>1.5%</i></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>BHTN <i>1%</i></td>
					<td></td>
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
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="clearfix"></div>
