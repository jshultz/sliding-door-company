<!DOCTYPE html>
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>Sliding Door Company: Consultation Request</title>


	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/foundation.css">

	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

	<script src="<?php echo base_url(); ?>assets/js/vendor/custom.modernizr.js"></script>

</head>
<body>

<div class="row">
	<div class="large-4 columns"><img src="<?php echo base_url(); ?>assets/images/site/sliding-door-company.png"
	                                  width="235" height="123" alt=""></div>
	<div class="large-6 columns">
		<h3 style="margin-top: 40px">Consultation Request Form</h3>
	</div>
	<div class="large-2 columns"></div>
</div>

<div class="row">

<div class="large-6 columns large-offset-3">
<form action="<?php echo base_url(); ?>site/email_store">
<input type="hidden" name="nolocation" value="<?php echo $nolocation; ?>">

<div class="row">
	<div class="small-12">
		<div class="row">
			<div class="small-3 columns">
				<label for="fullname" class="right inline">Name</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="fullname" name="fullname" placeholder="<?php echo $fullname; ?>"
				       value="<?php echo $fullname; ?>">
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
				<input type="text" id="zip" name="zip" placeholder="<?php echo $cust_zip; ?>"
				       value="<?php echo $cust_zip; ?>">
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
				<input type="text" id="telephone" name="phone" placeholder="<?php echo $phone; ?>"
				       value="<?php echo $phone; ?>">
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
				<input type="text" id="email" name="cust_email" placeholder="<?php echo $cust_email; ?>"
				       value="<?php echo $cust_email; ?>">
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
				<label for="right-label" class="datepicker right inline">Preferred Date</label>
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
						<p style="text-decoration: underline"><strong>Your Quote</strong></p>
					</div>
				</div>
				<div class="row">
					<div class="small-3 columns">
						<label for="style" class="right inline">Style:</label>
					</div>
					<div class="small-9 columns">
						<input type="text" name="style" id="style" placeholder='<?php echo $style; ?>'
						       value='<?php echo $style; ?>' disabled>
					</div>
				</div>
				<div class="row">
					<div class="small-3 columns">
						<label for="size" class="right inline">Size:</label>
					</div>
					<div class="small-9 columns">
						<input type="text" name="size" id="size" placeholder="<?php echo $size; ?>"
						       value="<?php echo $size; ?>" disabled>
					</div>
				</div>
				<div class="row">
					<div class="small-3 columns">
						<label for="panels" class="right inline">Number of Panels:</label>
					</div>
					<div class="small-9 columns">
						<input type="text" name="panels" id="panels" placeholder="<?php echo $panels; ?>"
						       value="<?php echo $panels; ?>" disabled>
					</div>
				</div>
				<div class="row">
					<div class="small-3 columns">
						<label for="price" class="right inline">Base Price<sup>*</sup>:</label>
					</div>
					<div class="small-9 columns">
						<input type="text" name="price" id="price" placeholder="<?php echo $price; ?>"
						       value="<?php echo $price; ?>" disabled>
					</div>
				</div>

				<?php
					if ($special == '1') {

						$dollar = $price;
						$dollar = str_replace("$", "", $dollar);
						$dollar = str_replace(",", "", $dollar);
						$dollar = str_replace(".", "", $dollar);

						if ($dollar <= 1000) {
							$discount_price = $dollar - ($dollar * .10);

						}

						if (($dollar > 1000) && ($dollar <= 2000)) {
							$discount_price = $dollar - ($dollar * .15);

						}

						if ($dollar > 2000) {
							$discount_price = $dollar - ($dollar * .20);

						} ?>

						<div class="row">
							<div class="small-3 columns">
								<label for="price" class="right inline">Discount Price<sup>*</sup>:</label>
							</div>
							<div class="small-9 columns">
								<?php
									setlocale(LC_MONETARY, 'en_US.UTF-8');
									$discount_price = money_format('%.2n', $discount_price);
								?>
								<input type="text" name="discountprice" id="discount_price"
								       placeholder="<?php echo $discount_price; ?>"
								       value="<?php
									       echo $discount_price;
								       ?>" disabled>
							</div>
						</div>

					<?php
					}


				?>

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

					<?php if (count($location_array) > 1) {

						echo '<h3>Your Closest Showrooms</h3>';
						echo '<p>Please choose the store most convenient for you.';
						foreach (array_slice($location_array, 0, 5) as $store) {
							?>

							<?php
							if ((isset($store['email']) && (strlen($store['email']) > 0))) {

								$email_address = $store['email'];
							}
							?>

							<p><input type="radio" name="store_email" value="<?php echo $email_address; ?>">
								<a style="color: #BFD730; text-decoration: none;" href="<?php
									if ((isset($store['map_link']) && (strlen($store['map_link']) > 0))) {

										echo $store['map_link'];
									}
								?>"><?php
										if ((isset($store['location']) && (strlen($store['location']) > 0))) {

											echo $store['location'];
										}
									?></a>

							</p>
							


							<p>
								<?php
									if ((isset($store['address']) && (strlen($store['address']) > 0))) {

										echo $store['address'];
									}
								?><br/>
								<?php
									if ((isset($store['city']) && (strlen($store['city']) > 0))) {

										echo $store['city'];
									}
								?>
								, <?php
									if ((isset($store['state']) && (strlen($store['state']) > 0))) {

										echo $store['state'];
									}
								?> <?php
									if ((isset($store['zip']) && (strlen($store['zip']) > 0))) {

										echo $store['zip'];
									}
								?><br/>
								t: <?php
									if ((isset($store['telephone']) && (strlen($store['telephone']) > 0))) {

										echo $store['telephone'];
									}
								?><br/>
                                Hours: <?php
                                if ((isset($store['hours']) && (strlen($store['hours']) > 0))) {

                                    echo $store['hours'];
                                }
                                ?><br/>
							</p>

						<?php
						}

					} else {
						?>
						<h3>Your Showroom</h3>
						<input type="hidden" name="store_email" value="<?php echo $store_email; ?>">

						<input type="hidden" name="location" value="<?php echo $location; ?>">


						<p>
							Our <a style="color: #BFD730; text-decoration: none;" href="<?php
								if ((isset($maplink) && (strlen($maplink) > 0))) {

									echo $maplink;
								}
							?>"><?php
									if ((isset($location) && (strlen($location) > 0))) {

										echo $location;
									}
								?></a> showroom is
							serving your area.

						</p>
						


						<p>
							<?php
								if ((isset($address) && (strlen($address) > 0))) {

									echo $address;
								}
							?><br/>
							<?php
								if ((isset($city) && (strlen($city) > 0))) {

									echo $city;
								}
							?>
							, <?php
								if ((isset($state) && (strlen($state) > 0))) {

									echo $state;
								}
							?> <?php
								if ((isset($zip) && (strlen($zip) > 0))) {

									echo $zip;
								}
							?><br/>
							t: <?php
								if ((isset($telephone) && (strlen($telephone) > 0))) {

									echo $telephone;
								}
							?><br/>
                            Hours: <?php
                            if ((isset($hours) && (strlen($hours) > 0))) {

                                echo $hours;
                            }
                            ?><br/>
						</p>

					<?php } ?>

				<?php } else { ?>

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
		<input src="<?php echo base_url(); ?>assets/images/email-one/consultation-button.png"
		       value="Request Consultation" type="image">
	</div>
</div>
</form>
</div>


</div>


<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script src="<?php echo base_url(); ?>assets/js/foundation.min.js"></script>

<script>
	$(function () {
		$("#datepicker").datepicker();
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