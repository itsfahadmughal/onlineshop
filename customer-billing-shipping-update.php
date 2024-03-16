<?php
    
include("header.php");
// Check if the customer is logged in or not
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>

<?php
if (isset($_POST['form1'])) {


    // update data into the database
    $statement = $pdo->prepare("UPDATE tbl_customer SET 
                            cust_b_name=?, 
                            cust_b_phone=?, 
                            cust_b_country=?, 
                            cust_b_address=?, 
                            cust_b_city=?, 
                            cust_b_zip=?,
                            cust_s_name=?, 
                            cust_s_phone=?, 
                            cust_s_country=?, 
                            cust_s_address=?, 
                            cust_s_city=?, 
                            cust_s_zip=? 

                            WHERE cust_id=?");
    $statement->execute(array(
                            strip_tags($_POST['cust_b_name']),
                            strip_tags($_POST['cust_b_phone']),
                            strip_tags($_POST['cust_b_country']),
                            strip_tags($_POST['cust_b_address']),
                            strip_tags($_POST['cust_b_city']),
                            strip_tags($_POST['cust_b_zip']),
                            strip_tags($_POST['cust_s_name']),
                            strip_tags($_POST['cust_s_phone']),
                            strip_tags($_POST['cust_s_country']),
                            strip_tags($_POST['cust_s_address']),
                            strip_tags($_POST['cust_s_city']),
                            strip_tags($_POST['cust_s_zip']),
                            $_SESSION['customer']['cust_id']
                        ));  
   
    $success_message = "Information Updated Sucessfully";

    $_SESSION['customer']['cust_b_name'] = strip_tags($_POST['cust_b_name']);
    $_SESSION['customer']['cust_b_phone'] = strip_tags($_POST['cust_b_phone']);
    $_SESSION['customer']['cust_b_country'] = strip_tags($_POST['cust_b_country']);
    $_SESSION['customer']['cust_b_address'] = strip_tags($_POST['cust_b_address']);
    $_SESSION['customer']['cust_b_city'] = strip_tags($_POST['cust_b_city']);
    $_SESSION['customer']['cust_b_zip'] = strip_tags($_POST['cust_b_zip']);
    $_SESSION['customer']['cust_s_name'] = strip_tags($_POST['cust_s_name']);
    $_SESSION['customer']['cust_s_phone'] = strip_tags($_POST['cust_s_phone']);
    $_SESSION['customer']['cust_s_country'] = strip_tags($_POST['cust_s_country']);
    $_SESSION['customer']['cust_s_address'] = strip_tags($_POST['cust_s_address']);
    $_SESSION['customer']['cust_s_city'] = strip_tags($_POST['cust_s_city']);
    $_SESSION['customer']['cust_s_zip'] = strip_tags($_POST['cust_s_zip']);

}
?>
<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>My Account</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Billing and Shipping Info</li>
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
                <?php require_once('cust-sidebar.php'); ?>
                <br><br>
            </div>
            <?php
                if ($error_message != '') {
                    echo "<div class='col-md-12 error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;color:red;'>".$error_message."</div>";
                }
                if ($success_message != '') {
                    echo "<div class='col-md-12 success' style='padding: 10px;background:#3c763d;margin-bottom:20px;color:#fff;'><b><center>".$success_message."</center></b></div>";
                }
            ?>
            <div class="col-md-12">
                <div class="user-content">
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" class="align-middle text-center"><h2><strong>Update Billing Address<strong></h2></td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle text-right"><b>Full Name</b></td>
                                            <td>
                                                <input style="width:100%;height:40px;" type="text" class="form-control" name="cust_b_name" value="<?php echo $_SESSION['customer']['cust_b_name']; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle text-right"><b>Phone Number</b></td>
                                            <td>
                                                <input style="width:100%;height:40px;" type="text" class="form-control" name="cust_b_phone" value="<?php echo $_SESSION['customer']['cust_b_phone']; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                                <td class="align-middle text-right"><b>Country*</b></td>
                                                <td>
                                                    <select style="width:100%;height:40px;" name="cust_b_country" class="form-control select2">
                                                        <option value="">Select country</option>
                                                        <?php
                                                            $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                                            $statement->execute();
                                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($result as $row) {
                                                                ?>
                                                            <option value="<?php echo $row['country_id']; ?>" <?php if($row['country_id'] == $_SESSION['customer']['cust_b_country']) {echo 'selected';} ?>><?php echo $row['country_name']; ?></option>
                                                        <?php
                                                            }
                                                            ?>
                                                    </select>
                                                    <?php if (isset($country_error)) {
                                                                echo '<span style="color:red;">'.$country_error.'</span>';
                                                            } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Address*</b></td>
                                                <td><textarea name="cust_b_address" class="form-control" cols="30"
                                                        rows="10" style="height:70px;"><?php echo $_SESSION['customer']['cust_b_address']; ?></textarea>
                                                    <?php if (isset($address_error)) {
                                                                echo '<span style="color:red;">'.$address_error.'</span>';
                                                            } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>City*</b></td>
                                                <td><input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_b_city"value="<?php echo $_SESSION['customer']['cust_b_city']; ?>">
                                                    <?php if (isset($city_error)) {
                                                                echo '<span style="color:red;">'.$city_error.'</span>';
                                                            } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Zip Code*</b></td>
                                                <td><input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_b_zip" value="<?php echo $_SESSION['customer']['cust_b_zip']; ?>">
                                                    <?php if (isset($zipcode_error)) {
                                                                echo '<span style="color:red;">'.$zipcode_error.'</span>';
                                                            } ?>
                                                </td>
                                            </tr>
                                            </tbody>
                                    </table>
                            </div>
                            <div class="col-md-6">
                            <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" class="align-middle text-center"><h2><strong>Update Shipping Address<strong></h2></td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle text-right"><b>Full Name</b></td>
                                            <td>
                                                <input style="width:100%;height:40px;" type="text" class="form-control" name="cust_s_name" value="<?php echo $_SESSION['customer']['cust_s_name']; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle text-right"><b>Phone Number</b></td>
                                            <td>
                                                <input style="width:100%;height:40px;" type="text" class="form-control" name="cust_s_phone" value="<?php echo $_SESSION['customer']['cust_s_phone']; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                                <td class="align-middle text-right"><b>Country*</b></td>
                                                <td>
                                                    <select style="width:100%;height:40px;" name="cust_s_country" class="form-control select2">
                                                        <option value="">Select country</option>
                                                        <?php
                                                            $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                                            $statement->execute();
                                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($result as $row) {
                                                                ?>
                                                            <option value="<?php echo $row['country_id']; ?>" <?php if($row['country_id'] == $_SESSION['customer']['cust_s_country']) {echo 'selected';} ?>><?php echo $row['country_name']; ?></option>
                                                        <?php
                                                            }
                                                            ?>
                                                    </select>
                                                    <?php if (isset($country_error)) {
                                                                echo '<span style="color:red;">'.$country_error.'</span>';
                                                            } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Address*</b></td>
                                                <td><textarea name="cust_s_address" class="form-control" cols="30"
                                                        rows="10" style="height:70px;"><?php echo $_SESSION['customer']['cust_s_address']; ?></textarea>
                                                    <?php if (isset($address_error)) {
                                                                echo '<span style="color:red;">'.$address_error.'</span>';
                                                            } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>City*</b></td>
                                                <td><input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_s_city"value="<?php echo $_SESSION['customer']['cust_s_city']; ?>">
                                                    <?php if (isset($city_error)) {
                                                                echo '<span style="color:red;">'.$city_error.'</span>';
                                                            } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Zip Code*</b></td>
                                                <td><input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_s_zip" value="<?php echo $_SESSION['customer']['cust_s_zip']; ?>">
                                                    <?php if (isset($zipcode_error)) {
                                                                echo '<span style="color:red;">'.$zipcode_error.'</span>';
                                                            } ?>
                                                </td>
                                            </tr>
                                            </tbody>
                                    </table>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Update" name="form1">
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>
<br>
<?php include("footer.php"); ?>
</body>

</html>