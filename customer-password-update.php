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

$password_error = "";
$rpassword_error = "";


if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['cust_password']) || empty($_POST['cust_re_password'])) {
        $valid = 0;
        $error_message .= "Password can not be empty.<br>";
    }

    if (!empty($_POST['cust_password']) && !empty($_POST['cust_re_password'])) {
        if ($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= "Passwords do not match.<br>";
        }
    }
    
    if ($valid == 1) {

        // update data into the database

        $password = strip_tags($_POST['cust_password']);
        
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_password=? WHERE cust_id=?");
        $statement->execute(array(md5($password),$_SESSION['customer']['cust_id']));
        
        $_SESSION['customer']['cust_password'] = md5($password);

        $success_message = "Password is updated successfully.";
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
                        <br><br>
                        <h1>
                            <center>Update Password</center>
                        </h1>
                        <br>
                        <form action="" method="post">
                            <?php $csrf->echoInputField(); ?>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <?php
                                                        if ($error_message != '') {
                                                            echo "<tr><td colspan='2'><div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;color:red;text-align:center;'>".$error_message."</div></td></tr>";
                                                        }
                                                        if ($success_message != '') {
                                                            echo "<tr><td colspan='2'><div class='success' style='padding: 10px;background:#3c763d;margin-bottom:20px;color:#ffffff;text-align:center;'><b><center>".$success_message."</center></b></div></td></tr>";
                                                        }
                                                ?>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Password*</b></td>
                                                <td><input style="width:100%;height:40px;" type="password"
                                                        class="form-control" name="cust_password">
                                                    <?php if (isset($password_error)) {
                                                    echo '<span style="color:red;">'.$password_error.'</span>';
                                                } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Retype Password*</b></td>
                                                <td><input style="width:100%;height:40px;" type="password"
                                                        class="form-control" name="cust_re_password">
                                                    <?php if (isset($rpassword_error)) {
                                                    echo '<span style="color:red;">'.$rpassword_error.'</span>';
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