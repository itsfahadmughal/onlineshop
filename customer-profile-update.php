<?php
    
include("header.php");

// Check if the customer is logged in or not
if (!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if ($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}

$cname_error = "";
$email_error = "";
$phone_error = "";
$country_error = "";
$city_error = "";
$zipcode_error = "";
$address_error = "";


if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['cust_name'])) {
        $valid = 0;
        $cname_error = "Enter Customer Name <br>";
    }

    if (empty($_POST['cust_phone'])) {
        $valid = 0;
        $phone_error = "Enter Customer Phone<br>";
    }

    if (empty($_POST['cust_address'])) {
        $valid = 0;
        $address_error = "Enter Customer Address <br>";
    }

    if (empty($_POST['cust_country'])) {
        $valid = 0;
        $country_error = "Enter Customer Country <br>";
    }

    if (empty($_POST['cust_city'])) {
        $valid = 0;
        $city_error = "Enter Customer City <br>";
    }

    if (empty($_POST['cust_zip'])) {
        $valid = 0;
        $zipcode_error = "Enter Zip Code <br>";
    }

    if ($valid == 1) {
        $token = md5(time());
        $cust_datetime = date('Y-m-d h:i:s');
        $cust_timestamp = time();

        // saving into the database
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_name=?, cust_phone=?, cust_country=?, cust_address=?, cust_city=?, cust_zip=? WHERE cust_id=?");
        $statement->execute(array(
                    strip_tags($_POST['cust_name']),
                    strip_tags($_POST['cust_phone']),
                    strip_tags($_POST['cust_country']),
                    strip_tags($_POST['cust_address']),
                    strip_tags($_POST['cust_city']),
                    strip_tags($_POST['cust_zip']),
                    $_SESSION['customer']['cust_id']
                ));

        // Send email for confirmation of the account
        $to = $_POST['cust_email'];
        
        $subject = "Verify your email";
        $verify_link = BASE_URL.'verify.php?email='.$to.'&token='.$token;
        $message = 'Click the following link to verify your email<br><br><a href="'.$verify_link.'">'.$verify_link.'</a>';
        
        
        $success_message = "Profile Updated successfully!";

        $_SESSION['customer']['cust_name'] = $_POST['cust_name'];
        $_SESSION['customer']['cust_phone'] = $_POST['cust_phone'];
        $_SESSION['customer']['cust_country'] = $_POST['cust_country'];
        $_SESSION['customer']['cust_address'] = $_POST['cust_address'];
        $_SESSION['customer']['cust_city'] = $_POST['cust_city'];
        $_SESSION['customer']['cust_zip'] = $_POST['cust_zip'];
    }
}
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
    <div class="page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php include("cust-sidebar.php"); ?>
                    <div class="user-content">
                        <form action="" method="post">
                            <?php $csrf->echoInputField(); ?>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <?php
                                                        if ($error_message != '') {
                                                            echo "<tr><td colspan='2'><div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;color:red;'>".$error_message."</div></td></tr>";
                                                        }
                                                        if ($success_message != '') {
                                                            echo "<tr><td colspan='2'><div class='success' style='padding: 10px;background:#3c763d;margin-bottom:20px;color:#ffffff;'><b><center>".$success_message."</center></b></div></td></tr>";
                                                        }
                                                ?>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Customer Name*</b></td>
                                                <td>
                                                    <input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_name"
                                                        value="<?php echo $_SESSION['customer']['cust_name']; ?>">
                                                    <?php if (isset($cname_error)) {
                                                    echo '<span style="color:red;">'.$cname_error.'</span>';
                                                } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Customer Email*</b></td>
                                                <td><input style="width:100%;height:40px;" type="email"
                                                        class="form-control" name="cust_email"
                                                        value="<?php echo $_SESSION['customer']['cust_email']; ?>"
                                                        readonly>
                                                    <?php if (isset($email_error)) {
                                                    echo '<span style="color:red;">'.$email_error.'</span>';
                                                } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Phone Number*</b></td>
                                                <td><input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_phone"
                                                        value="<?php echo $_SESSION['customer']['cust_phone']; ?>">
                                                    <?php if (isset($phone_error)) {
                                                    echo '<span style="color:red;">'.$phone_error.'</span>';
                                                } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Country*</b></td>
                                                <td>
                                                    <select name="cust_country" class="form-control">
                                                        <?php
                                                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                                        $statement->execute();
                                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($result as $row) {
                                                            ?>
                                                        <option
                                                            value="<?php echo $row['country_id']; ?>"
                                                            <?php if ($row['country_id'] == $_SESSION['customer']['cust_country']) {
                                                                echo 'selected';
                                                            } ?>><?php echo $row['country_name']; ?>
                                                        </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>City*</b></td>
                                                <td><input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_city"
                                                        value="<?php echo $_SESSION['customer']['cust_city']; ?>">
                                                    <?php if (isset($city_error)) {
                                                            echo '<span style="color:red;">'.$city_error.'</span>';
                                                        } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Zip Code*</b></td>
                                                <td><input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_zip"
                                                        value="<?php echo $_SESSION['customer']['cust_zip']; ?>">
                                                    <?php if (isset($zipcode_error)) {
                                                            echo '<span style="color:red;">'.$zipcode_error.'</span>';
                                                        } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Address*</b></td>
                                                <td><textarea name="cust_address" class="form-control" cols="30"
                                                        rows="10"
                                                        style="height:70px;"><?php echo $_SESSION['customer']['cust_address']; ?></textarea>
                                                    <?php if (isset($address_error)) {
                                                            echo '<span style="color:red;">'.$address_error.'</span>';
                                                        } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <input style="width:100%;height:40px;" type="submit"
                                                        class="btn btn-primary" value="Update" name="form1">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>