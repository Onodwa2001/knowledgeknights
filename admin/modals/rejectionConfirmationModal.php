<!-- Reject Modal HTML -->
<div id="rejectModal_<?php echo $row['username']; ?>" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="includes/tutorRejectionEmail.php" method="post" enctype="multipart/form-data">
					<div class="modal-header">
						<h4 class="modal-title">Reject </h4>
						<input type="hidden" name="username" class="form-control" value="<?= $row["username"] ?>">
                        <input type="hidden" name="email" class="form-control" value="<?= $row["email"] ?>">
						<button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to reject the tutor application</p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
						
                        <button type="submit" name="rejectApplication" class="btn btn-danger" value="Reject">Reject</button>
					</div>
				</form>
			</div>
		</div>
	</div>
    