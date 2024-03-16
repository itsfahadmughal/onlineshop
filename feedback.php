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


    $visitor_name = strip_tags($_POST['visitor_name']);
    $visitor_email = strip_tags($_POST['visitor_email']);
    $visitor_number = strip_tags($_POST['visitor_number']);
    $visitor_message = strip_tags($_POST['visitor_message']);
    $visitor_satisfied_level = strip_tags($_POST['fav_satisfied']);


    $today = date("Y-m-d H:i:s");


    $sql="INSERT INTO `tbl_feedback`(`full_name`, `email`, `phone`, `comment`, `satisfied_level`, `entrytime`) VALUES ('$visitor_name','$visitor_email','$visitor_number','$visitor_message','$visitor_satisfied_level','$today')";
    $result = $pdo->query($sql);

    if($result){
        echo "<script>
    window.location = 'payment_success.php';
</script>";
    }

}
?>

<!-- Start Contact Us  -->
<div class="pt-1 pb-2 bg_feedback">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <h2 class="text-center feedback_title">FEEDBACK</h2>

                <div class="contact-form-right light-bg-color">

                    <form action="" method="post">
                        <div class="row">

                            <div class="col-md-12">
                                <h2 class="text-white">Please help us to serve you better by taking a couple of minutes.</h2>
                                <h4 class="mt-1" style="font-weight:900;color:#d33b33;">How satisfied were you with our services?</h4>

                                <input type="radio" id="excellent" name="fav_satisfied" value="Excellent">
                                <label for="excellent" style="color:white; font-size:18px;">Excellent</label><br>
                                <input type="radio" id="good" name="fav_satisfied" value="Good">
                                <label for="good" style="color:white; font-size:18px;">Good</label><br>
                                <input type="radio" id="neutral" name="fav_satisfied" value="Neutral">
                                <label for="neutral" style="color:white; font-size:18px;">Neutral</label><br>
                                <input type="radio" id="poor" name="fav_satisfied" value="Poor">
                                <label for="poor" style="color:white; font-size:18px;">Poor</label>

                            </div>

                            <div class="col-md-12">

                                <h4 class="mt-1" style="font-weight:900;color:#d33b33;">if you have specific feedback, please write to us...</h4>

                                <div class="form-group mb-0 mb-1">
                                    <textarea required class="form-control input-light-bg-color" id="message" name="visitor_message"
                                              placeholder="Additional Comments" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <input type="text" style="width:100%;" class="form-control input-light-bg-color" id="name" name="visitor_name"
                                           placeholder="Your Name (optional)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <input type="text" style="width:100%;" placeholder="Your Email (optional)" id="email" class="form-control input-light-bg-color"
                                           name="visitor_email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <input type="text" style="width:100%;" class="form-control input-light-bg-color" id="number" name="visitor_number"
                                           placeholder="Your Number (optional)">
                                </div>
                            </div>
                      
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-10">
                                <div class="submit-button text-center">
                                    <button class="btn hvr-hover" name="form_contact" id="submit" type="submit">SUBMIT
                                        FEEDBACK</button>
                                    <div id="msgSubmit" class="h3 text-center hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-1">

                                <span onclick="redirect_url('payment_success.php')" class="cursor-pointer" style="font-size:20px;color:white;padding-top:50px;position:absolute;padding-left:25px;"><i><u>SKIP</u></i></span>


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
