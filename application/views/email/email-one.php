<html>
<head>
	<title>DYO_email-v3-1</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
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
<table id="Table_01" width="704" border="0" cellpadding="0" cellspacing="0" style="color: #939598; background-color: #ffffff; font-size: 15px; line-height: 18px; font-family: verdana, arial, san-serif">
	<tr>
		<td colspan="11">
			<img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_01.jpg" width="704" height="59" alt=""></td>
	</tr>
	<tr>
		<td rowspan="8">
			<img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_02.jpg" width="65" height="997" alt=""></td>
		<td>
			<a href="http://www.slidingdoorco.com/showrooms"><img border="0" src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_03.jpg"
			                                                      width="96" height="45" alt=""></a></td>
		<td>
			<a href="http://www.slidingdoorco.com/help/contact"><img
					border="0" src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_04.jpg" width="81" height="45" alt=""></a>
		</td>
		<td colspan="4">
			<img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_05.jpg" width="274" height="45" alt=""></td>
		<td rowspan="2">
			<a href="https://www.facebook.com/TheSlidingDoorCo"><img
					border="0" src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_06.jpg" width="28" height="46" alt=""></a>
		</td>
		<td rowspan="2">
			<a href="http://twitter.com/#!/slidingdoorco"><img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_07.jpg"
			                                                   width="24" height="46" alt=""></a>
		</td>
		<td rowspan="2">
			<a href="http://www.youtube.com/slidingdoorcompany/"><img
					<img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_08.jpg" width="72" height="46" alt=""></a>
		</td>
		<td rowspan="8">
			<img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_09.jpg" width="64" height="997" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" rowspan="2">
			<img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_10.jpg" width="243" height="123" alt=""></td>
		<td colspan="2">
			<img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_11.jpg" width="208" height="1" alt=""></td>
	</tr>
	<tr>
		<td colspan="5">
			<img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_12.jpg" width="332" height="122" alt=""></td>
	</tr>
	<tr>
		<td colspan="9" style="background: url('/assets/images/email-one/DYO_email-v3-1_13.jpg')">
			<div style="">

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

				<div style="width:240px; padding: 0 20px; float: left">

					<h3>Your Design</h3>

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
						if ($special = TRUE) {
							echo '<p>
									Get started by sharing your
									custom specs and discount with
									your local showroom for detailed
									pricing and options.
								</p>';

						} else {
							echo '<p>
									Send these specs to your
									showroom for more pricing
									options.
								</p>';
						}
					?>

				</div>

				<div style="width:240px; padding: 0 20px; float: right">

					<h3>Your Showroom</h3>

					<p>
						Our <a href="<?php
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
					<a href="<?php
						if ((isset($maplink) && (strlen($maplink) > 0))) {

							echo $maplink;
						}
					?><img border="0" width="150px" src="http://sliding.osmprojects.com/assets/images/email-one/Google-Maps-Logo.png"></a>


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
						M-F: 9am-6pm
					</p>

				</div>


			</div>

		</td>
	</tr>
	<tr>
		<td colspan="3">
			<img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_14.jpg" width="185" height="54" alt=""></td>
		<td colspan="2">
			<a href=""><img
					border="0" src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_15.jpg" width="184" height="54" alt=""></a>
		</td>
		<td colspan="4">
			<img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_16.jpg" width="206" height="54" alt=""></td>
	</tr>
	<tr>
		<td colspan="9" style="background: url('/assets/images/email-one/DYO_email-v3-1_17.jpg')">
			<div style=" width: 530px; padding: 0 20px; font-size: 12px; ">
				<p>
					For additional information regarding details, options and special pricing to the trade, please
					contact
					<?php
						if ((isset($email) && (strlen($email) > 0))) {

							echo '<a href="' . $email . '">' . $email . '</a>';
						}
					?>

				</p>
				<?php if ($special = TRUE) {
					echo "<p style='font-size: 8px; line-height: 8px;'>
					*Save 10% when you spend up to $1000. Save 15% when you spend over $1000. Save 20% when you spend over $2000. Discount applies to products offered
					by The Sliding Door Company and may not be applied to installation or sales tax. Discount can not be combined with other offers or can not be applied to past
					purchases. Discount valid for email recipient only, and expires on";
					echo date('Y-m-d', strtotime("+30 days"));
					echo ". </p>";
				} ?>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="9" style="background: url('/assets/images/email-one/DYO_email-v3-1_18.jpg');">
			<div style=" width: 530px; padding: 0 20px; font-size: 10px">
				<?php
					if ((isset($cust_email) && (strlen($cust_email) > 0))) {

						echo '<p><a href="http://slidingdoorco.us5.list-manage1.com/subscribe/post?u=8f352881da294a071db8b8ed5&id=2d9fbec01c&MERGE0=' . $cust_email . '&MERGE1=' . $firstname . '&MERGE2=' . $lastname . '">SIGN UP FOR THE LATEST EVENTS AND OFFERS</a>
				| <a href="http://sliding.osmprojects.com/site/unsubscribe?email=' . $cust_email . '&key=' . $key . '">Unsubscribe</a>
				</p>';
					}
				?>


				<p>
					The Sliding Door Company | 20235 Bahama St. | Chatsworth, CA 91311 | <a href="http://slidingdoorco.com">slidingdoorco.com</a>
				</p>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="9">
			<img src="http://sliding.osmprojects.com/assets/images/email-one/DYO_email-v3-1_19.jpg" width="575" height="152" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="http://sliding.osmprojects.com/assets/images/email-one/spacer.gif" width="65" height="1" alt=""></td>
		<td>
			<img src="http://sliding.osmprojects.com/assets/images/email-one/spacer.gif" width="96" height="1" alt=""></td>
		<td>
			<img src="http://sliding.osmprojects.com/assets/images/email-one/spacer.gif" width="81" height="1" alt=""></td>
		<td>
			<img src="http://sliding.osmprojects.com/assets/images/email-one/spacer.gif" width="8" height="1" alt=""></td>
		<td>
			<img src="http://sliding.osmprojects.com/assets/images/email-one/spacer.gif" width="58" height="1" alt=""></td>
		<td>
			<img src="http://sliding.osmprojects.com/assets/images/email-one/spacer.gif" width="126" height="1" alt=""></td>
		<td>
			<img src="http://sliding.osmprojects.com/assets/images/email-one/spacer.gif" width="82" height="1" alt=""></td>
		<td>
			<img src="http://sliding.osmprojects.com/assets/images/email-one/spacer.gif" width="28" height="1" alt=""></td>
		<td>
			<img src="http://sliding.osmprojects.com/assets/images/email-one/spacer.gif" width="24" height="1" alt=""></td>
		<td>
			<img src="http://sliding.osmprojects.com/assets/images/email-one/spacer.gif" width="72" height="1" alt=""></td>
		<td>
			<img src="http://sliding.osmprojects.com/assets/images/email-one/spacer.gif" width="64" height="1" alt=""></td>
	</tr>
</table>
<!-- End Save for Web Slices -->
</body>
</html>