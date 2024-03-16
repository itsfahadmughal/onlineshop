<?php
    
include("header.php");

$cname_error = "";
$email_error = "";
$phone_error = "";
$country_error = "";
$city_error = "";
$zipcode_error = "";
$address_error = "";
$password_error = "";
$rpassword_error = "";

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $contact_email = $row['contact_email'];
    $receive_email_thank_you_message = $row['receive_email_thank_you_message'];
}

if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['cust_name'])) {
        $valid = 0;
        $cname_error = "Enter Customer Name <br>";
    }

    if (empty($_POST['cust_email'])) {
        $valid = 0;
        $email_error = "Enter Customer Email <br>";
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $email_error = "Enter Correct Email<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();
            if ($total) {
                $valid = 0;
                $email_error = "Customer with same email already exisits <br>";
            }
        }
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

    if (empty($_POST['cust_password']) || empty($_POST['cust_re_password'])) {
        $valid = 0;
        $password_error = "Enter Password <br>";
    }

    if (!empty($_POST['cust_password']) && !empty($_POST['cust_re_password'])) {
        if ($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $rpassword_error = "Both password not same<br>";
        }
    }

    if ($valid == 1) {
        $token = md5(time());
        $cust_datetime = date('Y-m-d h:i:s');
        $cust_timestamp = time();

        // saving into the database
        $statement = $pdo->prepare("INSERT INTO tbl_customer (
                    cust_name,
                    cust_email,
                    cust_phone,
                    cust_country,
                    cust_address,
                    cust_city,
                    cust_zip,
                    cust_b_name,
                    cust_b_phone,
                    cust_b_country,
                    cust_b_address,
                    cust_b_city,
                    cust_b_zip,
                    cust_s_name,
                    cust_s_phone,
                    cust_s_country,
                    cust_s_address,
                    cust_s_city,
                    cust_s_zip,
                    cust_password,
                    cust_token,
                    cust_datetime,
                    cust_timestamp,
                    cust_status
                ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
                    strip_tags($_POST['cust_name']),
                    strip_tags($_POST['cust_email']),
                    strip_tags($_POST['cust_phone']),
                    strip_tags($_POST['cust_country']),
                    strip_tags($_POST['cust_address']),
                    strip_tags($_POST['cust_city']),
                    strip_tags($_POST['cust_zip']),
                    strip_tags($_POST['cust_name']),
                    strip_tags($_POST['cust_phone']),
                    strip_tags($_POST['cust_country']),
                    strip_tags($_POST['cust_address']),
                    strip_tags($_POST['cust_city']),
                    strip_tags($_POST['cust_zip']),
                    strip_tags($_POST['cust_name']),
                    strip_tags($_POST['cust_phone']),
                    strip_tags($_POST['cust_country']),
                    strip_tags($_POST['cust_address']),
                    strip_tags($_POST['cust_city']),
                    strip_tags($_POST['cust_zip']),
                    md5($_POST['cust_password']),
                    $token,
                    $cust_datetime,
                    $cust_timestamp,
                    0
                ));

        // Send email for confirmation of the account
        $to = $_POST['cust_email'];
        
        $subject = "Verify your email";
        $verify_link = BASE_URL.'verify.php?email='.$to.'&token='.$token;
        $message = 'Click the following link to verify your email<br><br><a href="'.$verify_link.'">'.$verify_link.'</a>';
        
        try {
            $mail->isSMTP();                      // Set mailer to use SMTP 
            $mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
            $mail->SMTPAuth = true;               // Enable SMTP authentication 
            $mail->Username = 'clothingbrandhf@gmail.com';   // SMTP username 
            $mail->Password = 'pzzueueibayegyhf';   // SMTP password 
            $mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
            $mail->Port = 587;                    // TCP port to connect to  

            $mail->setFrom($contact_email, 'HF Clothing');
            $mail->addAddress($to, $_POST['cust_name']);
            $mail->addReplyTo($contact_email, 'HF Clothing');
            
            $mail->isHTML(true);
            $mail->Subject = $subject;

            $mail->Body = $message;
            $mail->send();

            $success_message = $receive_email_thank_you_message;
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

        unset($_POST['cust_name']);
        unset($_POST['cust_cname']);
        unset($_POST['cust_email']);
        unset($_POST['cust_phone']);
        unset($_POST['cust_address']);
        unset($_POST['cust_city']);
        unset($_POST['cust_state']);
        unset($_POST['cust_zip']);

        $success_message = "You have registered successfully!";
    }
}
?>

    <div class="page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="user-content">
                        <br><br>
                        <h1>
                            <center>CUSTOMER REGISTRATION</center>
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
                                                            echo "<tr><td colspan='2'><div class='success' style='padding: 10px;background:#3c763d;margin-bottom:20px;color:#fff;'><b><center>".$success_message."</center></b></div></td></tr>";
                                                        }
                                                ?>
                                            <tr>
                                                <td class="align-middle text-right"><b>Customer Name*</b></td>
                                                <td>
                                                    <input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_name" value="<?php if (isset($_POST['cust_name'])) {
                                                    echo $_POST['cust_name'];
                                                } ?>">
                                                    <?php if (isset($cname_error)) {
                                                    echo '<span style="color:red;">'.$cname_error.'</span>';
                                                } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Customer Email*</b></td>
                                                <td><input style="width:100%;height:40px;" type="email"
                                                        class="form-control" name="cust_email" value="<?php if (isset($_POST['cust_email'])) {
                                                    echo $_POST['cust_email'];
                                                } ?>">
                                                    <?php if (isset($email_error)) {
                                                    echo '<span style="color:red;">'.$email_error.'</span>';
                                                } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Phone Number*</b></td>
                                                <td><input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_phone" value="<?php if (isset($_POST['cust_phone'])) {
                                                    echo $_POST['cust_phone'];
                                                } ?>">
                                                    <?php if (isset($phone_error)) {
                                                    echo '<span style="color:red;">'.$phone_error.'</span>';
                                                } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Country*</b></td>
                                                <td>
                                                    <select style="width:100%;height:40px;" name="cust_country"
                                                        class="form-control select2">
                                                        <option value="">Select country</option>
                                                        <?php
                                                            $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                                            $statement->execute();
                                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($result as $row) {
                                                                ?>
                                                        <option
                                                            value="<?php echo $row['country_id']; ?>">
                                                            <?php echo $row['country_name']; ?>
                                                        </option>
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
                                                <td class="align-middle text-right"><b>City*</b></td>
                                                <td><input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_city" value="<?php if (isset($_POST['cust_city'])) {
                                                                echo $_POST['cust_city'];
                                                            } ?>">
                                                    <?php if (isset($city_error)) {
                                                                echo '<span style="color:red;">'.$city_error.'</span>';
                                                            } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Zip Code*</b></td>
                                                <td><input style="width:100%;height:40px;" type="text"
                                                        class="form-control" name="cust_zip" value="<?php if (isset($_POST['cust_zip'])) {
                                                                echo $_POST['cust_zip'];
                                                            } ?>">
                                                    <?php if (isset($zipcode_error)) {
                                                                echo '<span style="color:red;">'.$zipcode_error.'</span>';
                                                            } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle text-right"><b>Address*</b></td>
                                                <td><textarea name="cust_address" class="form-control" cols="30"
                                                        rows="10" style="height:70px;"><?php if (isset($_POST['cust_address'])) {
                                                                echo $_POST['cust_address'];
                                                            } ?></textarea>
                                                    <?php if (isset($address_error)) {
                                                                echo '<span style="color:red;">'.$address_error.'</span>';
                                                            } ?>
                                                </td>
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
                                                        class="btn btn-primary" value="Register" name="form1">
                                                    <hr>
                                                    <a style="width:100%;height:40px;" href="login.php"
                                                        class="btn btn-primary">Login</a>
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