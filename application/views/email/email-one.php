<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<body bgcolor="#f6f6f6" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- Save for Web Slices (DYO_email-v3-1) -->
<style>
	a {color: #BFD730; text-decoration: none; padding: 0}
	a, img {
		margin: 0;
		padding: 0;
	}
	img {outline: none; text-decoration: none; border: 0;}
	h3 {font-weight: 400;}
	body {background-color: #f6f6f6;}
</style>
<table id="Table_01" width="704" border="0" cellpadding="0" cellspacing="0" style="margin: 40px auto; color: #939598; background-color: #ffffff; border: 1px solid gray; font-size: 15px; line-height: 18px; font-family: verdana, arial, san-serif">

	<tr style="background-color: #F0F0F0; height: 35px;">
		<td colspan="2">
			<table width="100%">
				<td style="vertical-align: middle; text-align: center; width: 65px"><a style="text-transform: uppercase; text-decoration: none; display: block; margin: 0 auto; color: #939598; font-size: 8px; border-right: 1px solid gray;" href="http://www.slidingdoorco.com/showrooms">Showrooms</a></td>
				<td style="vertical-align: middle; text-align: center; width: 65px"><a style="text-transform: uppercase; text-decoration: none; margin: 0 auto; color: #939598; font-size: 8px" href="http://www.slidingdoorco.com/help/contact">Contact Us</a></td>
				<td style="width: 280px"></td>
				<td style="width: 20px; text-align: center"><a style="margin: 0 auto;" href="https://www.facebook.com/TheSlidingDoorCo"><img
							border="0" src="<?php echo base_url(); ?>assets/images/email-one/facebook.png" height="14px;"  alt=""></a></td>
				<td style="width: 20px; text-align: center"><a style="margin: 0 auto;" href="http://twitter.com/#!/slidingdoorco"><img src="<?php echo base_url(); ?>/assets/images/email-one/twitter.png" height="14px"
				                                                                                                                       alt=""></a></td>
				<td style="width: 20px; text-align: center"><a style="margin: 0 auto;" href="http://www.youtube.com/slidingdoorcompany/"><img
						<img src="<?php echo base_url(); ?>assets/images/email-one/youtube.png" height="14px"  alt=""></a></td>
				<td style="width:20px;"></td>
			</table>
		</td>

	</tr>
	<tr>
		<td colspan="1">
			<img src="<?php echo base_url(); ?>assets/images/email-one/DYO_email-v3-1_10.jpg" width="243" height="123" alt="">
		</td>
		<td colspan="1" style="text-align: right; vertical-align: middle;">


		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div style="width: 510px; margin: 0 20px; ">
				<?php
					if ((isset($firstname) && (strlen($firstname) > 0))) {

						echo '<p>' . $firstname . '</p>';
					}
				?>



				<?php
					if ((isset($message) && (strlen($message) > 0))) {

						echo $message;
					}
				?>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="1" style="vertical-align: top;">
			<div style="width:240px; padding: 0 20px; float: left">

				<h3 style="text-decoration: underline">Your Quote</h3>

				<p>
					<strong>Style: </strong> <?php
						if ((isset($style) && (strlen($style) > 0))) {

							echo $style;
						}
					?><br/>
					<strong>Size: </strong><?php
						if ((isset($size) && (strlen($size) > 0))) {

							echo $size;
						}
					?><br/>
					<strong>Number of Panels: </strong> <?php
						if ((isset($panels) && (strlen($panels) > 0))) {

							echo $panels;
						}
					?><br/>
					<strong>Base Price*: </strong> <?php
						if ((isset($price) && (strlen($price) > 0))) {

							echo $price;
						}
					?><br/>


				</p>
				<?php

					echo '<p>
									Get started by sharing your
									custom specs with
									your local showroom for detailed
									pricing and options.
								</p>';

				?>
                <?php echo '<a href="'  . base_url() . 'site/consultation?email=' . $cust_email . '&key=' . $key . '">' ?><img src="<?php echo base_url(); ?>assets/images/email-one/free-consultation.png"></a>

			</div>
		</td>
		<td colspan="1" style="vertical-align: top;">
			<div style="width:240px; padding: 1px 20px;">



				<?php if ($nolocation != '1') { ?>



					<?php if (count($location_array) > 1) {



						echo '<h3>Contact Your Showroom</h3>';

						foreach (array_slice($location_array, 0, 5) as $store) {?>

							<?php
							if ((isset($store['email']) && (strlen($store['email']) > 0))) {

								$email_address = $store['email'];
							}
							?>

							<p>
								Our <a style="color: #BFD730; text-decoration: none;" href="<?php
									if ((isset($store['map_link']) && (strlen($store['map_link']) > 0))) {

										echo $store['map_link'];
									}
								?>"><?php
										if ((isset($store['location']) && (strlen($store['location']) > 0))) {

											echo $store['location'];
										}
									?></a> showroom is
								serving your area.

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

						<?php }

					} else { ?>
						<h3>Your Showroom</h3>
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

					<?php }?>


				 <?php } ?>

			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center; vertical-align: middle; height: 100px">

		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding: 20px 0;">
			<div style="padding: 0 20px; font-size: 12px; ">
				<p>
					For additional information regarding details, options and special pricing to the trade, please
					contact
					<?php
						if ((isset($email) && (strlen($email) > 0))) {

							echo ' <a href="mailto:' . $email . '">' . $email . '</a>';
						}
					?>

				</p>

			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding: 20px 0; background-color: #F0F0F0;">
			<div style="padding: 0 20px; font-size: 10px">
				<?php
					if ((isset($cust_email) && (strlen($cust_email) > 0))) {

						echo '<p><a style="color: #939598; text-decoration: none;" href="http://slidingdoorco.us5.list-manage1.com/subscribe/post?u=8f352881da294a071db8b8ed5&id=2d9fbec01c&MERGE0=' . $cust_email . '&MERGE1=' . $firstname . '&MERGE2=' . $lastname . '">SIGN UP FOR THE LATEST EVENTS AND OFFERS</a>
				| <a style="color:939598" href="'  . base_url() . 'site/unsubscribe?email=' . $cust_email . '&key=' . $key . '">Unsubscribe</a>
				</p>';
					}
				?>


				<p>
					The Sliding Door Company | 20235 Bahama St. | Chatsworth, CA 91311 | <a style="text-decoration: none; color:#939598" href="http://slidingdoorco.com">slidingdoorco.com</a>
				</p>
			</div>
		</td>
	</tr>

</table>
<!-- End Save for Web Slices -->
</body>
</html>