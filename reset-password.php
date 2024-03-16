<?php
    
include("header.php");

if (!isset($_GET['email']) || !isset($_GET['token'])) {
    header('location: '.BASE_URL.'login.php');
    exit;
}

$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=? AND cust_token=?");
$statement->execute(array($_GET['email'],$_GET['token']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$tot = $statement->rowCount();
if ($tot == 0) {
    header('location: '.BASE_URL.'login.php');
    exit;
}
foreach ($result as $row) {
    $saved_time = $row['cust_timestamp'];
}

$error_message2 = '';
if (time() - $saved_time > 86400) {
    $error_message2 = "Reset link has expired. Try again.";
}

$password_error = "";
$retype_password_error = "";

if (isset($_POST['form1'])) {
    $valid = 1;
    
    if (empty($_POST['cust_new_password'])) {
        $valid = 0;
        $password_error = "Enter Password";
    }

    if (empty($_POST['cust_re_password'])) {
        $valid = 0;
        $retype_password_error = "Retype Password";
    }


    if ($_POST['cust_new_password'] != $_POST['cust_re_password']) {
        $valid = 0;
        $error_message = "Both password are not same.";
    }
  

    if ($valid == 1) {
        $cust_new_password = strip_tags($_POST['cust_new_password']);
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_password=?, cust_token=?, cust_timestamp=? WHERE cust_email=?");
        $statement->execute(array(md5($cust_new_password),'','',$_GET['email']));
        
        header('location: '.BASE_URL.'reset-password-success.php');
    }
}
?>

<div class="page-banner" style="background-color:#444;">
    <div class="inner">
        <h1 style="text-align:center;padding:30px;color:#fff">Reset Password</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <br><br>
                    <h1>
                        <center>Reset Password</center>
                    </h1>
                    <br>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="col-md-12">
                            <div class="user-content" style="text-align:center;">
                                <table class="table table-bordered" style="width:50%; margin:0 auto;">
                                    <tbody>
                                        <?php
                                                    if ($error_message != '') {
                                                        echo "<tr><td colspan='2'><div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;color:red;width:360px;margin:0 auto;'>".$error_message."</div></td></tr>";
                                                    }
                                                    if ($error_message2 != '') {
                                                        echo "<tr><td colspan='2'><div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;color:red;width:360px;margin:0 auto;'>".$error_message2."</div></td></tr>";
                                                    }
                                            ?>
                                        <tr>
                                            <td class="align-middle text-right"><b>Enter Password *</b></td>
                                            <td>
                                                <input style="width:100%;height:40px;" type="password"
                                                    class="form-control" name="cust_new_password">
                                                <?php if (isset($password_error)) {
                                                echo '<span style="color:red;float:left;">'.$password_error.'</span>';
                                            } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle text-right"><b>Retype Password *</b></td>
                                            <td>
                                                <input style="width:100%;height:40px;" type="password"
                                                    class="form-control" name="cust_re_password">
                                                <?php if (isset($retype_password_error)) {
                                                echo '<span style="color:red;float:left;">'.$retype_password_error.'</span>';
                                            } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input style="width:100%;height:40px;" type="submit" type="submit"
                                                    class="btn btn-primary" value="Update" name="form1">
                                            </td>
                                        </tr>
                                </table>
                            </div>
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