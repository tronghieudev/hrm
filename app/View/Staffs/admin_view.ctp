<?php 
	$this->start('extra-lib');
?>
	<script type="text/javascript">
		
	</script>
<?php
	$this->end();
?>

<div class="col-xs-12 bg">
	<?php
		if(!$data) {
			echo "No data";
		}else {
	?>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th width="30%">Field</th>
					<th>Detail</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><strong>Avata</strong></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>Fullname</strong></td>
					<td><?= $data['UsersProfile']['fullname']; ?></td>
				</tr>
				<tr>
					<td><strong>Email</strong></td>
					<td><?= $data['User']['email']; ?></td>
				</tr>
				<tr>
					<td><strong>Position</strong></td>
					<td><?= $data['User']['Position']['name']; ?></td>
				</tr>
				<tr>
					<td><strong>Department</strong></td>
					<td><?= $data['User']['Department']['name']; ?></td>
				</tr>
				<tr>
					<td><strong>Birthday</strong></td>
					<td><?= $data['UsersProfile']['birthday'];  ?></td>
				</tr>
				<tr>
					<td><strong>Salary</strong></td>
					<td><?= number_format($data['UsersProfile']['salary']).' '.$data['Currency']['symbol'];  ?></td>
				</tr>
				<tr>
					<td><strong>Gender</strong></td>
					<td><?= Constants::GENDER[$data['UsersProfile']['gender']]; ?></td>
				</tr>
				<tr>
					<td><strong>Day in company</strong></td>
					<td><?= $data['UsersProfile']['day_in_company']; ?></td>
				</tr>
				<tr>
					<td><strong>Address</strong></td>
					<td><?= $data['UsersProfile']['address']; ?></td>
				</tr>
				<tr>
					<td><strong>Phone number</strong></td>
					<td><?= $data['UsersProfile']['phone_number']; ?></td>
				</tr>
				<tr>
					<td><strong>ATM</strong></td>
					<td><?= $data['UsersProfile']['atm']; ?></td>
				</tr>
				<tr>
					<td><strong>CV</strong></td>
					<td><?= ($data['UsersProfile']['cv'] != null) ? $data['UsersProfile']['cv'] : 'No CV <a href="#">Update here</a>'; ?></td>
				</tr>
				<tr>
					<td><strong>Status</strong></td>
					<td>
						<?= ($data['User']['status'] == 1) ? '<strong style="color: green;">Doing</strong>' : '<strong style="color: red;">Has retired</strong>';?>
					</td>
				</tr>
			</tbody>
		</table>
	<?php
		}
	?>
</div>
<div class="clearfix"></div>
