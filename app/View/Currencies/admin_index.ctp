<?php
	$this->start('extra-lib');
?>
	<script type="text/javascript">
		
		$(document).ready(function() {

			//ajax post submit create
			$('#create-form').validate({
				rules: {
		            name: {
		                required: true
		            },
		            symbol: {
		                required: true
		            }
		       	},
			  	submitHandler: function(form) {
			    	var name = $('#create-name').val();
			    	var symbol = $('#create-symbol').val();
					$.ajax({
						url: ADMIN+'/currencies/create',
						type: 'POST',
						data: {name : name , symbol: symbol},
					})
					.done(function(output) {
						console.log(output);
						if(output.status == 200) {
							$('#modal-create').modal('hide');
							alert(output.data.message);
							location.reload();
						} else {
							alert('Create Currency false!');
						}
					});
			  	}
			});
		
			// ajax get edit 
			$('.edit').on('click', function(e) {

				e.preventDefault();
				var id = $(this).data('id');

				$.ajax({
					url: ADMIN+'/currencies/getById',
					type: 'GET',
					data: {id: id},
				})
				.done(function(output) {
					$('#edit-name').val(output.data.name);
					$('#edit-symbol').val(output.data.symbol);
					$('#id').val(output.data.id);
					$('#modal-edit').modal('show');
				});
			});
			
			//ajax post submit edit
			$('#edit-form').validate({
				rules: {
		            name: {
		                required: true,
		            },
		            symbol: {
		                required: true
		            }
		       	},
			  	submitHandler: function(form) {
			    	var id = $('#id').val();
					var name = $('#edit-name').val();
					var symbol = $('#edit-symbol').val();
					$.ajax({
						url: ADMIN+'/currencies/edit',
						type: 'POST',
						data: {id : id, name : name, symbol :symbol},
					})
					.done(function(output) {
						if(output.status == 200) {
							$('#tr'+id+' .name').text(name);
							$('#tr'+id+' .symbol').text(symbol);
							$('#modal-edit').modal('hide');
							alert(output.data.message);
						} else {
							alert('Edit false!');
						}
					});
			  	}
			});

			// ajax remove item
			$('.remove').on('click', function(e) {

				e.preventDefault();
				var r = confirm('Are you sure ?');
				if(r == true) {
					var id = $(this).data('id');
					$.ajax({
						url: ADMIN+'/currencies/remove',
						type: 'GET',
						data: {id: id},
					})
					.done(function(output) {
						console.log(output);
						if(output.status == 200) {
							$('#tr'+id).remove();
							alert(output.data.message);
						} else {
							alert('Remove false!');
						}
					});
				}
			});
		});

	</script>


	<!-- modal edit -->
	<div class="modal fade" id="modal-edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit Currency</h4>
				</div>
				<form id="edit-form">
					<div class="modal-body">
						<div class="from-group">
							<label>Name</label>
							<input class="form-control" type="hidden" name="id" id="id" ></input>
							<input class="form-control" name="name" id="edit-name"></input>
						</div>
						<div class="from-group">
							<label>Symbol</label>
							<input class="form-control" name="symbol" id="edit-symbol"></input>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" id="submit-edit">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal create -->
	<div class="modal fade" id="modal-create">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit Currency</h4>
				</div>
				<form id="create-form">
					<div class="modal-body">
						<div class="from-group">
							<label>Name</label>
							<input class="form-control" name="name" id="create-name"></input>
						</div>
						<div class="from-group">
							<label>Symbol</label>
							<input class="form-control" name="symbol" id="create-symbol"></input>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" id="submit-create">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
	$this->end();
?>

<?php $this->Paginator->options(array(
    'url'=> array('controller' => 'currencies',
    'action' => 'index',
    'admin' => true
))); ?>

<div class="col-xs-12 bg">
	<div style="margin-bottom: 20px;">
		<a class="btn btn-success pull-right" data-toggle="modal" href='#modal-create'>Create new Postion</a>
		<div class="clearfix"></div>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Symbol</th>
				<th>Created</th>
				<th>Operation</th>
			</tr>
		</thead>
		<tbody>
		    <?php foreach($data as $item) { ?>
	            <tr id="tr<?php echo $item['Currency']['id']; ?>">
	                <td><?php echo $item['Currency']['id']; ?></td>
	                <td class="name"><?php echo $item['Currency']['name']; ?></td>
	                <td class="symbol"><?php echo $item['Currency']['symbol']; ?></td>
	                <td><?= date('d-m-Y', strtotime($item['Currency']['created'])); ?></td>
	                <td> <a href="#" class="edit" data-id="<?php echo $item['Currency']['id']; ?>"><i class="fa fa-edit"> </i> Edit</a> - <a href="#" class="remove" data-id="<?php echo $item['Currency']['id']; ?>"><i class="fa fa-remove"> </i> Remove</a></td>
	            </tr>
			<?php } ?>
		</tbody>
	</table>
    <?php if($this->params['paging']['Currency']['pageCount'] > 1) { ?>
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
