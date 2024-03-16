<?php require_once('header.php'); ?>

<?php

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $contact_map_iframe = $row['contact_map_iframe'];
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $contact_address = $row['contact_address'];
}

// After form submit checking everything for email sending
if (isset($_POST['form_contact'])) {
    $error_message = '';
    $success_message = '';
    $name_error = '';
    $email_error = '';
    $subject = '';
    $message = '';

    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $receive_email = $row['receive_email'];
        $receive_email_subject = $row['receive_email_subject'];
        $receive_email_thank_you_message = $row['receive_email_thank_you_message'];
    }

    $valid = 1;

    if (empty($_POST['visitor_name'])) {
        $valid = 0;
        $name_error = 'Please enter your name.';
    }

    if (empty($_POST['visitor_email'])) {
        $valid = 0;
        $email_error = 'Please enter your email address.';
    } else {
        // Email validation check
        if (!filter_var($_POST['visitor_email'], FILTER_VALIDATE_EMAIL)) {
            $valid = 0;
            $email_error = 'Please enter a valid email address.';
        }
    }

    if (empty($_POST['subject'])) {
        $valid = 0;
        $subject_error = 'Please enter Subject.';
    }

    if (empty($_POST['visitor_message'])) {
        $valid = 0;
        $message_error = 'Please enter your message.';
    }

    if ($valid == 1) {
        $visitor_name = strip_tags($_POST['visitor_name']);
        $visitor_email = strip_tags($_POST['visitor_email']);
        $subject = strip_tags($_POST['subject']);
        $visitor_message = strip_tags($_POST['visitor_message']);

        // sending email
        $to_admin = $receive_email;
        $subject = $receive_email_subject;
        $message = '
                    <html><body>
                    <table>
                    <tr>
                    <td>Name</td>
                    <td>'.$visitor_name.'</td>
                    </tr>
                    <tr>
                    <td>Email</td>
                    <td>'.$visitor_email.'</td>
                    </tr>
                    <tr>
                    <td>Comment</td>
                    <td>'.nl2br($visitor_message).'</td>
                    </tr>
                    </table>
                    </body></html>
                    ';
        try {
            $mail->isSMTP();                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;               // Enable SMTP authentication
            $mail->Username = 'clothingbrandhf@gmail.com';   // SMTP username
            $mail->Password = 'pzzueueibayegyhf';   // SMTP password
            $mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                    // TCP port to connect to

            $mail->setFrom($visitor_email, $visitor_name);
            $mail->addAddress($to_admin);
            $mail->addReplyTo($visitor_email, $visitor_name);
                        
            $mail->isHTML(true);
            $mail->Subject = $subject;
            
            $mail->Body = $message;
            $mail->send();
            
            $success_message = $receive_email_thank_you_message;
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
?>

<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Contact Us</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"> Contact Us </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->

<!-- Start Contact Us  -->
<div class="contact-box-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="contact-info-left">
                    <h2>CONTACT INFO</h2>
                    <p>If you have any questions/concerns about our Shipping policy, please feel free to contact our
                        Customer Support department. </p>
                    <ul>
                        <li>
                            <p><i class="fas fa-map-marker-alt"></i>Address: <?php echo $contact_address; ?>
                            </p>
                        </li>
                        <li>
                            <p><i class="fas fa-phone-square"></i>Phone: <a href="tel:0300-6158873"><?php echo $contact_phone; ?></a></p>
                        </li>
                        <li>
                            <p><i class="fas fa-envelope"></i>Email: <a
                                    href="mailto:<?php echo $contact_email; ?>"><?php echo $contact_email; ?></a></p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="contact-form-right">
                    <?php
                        if ($success_message != '') {
                            echo "<div class='success' style='padding: 10px;background:#3c763d;margin-bottom:20px;color:#fff;'><b><center>".$success_message."</center></b></div>";
                        }
                    ?>
                    <h2>GET IN TOUCH</h2>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" name="visitor_name"
                                        placeholder="Your Name">
                                    <?php if (isset($name_error)) {
                        echo '<span style="color:red;">'.$name_error.'</span>';
                    } ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Your Email" id="email" class="form-control"
                                        name="visitor_email">
                                    <?php if (isset($email_error)) {
                        echo '<span style="color:red;">'.$email_error.'</span>';
                    } ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="subject" name="subject"
                                        placeholder="Subject">
                                    <?php if (isset($subject_error)) {
                        echo '<span style="color:red;">'.$subject_error.'</span>';
                    } ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="message" name="visitor_message"
                                        placeholder="Your Message" rows="4"></textarea>
                                    <?php if (isset($message_error)) {
                        echo '<span style="color:red;">'.$message_error.'</span>';
                    } ?>
                                </div>
                                <div class="submit-button text-center">
                                    <button class="btn hvr-hover" name="form_contact" id="submit" type="submit">Send
                                        Message</button>
                                    <div id="msgSubmit" class="h3 text-center hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Cart -->

<?php require_once('footer.php');
