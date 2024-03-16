<?php

ob_start();
session_set_cookie_params(0);
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("admin/inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();

require 'assets/mail/PHPMailer.php';
require 'assets/mail/Exception.php';
require 'assets/mail/SMTP.php';
$mail = new PHPMailer\PHPMailer\PHPMailer();

$success_message = '';
$error_message = '';

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $logo = $row['logo'];
    $favicon = $row['favicon'];
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $website_name = $row['website_name'];
}


?>

<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<body>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Site Metas -->
		<title>H_F Clothing Brand</title>
		<meta name="keywords" content="">
		<meta name="description" content="">
		<meta name="author" content="">

		<link rel="shortcut icon"
			href="assets/images/<?php echo $favicon; ?>"
			type="image/x-icon">


		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<!-- Site CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
		<!-- Responsive CSS -->
		<link rel="stylesheet" href="assets/css/responsive.css">
		<!-- Custom CSS -->
		<link rel="stylesheet" href="assets/css/custom.css">

		<link rel="stylesheet" href="assets/css/all.css" />

		<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"
			type='text/css'>

		<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	</head>
	<div class="main-top">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-14 col-xs-14">
					<div class="text-slid-box">
						<div id="offer-box" class="carouselTicker">
							<ul class="offer-box">
								<?php
                                        $cstatement = $pdo->prepare("SELECT * FROM tbl_coupons WHERE cstatus=1");
                                        $cstatement->execute();
                                        $cresult = $cstatement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($cresult as $crow) {
                                            $ccode = $crow['coupon_code'];
                                            $discount = $crow['discount_percentage']; ?>
								<li>
									<i class="fa fa-tag"></i></i> <?php echo $discount; ?>% off Entire
									Purchase Promo code: <i style="font-size:14px;"><?php echo $ccode; ?></i>
								</li>
								<?php
                                        } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="our-link">
						<ul>
							<li>
								<div class="dropdown">
									<i type="button" class='far fa-user-circle dropdown-toggle'
										style='font-size:24px; color:#ffffff;' id="dropdownMenuButton"
										data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<?php
                                        if (isset($_SESSION['customer']['cust_email']) && !empty($_SESSION['customer']['cust_email'])) {
                                            ?>
										<a style="color:black;" class="dropdown-item" href="dashboard.php">My
											Account</a>
										<a style="color:black;" class="dropdown-item" href="wishlist.php">Wishlist</a>
										<a style="color:black;" class="dropdown-item" href="logout.php">Logout</a>
										<?php
                                        } else {
                                            ?>
										<a style="color:black;" class="dropdown-item" href="login.php">Login</a>
										<a style="color:black;" class="dropdown-item"
											href="registration.php">Register</a>
										<?php
                                        } ?>
									</div>
								</div>
							</li>
							<!-- <li><a href="my-account.html"><i class='far fa-user-circle' style='font-size:24px'></i></a></li> -->
							<li><a href="sitemap.php"><i class='fas fa-map-marker-alt'
										style='font-size:24px;color:white'></i></a></li>
							<li><a href="contact-us.php"><i class='fa fa-phone'
										style='font-size:24px;color:white'></i></a>
							</li>
							<li><a href="track-order.php"><i class='fas fa-shipping-fast'
										style='font-size:24px;color:white'></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<!-- End Main Top -->

	<!-- Start Main Top -->
	<header class="main-header">
		<!-- Start Navigation -->
		<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
			<div class="container">
				<!-- Start Header Navigation -->
				<div class="navbar-header">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu"
						aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fa fa-bars"></i>
					</button>
					<a class="navbar-brand" href="index.php"><img src="assets/images/hf_logo.png" height="90 pixels"
							width="100 pixels" class="logo" alt=""></a>
				</div>
				<!-- End Header Navigation -->

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="navbar-menu">
					<ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
						<li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
						<li class="dropdown megamenu-fw">
							<a href="#" class="nav-link dropdown-toggle arrow" data-toggle="dropdown">Product</a>
							<ul class="dropdown-menu megamenu-content" role="menu">
								<li>
									<div class="row">
										<?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                    ?>
										<div class="col-menu col-md-3">
											<h6 class="title"><?php echo $row['tcat_name']; ?>
											</h6>
											<div class="content" style="display:block;">
												<ul class="menu-col">
													<?php
                                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
                                                    $statement1->execute(array($row['tcat_id']));
                                                    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result1 as $row1) {
                                                        ?>
													<li><a
															href="shop.php?id=<?php echo $row1['mcat_id']; ?>&type=sub"><?php echo $row1['mcat_name']; ?></a>
													</li>
													<?php
                                                    } ?>
												</ul>
											</div>
										</div>
										<?php
                                                } ?>
									</div>
									<!-- end row -->
								</li>
							</ul>
						</li>
						<li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
						<li class="nav-item"><a class="nav-link" href="shop.php?type=all">Shop</a></li>
						<li class="nav-item"><a class="nav-link" href="service.php">Our Service</a></li>
						<li class="nav-item"><a class="nav-link" href="contact-us.php">Contact Us</a></li>
						<li class="nav-item"><a class="nav-link" href="track-order.php">Track Order</a></li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->

				<!-- Start Atribute Navigation -->
				<div class="attr-nav">
					<ul>
						<li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
						<li><a href="cart.php">
								<i class="fa fa-shopping-cart"></i>
								<span class="badge">
									<?php
                                function cart_count_update()
                                {
                                    if (isset($_SESSION['cart_p_id'])) {
                                        $table_total_price = 0;
                                        $i=0;
                                        foreach ($_SESSION['cart_p_qty'] as $key => $value) {
                                            $i++;
                                            $arr_cart_p_qty[$i] = $value;
                                        }
                                        $cart_qty=0;
                                        
                                        for ($i=1;$i<=count($arr_cart_p_qty);$i++) {
                                            $cart_qty = $cart_qty+$arr_cart_p_qty[$i];
                                        }
                                        echo $cart_qty;
                                    } else {
                                        echo '0';
                                    }
                                }
                                cart_count_update();
                                ?>
								</span>
							</a></li>
					</ul>
				</div>
				<!-- End Atribute Navigation -->

				<!-- Start Side Menu -->
				<!-- <div class="side">
					<a href="#" class="close-side"><i class="fa fa-times"></i></a>
					<li class="cart-box">
						<ul class="cart-list">
							<li>
								<a href="Accessories.html" class="photo"><img src="assets/images/mask5.jpg"
										class="cart-thumb" alt="" /></a>
								<h6><a href="Accessories.html">Mask</a></h6>
								<p>1x - <span class="price">Rs.499.00</span></p>
							</li>
							<li>
								<a href="Accessories.html" class="photo"><img src="assets/images/bag.jpg"
										class="cart-thumb" alt="" /></a>
								<h6><a href="Accessories.html">Bag</a></h6>
								<p>1x - <span class="price">Rs.2,999.00</span></p>
							</li>
							<li>
								<a href="duppatas.html" class="photo"><img src="assets/images/shawal.jpg"
										class="cart-thumb" alt="" /></a>
								<h6><a href="duppatas.html">Shawl</a></h6>
								<p>1x - <span class="price">Rs.2,499.00</span></p>
							</li>
							<li class="total">
								<a href="cart.html" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
								<span class="float-right"><strong>Total</strong>:Rs.6000</span>
							</li>
						</ul>
					</li>
				</div> -->
				<!-- End Side Menu -->
		</nav>
		<!-- End Navigation -->
	</header>
	<!-- End Main Top -->

	<!-- Start Top Search -->
	<div class="top-search">
		<div class="container">
			<div class="input-group">
				<form action="search-result.php" method="get" name="frm_search" id="frm_search">
					<button class="input-group-addon" type="submit"><i class="fa fa-search"></i></button>
				</form>
				<input type="text" class="form-control" placeholder="Search">
				<span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
			</div>
		</div>
	</div>
	<!-- End Top Search -->