<div class="page-header">
  <h1>Get in Touch<small></small></h1>
</div>




<div class="row">
	
	<div class="col-xs-12 col-sm-6 center-block">
		<img src="images/contact_image.png" class="img-thumbnail img-responsive center-block" alt="front_image_1" />
	</div>
	
	<div class="col-xs-12 col-sm-6 ">
		
		<div class="row">
			
			<form role="form" data-toggle="validator" action="contact_us.phps" method="post">
				
				<div class="form-group">
					<label for="inputName" class="control-label">Name</label>
					<input type="text" class="form-control" id="inputName" placeholder="Enter your Name" required>
				</div>
					
				<div class="form-group">
					<label for="inputEmail" class="control-label">Email Address</label>
					<input type="email" class="form-control" id="inputEmail" placeholder="Enter your email address" data-error="" required>
					<div class="help-block with-errors"></div>
				</div>

				<div class="form-group">
					<label for="inputSubject" class="control-label">Subject</label>
					<input type="text" class="form-control" id="inputSubject" placeholder="Enter the Subject" required>
				</div>

				<div class="form-group">
					<label for="inputMessage" class="control-label">Message</label>
					<textarea class="form-control" id="inputMessage" placeholder="Enter your message"required></textarea>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary col-xs-offset-1 col-xs-10">Submit</button>
				</div>

			</form>
			
		</div>
		
	</div>
	
</div>
