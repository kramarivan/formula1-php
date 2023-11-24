<?php 
	print '
	<h1>Contact Form</h1>
	<div id="contact">
	<iframe src="http://maps.google.com/maps?q=45.772366, 15.944950&z=16&output=embed" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
		<form action="send-contact.php" id="contact_form" name="contact_form" method="POST">
			<label for="fname">First Name *</label>
			<input type="text" id="fname" name="firstname" placeholder="Name.." required>
			
			<label for="lname">Last Name *</label>
			<input type="text" id="lname" name="lastname" placeholder="Last name.." required>
				
			<label for="email"> E-mail *</label>
			<input type="email" id="email" name="email" placeholder="E-mail.." required>

			<label for="country">Country</label>
			<select id="country" name="country">
				<option value="">Please select</option>
				<option value="SI">Slovenia</option>
				<option value="HR" selected>Croatia</option>
				<option value="SR">Serbia</option>
				<option value="BH">Bosnia & Herzegovina</option>
			</select>

			<label for="subject">Subject</label>
			<textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>

			<input type="submit" value="Submit">
		</form>
	</div>';
?>