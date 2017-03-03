<?php 
	if(isset($_SESSION['message']) && $_SESSION['message'] != ''){
		
		
?>
	<div class="col-md-10  col-md-offset-1 alert alert-<?php echo $_SESSION['messageStyle'];?> alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <?php echo $_SESSION['message']; ?>
	</div>
<?php 
		$_SESSION['message'] 		= '';
		$_SESSION['messageStyle'] 	= '';
	} 
?>

<div class="row">
	<div class="col-md-12">
		<h2>Change my Password</h2>
	</div>
</div>

<hr />

<form action="update_password.php" id="changePassword" method="post">

	<div class="row">
		
		<div class="col-sm-offset-3 col-sm-6">
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Change Password</h3>
				</div>
				<div class="panel-body">
					
					<div class="row">	
						<div class="col-sm-12">
							<div class="form-group">
								<label for="currentPassword">Current Password</label>
								<input type="password" id="currentPassword" class="form-control" name="currentPassword" value="" placeholder="Enter your current password" />
							</div>
						</div>
						
					</div>
		
					<div class="row">	
						
						<div class="col-sm-12">
							<div class="form-group">
								<label for="newPassword">New Password</label>
								<input type="password" id="newPassword" class="form-control" name="newPassword" value="" placeholder="Enter your new password" />
							</div>
						</div>

					</div>
		
		
				
					<div class="row">	
						
						<div class="col-sm-12">
							<div class="form-group">
								<label for="confirmNewPassword">Confirm New Password</label>
								<input type="password" id="confirmNewPassword" class="form-control" name="confirmNewPassword" value="" placeholder="Enter your new password again" />
							</div>
						</div>

					</div>
					
									
									
				</div>
			</div>	
		</div>




	</div>
	

	
	
	<hr />

	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<button type="submit" class="btn btn-default btn-block" name="submit" value="update">Update Password</button>
		</div>
	</div>
	
</form>