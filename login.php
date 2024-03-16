<?php
    include("header.php");

    $email_error = "";
    $password_error = "";

    function set_previous_page_url()
    {
        $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $previous_url = $_SERVER['HTTP_REFERER'];
        
        if (!($current_url === $previous_url)) {
            $_SESSION['redirect_url'] = $previous_url;
        }
        if (isset($_SESSION['redirect_url'])) {
            $url = $_SESSION['redirect_url'];
            return $url;
        } else {
            $url = "index.php";
            return $url;
        }
    }

    $prev_page_url = set_previous_page_url();
    
    if (isset($_POST['form1'])) {
        $valid = 1;
        if (empty($_POST['cust_email'])) {
            $email_error = 'Enter Email Address<br>';
        } else {
            if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
                $valid = 0;
                $email_error = "Enter Correct Email<br>";
            }
        }
                
        if (empty($_POST['cust_password'])) {
            $valid = 0;
            $password_error = 'Enter Password<br>';
        }
        
        
        if ($valid == 1) {
            $cust_email = strip_tags($_POST['cust_email']);
            $cust_password = strip_tags($_POST['cust_password']);
    
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($cust_email));
            $total = $statement->rowCount();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $cust_status = $row['cust_status'];
                $row_password = $row['cust_password'];
            }
    
            if ($total==0) {
                $error_message = 'No record found with this Email Address<br>';
            } else {
                if ($row_password != md5($cust_password)) {
                    $error_message = 'Incorrect Password<br>';
                } else {
                    if ($cust_status == 0) {
                        $error_message = 'Please activate your email address. Check your email<br>';
                    } else {
                        $_SESSION['customer'] = $row;
                        if (strpos($prev_page_url, 'checkout') !== false) {
                            header("location: ".$prev_page_url);
                        } else {
                            header("location: ".BASE_URL."dashboard.php");
                        }
                    }
                }
            }
        }
    }

?>
<!----------login in------------>
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <br><br>
                    <h1>
                        <center>CUSTOMER LOGIN</center>
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
                                                            echo "<tr><td colspan='2'><div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;color:red;'>".$error_message."</div></td></tr>";
                                                        }
                                                        if ($success_message != '') {
                                                            echo "<tr><td colspan='2'><div class='success' style='padding: 10px;background:#3c763d;margin-bottom:20px;'><b><center>".$success_message."</center></b></div></td></tr>";
                                                        }
                                                ?>
                                        <tr>
                                            <td class="align-middle text-right"><b>Customer Email</b></td>
                                            <td>
                                                <input style="width:100%;height:40px;" type="email" class="form-control"
                                                    name="cust_email" value="<?php if (isset($_POST['cust_email'])) {
                                                    echo $_POST['cust_email'];
                                                } ?>">
                                                <?php if (isset($email_error)) {
                                                    echo '<span style="color:red;">'.$email_error.'</span>';
                                                } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle text-right"><b>Password</b></td>
                                            <td>
                                                <input style="width:100%;height:40px;" type="password"
                                                    class="form-control" name="cust_password" value="<?php if (isset($_POST['cust_password'])) {
                                                    echo $_POST['cust_password'];
                                                } ?>">
                                                <?php if (isset($password_error)) {
                                                    echo '<span style="color:red;">'.$password_error.'</span>';
                                                } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input style="height:40px;text-align:right;" type="submit"
                                                    class="btn btn-primary" value="Login" name="form1">
                                                <br>
                                                <a style="float:right;color:#e4144d;" href=" forget-password.php">Forget
                                                    Password?</a>
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