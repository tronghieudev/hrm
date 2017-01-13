<?php
	$this->start('extra-lib');
?>
	<script type="text/javascript">
		$(document).ready(function() {
			
			$('.ok').on('click', function(e) {

				e.preventDefault();
				var id = $(this).data('id');
				$.ajax({
					url: ADMIN+'/dayoffs/check',
					type: 'POST',
					data: {id: id},
				})
				.done(function(output) {
					console.log(output);
					if(output.status == 200) {
						alert('Thành công');
						$('#tr'+id).remove();
					} else {
						alert('Không thành công');
					}
				});
			});
		});
	</script>
<?php
	$this->end();
?>



<div class="col-xs-12 bg">
	<div style="margin-bottom: 20px;">
		<a class="btn btn-success pull-right" data-toggle="modal" href='#modal-create'>Create new Postion</a>
		<div class="clearfix"></div>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Họ tên</th>
				<th>Ngày nghỉ</th>
				<th>Số ngày</th>
				<th>#</th>
			</tr>
		</thead>
		<tbody>
		    <?php foreach($data as $item) { ?>
	            <tr id="tr<?php echo $item['UsersDaysOff']['id']; ?>">
	            	<td></td>
	                <td><?= $item['User']['email']; ?></td>
	                <td>
	                	<?= date('d-m-Y', strtotime($item['UsersDaysOff']['day_start'])); ?>
	                </td>
	                <td>
	                	<?= $item['UsersDaysOff']['days']	; ?>
	                </td>
	                <td>
	                	<span class="glyphicon glyphicon-ok ok" data-id="<?php echo $item['UsersDaysOff']['id']; ?>" style="color: green; cursor: pointer;"></span>
	                </td>
	            </tr>
			<?php } ?>
		</tbody>
	</table>
    <?php if($this->params['paging']['UsersDaysOff']['pageCount'] > 1) { ?>
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
