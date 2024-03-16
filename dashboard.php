<?php
    include("header.php");
?>

<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>My Account</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active">My Account</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->

<!-- Start My Account  -->
<div class="my-account-box-main">
    <div class="container">
        <div class="my-account-page">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="account-box">
                        <div class="service-box">
                            <div class="service-icon">
                                <a href="customer-profile-update.php"> <i class="fa fa-user"></i> </a>
                            </div>
                            <div class="service-desc">
                                <h4>Update Profile</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="account-box">
                        <div class="service-box">
                            <div class="service-icon">
                                <a href="customer-billing-shipping-update.php"> <i class="fa fa-truck"></i> </a>
                            </div>
                            <div class="service-desc">
                                <h4>Update Shipping and Billing Info</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="account-box">
                        <div class="service-box">
                            <div class="service-icon">
                                <a href="customer-order.php"> <i class="fa fa-file"></i> </a>
                            </div>
                            <div class="service-desc">
                                <h4>Your Orders</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="account-box">
                        <div class="service-box">
                            <div class="service-icon">
                                <a href="customer-password-update.php"> <i class="fa fa-key"></i> </a>
                            </div>
                            <div class="service-desc">
                                <h4>Update Password</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="account-box">
                        <div class="service-box">
                            <div class="service-icon">
                                <a href="logout.php"> <i class="fa fa-close"></i> </a>
                            </div>
                            <div class="service-desc">
                                <h4>Logout</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End My Account -->

<?php include("footer.php"); ?>
</body>

</html>