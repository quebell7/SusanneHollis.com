<div class="row">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Search Students</h3>
			</div>
			<div class="panel-body">
				
				
				<form class="form-horizontal" action="results_student.php" method="post">
			
					<div class="form-group">
						<label for="studentID" class="col-md-4 control-label">Student ID</label>
						<div class="col-md-8">
							<input type="text" id="studentID" class="form-control" name="studentID" value="" />
						</div>
					</div>
					
					<div class="form-group">
						<label for="FirstName" class="col-md-4 control-label">First Name</label>
						<div class="col-md-8">
							<input type="text" id="FirstName" class="form-control" name="FirstName" value="" />
						</div>
					</div>
					
					<div class="form-group">
						<label for="LastName" class="col-md-4 control-label">Last Name</label>
						<div class="col-md-8">
							<input type="text" id="LastName" class="form-control" name="LastName" value="" />
						</div>
					</div>
					
					
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button type="submit" class="btn btn-default btn-block" value="search"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search</button>
						</div>
					</div>
					
				</form>
					
			</div>
		</div>
	</div>
</div>