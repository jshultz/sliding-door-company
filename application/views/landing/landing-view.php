<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>Sliding Door Company: Consultation Request</title>


	<link rel="stylesheet" href="/assets/css/foundation.css">

	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

	<script src="/assets/js/vendor/custom.modernizr.js"></script>

</head>
<body>

<div class="row">
	<div class="large-6 column large-offset-3 text-center">
		<h3>Consultation Request Form</h3>
	</div>
</div>

<div class="row">

	<div class="large-6 columns large-offset-3">
		<form action="/site/email_store">
			<input type="hidden" name="store_email" value="<?php echo $store_email; ?>">

			<input type="hidden" name="location" value="<?php echo $location; ?>">

			<input type="hidden" name="nolocation" value="<?php echo $nolocation; ?>">

				<div class="row">
					<div class="small-12">
						<div class="row">
							<div class="small-3 columns">
								<label for="fullname" class="right inline">Name</label>
							</div>
							<div class="small-9 columns">
								<input type="text" id="fullname" name="fullname" placeholder="<?php echo $fullname; ?>" value="<?php echo $fullname; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="small-12">
						<div class="row">
							<div class="small-3 columns">
								<label for="zip" class="right inline">Zip</label>
							</div>
							<div class="small-9 columns">
								<input type="text" id="zip" name="zip" placeholder="<?php echo $cust_zip; ?>" value="<?php echo $cust_zip; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="small-12">
						<div class="row">
							<div class="small-3 columns">
								<label for="telephone" class="right inline">Phone</label>
							</div>
							<div class="small-9 columns">
								<input type="text" id="telephone" name="phone" placeholder="<?php echo $phone; ?>" value="<?php echo $phone; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="small-12">
						<div class="row">
							<div class="small-3 columns">
								<label for="email" class="right inline">Email Address</label>
							</div>
							<div class="small-9 columns">
								<input type="text" id="email" name="cust_email" placeholder="<?php echo $cust_email; ?>" value="<?php echo $cust_email; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="small-12">
						<div class="row">
							<div class="small-3 columns">
								<label for="comments" class="right inline">Comments</label>
							</div>
							<div class="small-9 columns">
								<textarea id="comments" name="comments" placeholder="Enter any comments"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="small-12">
						<div class="row">
							<div class="small-3 columns">
								<label for="right-label" class="datepicker">Preferred Date</label>
							</div>
							<div class="small-9 columns">
								<input type="text" name="date" id="datepicker" placeholder="Please pick a date" value="">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="small-12">
						<div class="row">
							<div class="small-3 columns">
								<label for="time" class="right inline">Time</label>
							</div>
							<div class="small-9 columns">
								<input type="text" name="time" id="time" placeholder="Enter a time" value="">
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="small-12">
						<div class="row">
							<div class="small-2 columns">

							</div>
							<div class="small-10 columns">
								<div class="row">
									<div class="small-12 columns">
										<p style="text-decoration: underline"><strong>Your Design</strong></p>
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
										<label for="style" class="right inline">Style:</label>
									</div>
									<div class="small-9 columns">
										<input type="text" name="style" id="style" placeholder="<?php echo $style; ?>" value="<?php echo $style; ?>" disabled>
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
										<label for="size" class="right inline">Size:</label>
									</div>
									<div class="small-9 columns">
										<input type="text" name="size" id="size" placeholder="<?php echo $size; ?>" value="<?php echo $size; ?>" disabled>
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
										<label for="panels" class="right inline">Number of Panels:</label>
									</div>
									<div class="small-9 columns">
										<input type="text" name="panels" id="panels" placeholder="<?php echo $panels; ?>" value="<?php echo $panels; ?>" disabled>
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
										<label for="price" class="right inline">Base Price<sup>*</sup>:</label>
									</div>
									<div class="small-9 columns">
										<input type="text" name="price" id="price" placeholder="<?php echo $price; ?>" value="<?php echo $price; ?>" disabled>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

			<div class="row">
				<div class="small-12 columns">
					<hr/>
				</div>
			</div>


			<div class="row">
				<div class="small-9 columns">
					<div class="row">
						<div class="small-12 columns">
							<?php if ($nolocation == '0') { ?>

							<p><strong><?php echo $location; ?></strong><br/>
							<?php echo $address; ?><br/>
							<?php echo $city; ?>, <?php echo $state; ?> <?php echo $zip; ?><br/>
							<?php echo $telephone; ?></p>
							<?php } else {?>

								<p>Your qualify for a telephone
									consultation with our of our
									experts! Simply schedule
									a time and date that works
									best for you.</p>

							<?php } ?>
						</div>
					</div>


				</div>
				<div class="small-3 columns">
					<input class="button" value="Request Consultation" type="submit">
				</div>
			</div>
		</form>
	</div>


</div>



<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script src="/assets/js/foundation.min.js"></script>

<script>
	$(function() {
		$( "#datepicker" ).datepicker();
	});
</script>
<!--

  <script src="js/foundation/foundation.js"></script>

  <script src="js/foundation/foundation.alerts.js"></script>

  <script src="js/foundation/foundation.clearing.js"></script>

  <script src="js/foundation/foundation.cookie.js"></script>

  <script src="js/foundation/foundation.dropdown.js"></script>

  <script src="js/foundation/foundation.forms.js"></script>

  <script src="js/foundation/foundation.joyride.js"></script>

  <script src="js/foundation/foundation.magellan.js"></script>

  <script src="js/foundation/foundation.orbit.js"></script>

  <script src="js/foundation/foundation.reveal.js"></script>

  <script src="js/foundation/foundation.section.js"></script>

  <script src="js/foundation/foundation.tooltips.js"></script>

  <script src="js/foundation/foundation.topbar.js"></script>

  <script src="js/foundation/foundation.interchange.js"></script>

  <script src="js/foundation/foundation.placeholder.js"></script>

  <script src="js/foundation/foundation.abide.js"></script>

  -->

<script>
	$(document).foundation();
</script>
</body>
</html>