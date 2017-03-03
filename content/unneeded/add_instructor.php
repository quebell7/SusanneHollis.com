
<div class="row">
	<div class="col-md-12">
		<h2>Instructor <span class="subheader">- Add</span></h2>
	</div>
</div>

<hr />


<form action="add_instructor.php" method="post">
	
	
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			
		<?php
			if($message == '1'){
		?>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12 alert alert-danger">
						Instructor not found
					</div>
				</div>
			</div>
		<?php
			}	
		?>
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Enter Instructor's ASA ID</h3>
				</div>
				<div class="panel-body">
					
					
					<div class="row">	
						<div class="col-sm-12">
							<div class="form-group">
								<label for="asaID">Instructor ID</label><br/>
								<input type="text" id="asaID" class="form-control" name="asaID" value="" />
							</div>
						</div>
						<div class="col-sm-4 col-sm-offset-4">
							<button type="submit" class="btn btn-default btn-block" value="Add Instructor">Add Instructor</button>
						</div>
					</div>
					
									
					
				</div>
			</div>
					
		</div>

	</div>

	<hr />
	
	

	<div class="row">
		
	</div>

</form>
