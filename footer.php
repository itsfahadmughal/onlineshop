<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $footer_about = $row['footer_about'];
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $contact_address = $row['contact_address'];
    $website_name = $row['website_name'];
}
?>
<!-- Start Footer  -->
<footer>
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-widget">
                        <h4><?php echo $website_name; ?>
                        </h4>
                        <p><?php echo $footer_about; ?>
                        </p>
                        <ul>
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_social");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                            ?>
                            <?php if (!empty($row['social_url'])) : ?>
                            <li><a href="<?php echo $row['social_url']; ?>"
                                   target="_blank"><i
                                                      class="<?php echo $row['social_icon']; ?>"
                                                      aria-hidden="true"></i></a></li>
                            <?php endif; ?>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-link">
                        <h4>Information</h4>
                        <ul>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="sitemap.php">Our Sitemap</a></li>
                            <li><a href="terms.php">Terms &amp; Conditions</a></li>
                            <li><a href="privacy.php">Privacy Policy</a></li>
                            <li><a href="track-order.php">Delivery Information</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-link-contact">
                        <h4>Contact Us</h4>
                        <ul>
                            <li>
                                <p><i class="fas fa-map-marker-alt"></i>Address: <?php echo $contact_address; ?>
                                </p>
                            </li>
                            <li>
                                <p><i class="fas fa-phone-square"></i>Phone: <a
                                                                                href="tel:<?php echo $contact_phone; ?>"><?php echo $contact_phone; ?></a>
                                </p>
                            </li>
                            <li>
                                <p><i class="fas fa-envelope"></i>Email: <a
                                                                            href="mailto:<?php echo $contact_email; ?>"><?php echo $contact_email; ?></a>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer  -->

<!-- Start copyright  -->
<div class="footer-copyright">
    <p class="footer-company">All Rights Reserved. &copy; 2022 <a href="about.html"><?php echo $website_name; ?></a> Design By
        : Maira</a></p>
</div>
<!-- End copyright  -->

<a href="https://wa.me/+923028863134" target="_blank" id="back-to-top" title="Back to top"><img src="assets/images/icon_whatsapp.png" width="60" /></a>

