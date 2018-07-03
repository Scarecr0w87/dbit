<?php
	# Active constant
	define("ACTIVE",true);

	# Modal variables
	$modal  = '';
	$modalTitle  = '';
	$modalMessage  = '';
	
	
	# reCAPTCHA Check
	function reCAPTCHA(){
		$secret = "6LeTkA8TAAAAAJjB-lme8rTarzB-7cWidqUtC9XZ";
		$captcha = $_POST["g-recaptcha-response"];
		$ip = $_SERVER["REMOTE_ADDR"];
		
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array("secret" => $secret, "response" => $captcha, "remoteip" => $ip);
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$server_output = curl_exec($ch);

		curl_close ($ch);
		
		return json_decode($server_output, true);
	}
	
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Send"])){
		# Check for reCAPTCHA
		if(isset($_POST["g-recaptcha-response"]) && !empty($_POST["g-recaptcha-response"])){
			# Check reCAPTCHA response
			$arr = reCAPTCHA();

			# Check reCAPTCHA response
			if($arr['success']){
				$errors  = '';
				$dbitemail = 'DBIT Systems ltd <info@dbitsystemsltd.co.uk>';
				
				# Test the submitted data
				function test_input($data) {
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					filter_var($data,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
					return $data;
				}
				
				# Check for blank inputs
				if (empty($_POST['FullName']) || empty($_POST['Email']) || empty($_POST['Subject']) || empty($_POST['Message'])) {
					$errors .= "Please complete all the fields in order to contact us.";
				}

				# Test all the submitted data with the test_input function
				$fullname      = test_input($_POST['FullName']);
				$email_address = test_input($_POST['Email']);
				$subject       = test_input($_POST['Subject']);
				$message       = test_input($_POST['Message']);
				
				# Check email address format
				if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
					$errors = "Invalid email format"; 
				}
				
				if (empty($errors)) {
					$to            = $dbitemail;
					$email_subject = "[WebTicket] From: $fullname RE: $subject";
					$email_body    = "You have received a new message. Here are all the details:\n Full Name: $fullname \n Email: $email_address \n Subject: $subject \n Message: \n $message";
					
					$headers = "From: $dbitemail" . "\r\n";
					$headers .= "Reply-To: $email_address";
					
					# Send message
					if(mail($to, $email_subject, $email_body, $headers)){
						# Set successful modal details
						$modal = "<script> $('#ModalMessage').modal('show'); </script>";
						$modalTitle = "Message sent!";
						$modalMessage = "We'll aim to get back to you within a couple days or so.  Thanks for getting in touch with us!";
					}
					else{
						# Set unsuccessful modal details
						$modal = "<script> $('#ModalMessage').modal('show'); </script>";
						$modalTitle = "Unable to send message";
						$modalMessage = "Unfortunately the message couldn't be sent. Please contact us directly via info@dbitsystemsltd.co.uk. Thanks.";
					}
					
				}
				else {
					# Set modal details
					$modal = "<script> $('#ModalMessage').modal('show'); </script>";
					$modalTitle = "Error";
					$modalMessage = $errors;
				}
			}
			else{
				$modal = "<script> $('#ModalMessage').modal('show'); </script>";
				$modalTitle = "reCAPTCHA failed";
				$modalMessage = "Unable to send message as the reCAPTCHA failed validation.";
			}
		}
		else {
			$modal = "<script> $('#ModalMessage').modal('show'); </script>";
			$modalTitle = "reCAPTCHA failed";
			$modalMessage = "Unable to send message as the reCAPTCHA failed validation.";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include "head.php";?>
	<meta name="description" content="DBIT Systems ltd is devoted to making user friendly intuitive database driven web applications for home and business use."> 
    <meta name="author" content="DBIT Systems Ltd.">
	<meta name="keywords" content="dbit, database, home, business, systems, budget, savings">
    <title>DBIT Systems</title>
</head>

<body style="transform:rotate(0deg)">

	<?php include "navbar.php";?>

    <!-- Header -->
    <div class="jumbotron">
    	<img id="header-logo" src="img/dbit.png" class="img-responsive center-block"></img>
    </div>

	<!-- Content -->
	<div class="container">
		<div class="row">
		
			<!--/ desktop - left -->
			<div class="col-md-8">
				
				<!--/ Introduction Panel -->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">DBIT > Home ...</h3>
					</div>
					<div class="panel-body">
						<p>Greetings! Thanks for taking the time to come and have a look at us! Here at DBIT Systems, we want nothing more than to serve our customers with what we do best!</p>
						<p>Our primary goal is to provide the systems your business or company needs in order to transform those pesky, manually run processes into an automated experience, giving your staff more time to focus on what's important.</p>
					</div>
				</div>
				
				<!--/ What We Do Panel -->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">What do we do exactly?</h3>
					</div>
					<div class="panel-body">
						<li><strong>We create simple and intuitive web based database driven applications.</strong></li>
						<p>No one knows your business like you do, and listening to each of our clients has lead us to creating not only fast and powerful software, but familiar interfaces which feel natural to use.</p>
						<li><strong>DBIT systems has roots in one to one client relations.</strong></li>
						<p>You talk, we listen, you show us an idea, we will build it. This relationship with our clients has given us unique insight into how the user wants the software to work. So instead of a one size fits all package that your expected to get on and use, you have a bespoke system with the ability to evolve to your requirements.</p>
						<li><strong>The application is for you.</strong></li>
						<p>The foundations of our Company are based in our relationships we have formed with our clients. We focus on making each package bespoke depending on the specific needs of each individual business we work with.</p>
					</div>
				</div>
			</div>

			<!--/ desktop - right -->
			<div class="col-md-4">
			
				<!--/ Contact Panel -->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Get in touch:</h3>
					</div>
					<div class="panel-body">
						<!--/ Contact Form -->
						<form id="contactForm" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"				
							data-fv-framework="bootstrap"
							data-fv-icon-valid="fa fa-check"
							data-fv-icon-invalid="fa fa-times"
							data-fv-icon-validating="fa fa-refresh fa-spin"
							data-fv-addons="reCaptcha2"
							data-fv-addons-recaptcha2-element="RecaptchaField1"
							data-fv-addons-recaptcha2-language="en"
							data-fv-addons-recaptcha2-theme="light"
							data-fv-addons-recaptcha2-sitekey="6LeTkA8TAAAAACZMArcBrjzEat1mBhdaonHqZVJz"
							data-fv-addons-recaptcha2-timeout="120"
							data-fv-addons-recaptcha2-message="The captcha is not valid">
							<div class="form-group">
								<label for="FullName" class="col-sm-4 control-label">Full Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="FullName" placeholder="Full Name"
									data-fv-notempty="true"
									data-fv-notempty-message="The full name is required">
								</div>
							</div>
							<div class="form-group">
								<label for="Email" class="col-sm-4 control-label">Email</label>
								<div class="col-sm-8">
									<input type="email" class="form-control" name="Email" placeholder="Email"
									data-fv-emailaddress="true"
									data-fv-emailaddress-message="The value is not a valid email address">
								</div>
							</div>
							<div class="form-group">
								<label for="Subject" class="col-sm-4 control-label">Subject</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="Subject" placeholder="Subject"
									data-fv-notempty="true"
									data-fv-notempty-message="The subject is required">
								</div>
							</div>
							<div class="form-group">
								<label for="Message" class="col-sm-4 control-label">Message</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="Message" placeholder="Message" rows="3"
									data-fv-notempty="true"
									data-fv-notempty-message="Please enter a message"></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="GoogleRecaptcha" id="RecaptchaField1"></div>
								</div>
							</div>
							<div class="col-sm-8 col-sm-offset-4">
								<button type="submit" name="Send" class="btn btn-block btn-default">Send</button>
							</div>
						</form>
						
						<script>
							$(document).ready(function() {
								$('#contactForm').formValidation();
							});
						</script>
						
						<!-- small modal thanks box -->
						<div class="modal fade bs-example-modal-sm" id="ModalMessage" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
									<h4 class="modal-title" id="mySmallModalLabel"><?php echo $modalTitle; ?></h4>
								</div>
								<div class="modal-body">
									<p><?php echo $modalMessage; ?></p>
								</div>
							</div>
						  </div>
						</div>
					</div>
				</div>
				
				<!--/ Company Panel -->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Company:</h3>
					</div>
					<div class="panel-body">
						<address>
							<strong>Registered Address (Residential)</strong><br>
							DBIT Systems Ltd<br>
							127 Brempsons<br>
							Basildon, Essex<br>
							SS14 2BB<br>
						</address>
						<p>DBIT Systems Ltd is a company registered in England and Wales with company number: 09003361</p>
						<p><strong>We are not hiring at this time!</strong></p>
					</div>
				</div>
				
			</div>

		</div>

	</div>

    <?php include 'footer.php';?>

	<?php echo $modal;?>
	
	<script src="foxtrotUniformNovember.js"></script>
  </body>
</html>
