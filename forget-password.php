<?php
    
include("header.php");

$email_error = "";

if(isset($_POST['form1'])) {

    $valid = 1;
        
    if(empty($_POST['cust_email'])) {
        $valid = 0;
        $email_error = "Enter Email <br>";
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $email_error = "Enter Correct Email<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();                        
            if(!$total) {
                $valid = 0;
                $error_message = "No Record Found";
            }
        }
    }

    if($valid == 1) {

        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $forget_password_message = $row['forget_password_message'];
        }

        $token = md5(rand());
        $now = time();

        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_token=?,cust_timestamp=? WHERE cust_email=?");
        $statement->execute(array($token,$now,strip_tags($_POST['cust_email'])));

        // Send email for confirmation of the account
        $to = $_POST['cust_email'];
        $subject = "Reset Password";
        $message = '<p>Click Below Link to Change Password<br> <a href="'.BASE_URL.'reset-password.php?email='.$_POST['cust_email'].'&token='.$token.'">Click here</a>';
        
        try {
            $mail->isSMTP();                      // Set mailer to use SMTP 
            $mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
            $mail->SMTPAuth = true;               // Enable SMTP authentication 
            $mail->Username = 'clothingbrandhf@gmail.com';   // SMTP username 
            $mail->Password = 'eonmvpmfidiwwymt';   // SMTP password 
            $mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
            $mail->Port = 587;                    // TCP port to connect to  

            $mail->setFrom($contact_email, 'HF Clothing');
            $mail->addAddress($to);
            $mail->addReplyTo($contact_email, 'HF Clothing');
            
            $mail->isHTML(true);
            $mail->Subject = $subject;

            $mail->Body = $message;
            $mail->send();

            $success_message = "A confirmation link is sent to your email address. You will get the password reset information in there.";
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
?>

<div class="page-banner" style="background-color:#444;">
    <div class="inner">
        <h1 style="text-align:center;padding:30px;color:#fff">Forgot Password</h1>
    </div>
</div>

<div class="page" style="padding-top:30px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                        <?php
                                if ($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;color:red;width:360px;margin:0 auto;'>".$error_message."</div><br>";
                                }
                                if ($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#3c763d;margin-bottom:20px;color:#fff;width:360px;margin:0 auto;'><b><center>".$success_message."</center></b></div>";
                                }
                        ?>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Email Address *</label>
                                    <input type="email" class="form-control" name="cust_email">
                                    <?php if (isset($email_error)) {
                                                    echo '<span style="color:red;">'.$email_error.'</span>';
                                                } ?>
                                </div>
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-primary" value="Submit" name="form1">
                                </div>
                                <a href="login.php" style="color:#e4144d;">Back to Login Page</a><br>
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