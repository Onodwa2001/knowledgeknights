<!-- Delete Modal HTML -->
<div class="modal fade" id="deleteModal_<?php echo $row['username']; ?>" >
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="" method="post" enctype="multipart/form-data">
					<div class="modal-header">
						<h4 class="modal-title">Delete </h4>
						<input type="hidden" name="username" class="form-control" value="<?= $row["username"]; ?>"> 
						<button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete this Records?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
						
                        <button type="submit" name="delete" class="btn btn-danger" value="Delete">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>
    