<!-- ALL JS FILES -->
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<!-- ALL PLUGINS -->
<script src="assets/js/jquery.superslides.min.js"></script>
<script src="assets/js/bootstrap-select.js"></script>
<script src="assets/js/inewsticker.js"></script>
<script src="assets/js/bootsnav.js."></script>
<script src="assets/js/images-loded.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/baguetteBox.min.js"></script>
<script src="assets/js/form-validator.min.js"></script>
<script src="assets/js/contact-form-script.js"></script>
<script src="assets/js/custom.js"></script>
<script>

    function redirect_url(url){
        window.location.href = url;
    }
    function redirect_url_blank(url){
        window.open(url, '_blank');
    }

    function confirmDelete() {
        return confirm("Do you sure want to delete this data?");
    }

    $(document).ready(function() {

        $('#stripe_form').hide();
        $('#cash_on_delivery').hide();
        $('#submit_button').hide();

        $('#paymentmethod').on('change', function() {
            paymentmethod = $('#paymentmethod').val();
            if (paymentmethod == '') {
                $('#stripe_form').hide();
                $('#cash_on_delivery').hide();
                $('#submit_button').hide();
                $("#orderpayment").val("");
            }

            if ($.trim(paymentmethod) == 'Stripe') {
                $('#stripe_form').show();
                $('#cash_on_delivery').hide();
                $('#submit_button').show();
                $("#orderpayment").val("Stripe");
            }

            if ($.trim(paymentmethod) == 'COD') {
                $('#stripe_form').hide();
                $('#submit_button').show();
                $('#cash_on_delivery').show();
                $("#orderpayment").val("COD");
            }
        });


        // Validate Username
        $('#card_error').hide();
        let cardnoError = true;
        // $('#card_number').keyup(function() {
        //     validateCardno();
        // });

        function validateCardno() {
            let cardnoValue = $('#card_number').val();
            if (cardnoValue.length == '') {
                $('#card_error').show();
                $('#card_error').html("Enter Card Number");
                cardnoError = false;
                return false;
            } else if ((cardnoValue.length < 14) || (cardnoValue.length > 16)) {
                $('#card_error').show();
                $('#card_error').html("Card number must be<br> between 13 and 16");
                cardnoError = false;
                return false;
            } else {
                $('#card_error').hide();
            }
        }

        $('#cvv_error').hide();
        let cvvError = true;
        // $('#card_cvv').keyup(function() {
        //     validateCVV();
        // });

        function validateCVV() {
            let cvvValue = $('#card_cvv').val();
            if (cvvValue.length == '') {
                $('#cvv_error').show();
                $('#cvv_error').html("Enter CVV number");
                cvvError = false;
                return false;
            } else if (cvvValue.length != 3) {
                $('#cvv_error').show();
                $('#cvv_error').html("Enter valid CVV number");
                cvvError = false;
                return false;
            } else {
                $('#cvv_error').hide();
            }
        }

        $('#month_error').hide();
        let monthError = true;
        // $('#card_month').keyup(function() {
        //     validateMonth();
        // });

        function validateMonth() {
            let monthValue = $('#card_month').val();
            if (monthValue.length == '') {
                $('#month_error').show();
                $('#month_error').html("Enter month");
                monthError = false;
                return false;
            } else if (monthValue.length != 2) {
                $('#month_error').show();
                $('#month_error').html("Enter Valid 2 digit month");
                monthError = false;
                return false;
            } else {
                $('#month_error').hide();
            }
        }

        $('#year_error').hide();
        let yearError = true;
        let current_year = new Date().getFullYear();
        // $('#card_year').keyup(function() {
        //     validateYear();
        // });

        function validateYear() {
            let yearValue = $('#card_year').val();
            if (yearValue.length == '') {
                $('#year_error').show();
                $('#year_error').html("Enter Year");
                yearError = false;
                return false;
            } else if (yearValue < current_year) {
                $('#year_error').show();
                $('#year_error').html("Year cannot be less <br>than current year");
                yearError = false;
                return false;
            } else if (yearValue.length > 2030) {
                $('#year_error').show();
                $('#year_error').html("Enter valid year");
                yearError = false;
                return false;
            } else {
                $('#year_error').hide();
            }
        }

        // Submit button
        $('#paynow').click(function() {

            let payment_method = $("#orderpayment").val();
            if (payment_method == "Stripe") {
                validateCardno();
                validateCVV();
                validateMonth();
                validateYear();
                if ((cardnoError == true) &&
                    (cvvError == true) &&
                    (monthError == true) &&
                    (yearError == true)) {
                    return true;
                } else {
                    return false;
                }
            } else if (payment_method == "Stripe") {
                return true;
            }
        });
    });

    // function card_payment_validation() {
    //     // Get the value of the input field with id="numb"
    //     let card_number = document.getElementById("card_number").value;
    //     let card_cvv = document.getElementById("card_cvv").value;
    //     let card_month = document.getElementById("card_month").value;
    //     let card_year = document.getElementById("card_year").value;
    //     let current_year = new Date().getFullYear();

    //     // If x is Not a Number or less than one or greater than 10
    //     let cardno_error, cvv_error, month_error, year_error;

    //     if (isNaN(card_number) || card_number != 16) {
    //         cardno_error = "Enter 16 digit card number";
    //         document.getElementById("cardno_error").innerHTML = cardno_error;
    //         return false;
    //     }

    //     if (isNaN(card_cvv) || card_cvv != 3) {
    //         cvv_error = "Enter 3 digit CVV";
    //         document.getElementById("cvv_error").innerHTML = cvv_error;
    //         return false;
    //     }

    //     if (isNaN(card_month) || card_month != 2) {
    //         month_error = "Enter 2 digit month";
    //         document.getElementById("month_error").innerHTML = month_error;
    //         return false;
    //     }

    //     if (isNaN(card_year) || card_year != 4) {
    //         year_error = "Enter 4 digit year";
    //         document.getElementById("year_error").innerHTML = year_error;
    //         return false;
    //     } else if (card_year <= current_year) {
    //         year_error = "Enter correct year";
    //         document.getElementById("year_error").innerHTML = year_error;
    //         return false;
    //     }

    //     return true;

    // }



    // $(document).on('submit', '#stripe_form', function() {
    //     // createToken returns immediately - the supplied callback submits the form if there are no errors
    //     $('#submit-button').prop("disabled", true);
    //     $("#msg-container").hide();
    //     Stripe.card.createToken({
    //         number: $('.card-number').val(),
    //         cvc: $('.card-cvc').val(),
    //         exp_month: $('.card-expiry-month').val(),
    //         exp_year: $('.card-expiry-year').val()
    //     }, stripeResponseHandler);
    //     return false;
    // });
    // Stripe.setPublishableKey('<?php //echo $stripe_public_key;?>');

    // function stripeResponseHandler(status, response) {
    //     if (response.error) {
    //         $('#submit-button').prop("disabled", false);
    //         $("#msg-container").html(
    //             '<div style="color: red;border: 1px solid;margin: 10px 0px;padding: 5px;"><strong>Error:</strong> ' +
    //             response.error.message + '</div>');
    //         $("#msg-container").show();
    //     } else {
    //         var form$ = $("#stripe_form");
    //         var token = response['id'];
    //         form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
    //         form$.get(0).submit();
    //     }
    // }
</script>
</body>

</html>