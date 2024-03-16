<?php require_once('header.php'); ?>

<?php

if (!isset($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit;
}

if (isset($_SESSION['customer'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
    $statement->execute(array($_SESSION['customer']['cust_country']));
    $total = $statement->rowCount();
    if ($total) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $shipping_cost = $row['amount'];
        }
    } else {
        $shipping_cost = 0;
    }
} else {
    $shipping_cost = 0;
}

$error_message = '';
$card_error = '';
$cvv_error = '';
$month_error = '';
$year_error = '';


if (isset($_POST['paynow'])) {
    // $valid = 1;

    // if (empty($_POST['card_number'])) {
    //     $valid = 0;
    //     $card_error = "Enter Card Number <br>";
    // } else {
    //     if (strlen($_POST['card_number'] < 13) || strlen($_POST['card_number'] < 13)) {
    //         $valid = 0;
    //         $card_error = "Enter Valid Card Number <br>";
    //     } else {
    //         $cardno = $_POST['card_number'];
    //     }
    // }

    // if (empty($_POST['card_cvv'])) {
    //     $valid = 0;
    //     $cvv_error = "Enter CVV <br>";
    // } else {
    //     if (strlen($_POST['card_cvv'] < 3)) {
    //         $valid = 0;
    //         $cvv_error = "Enter Valid CVV <br>";
    //     } else {
    //         $cvv_error = $_POST['card_cvv'];
    //     }
    // }

    // if (empty($_POST['card_month'])) {
    //     $valid = 0;
    //     $month_error = "Enter Month <br>";
    // } else {
    //     if ($_POST['card_month'] == 0) {
    //         $valid = 0;
    //         $month_error = "Enter Valid Month <br>";
    //     } else {
    //         $month_error = $_POST['card_month'];
    //     }
    // }


    // if (empty($_POST['card_year'])) {
    //     $valid = 0;
    //     $year_error = "Enter Year <br>";
    // } else {
    //     if ($_POST['card_year'] == 0) {
    //         $valid = 0;
    //         $year_error = "Enter Valid Month <br>";
    //     } else {
    //         $year_error = $_POST['card_year'];
    //     }
    // }


    // if ($valid == 1 && $_POST['orderpayment']=='Stripe') {
    $payment_date = date('Y-m-d H:i:s');
    $payment_id = time();
    $amount = floatval($_POST['amount']);
    $transaction_id = mt_rand(111111111, $payment_id+999999999);
    $transaction_status = 'Completed';
    $order_no = rand(1111111111, $transaction_id);
    if ($_POST['orderpayment']=='Stripe') {
        $payment_method = 'Credit Card';
        $card_no = $_POST['card_number'];
        $card_cvv = $_POST['card_cvv'];
        $card_month = $_POST['card_month'];
        $card_year = $_POST['card_year'];
    } elseif ($_POST['orderpayment']=='COD') {
        $payment_method = 'Cash On Delivery';
        $card_no = '';
        $card_cvv = '';
        $card_month = '';
        $card_year = '';
    }


    try {
        $statement = $pdo->prepare("INSERT INTO tbl_payment (   
            customer_id,
            order_id,
            payment_date,
            txnid, 
            paid_amount,
            card_number,
            card_cvv,
            card_month,
            card_year,
            bank_transaction_info,
            payment_method,
            payment_status,
            shipping_status,
            payment_id
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
            $_SESSION['customer']['cust_id'],
            $order_no,
            $payment_date,
            $transaction_id,
            $_POST['amount'],
            $card_no,
            $card_cvv,
            $card_month,
            $card_year,
            '',
            $payment_method,
            'Pending',
            'Pending',
            $payment_id
        ));
    } catch (PDOException $e) {
        //Do your error handling here
        $message = $e->getMessage();
        echo '<script type="text/javascript">alert(Error:'.$message.')</script>';
    }

    $i=0;
    foreach ($_SESSION['cart_p_id'] as $key => $value) {
        $i++;
        $arr_cart_p_id[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_name'] as $key => $value) {
        $i++;
        $arr_cart_p_name[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_size_name'] as $key => $value) {
        $i++;
        $arr_cart_size_name[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_color_name'] as $key => $value) {
        $i++;
        $arr_cart_color_name[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_qty'] as $key => $value) {
        $i++;
        $arr_cart_p_qty[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_current_price'] as $key => $value) {
        $i++;
        $arr_cart_p_current_price[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_type'] as $key => $value) {
        $i++;
        $arr_cart_p_type[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_featured_photo'] as $key => $value) {
        $i++;
        $arr_cart_p_featured_photo[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_shoulders'] as $key => $value) {
        $i++;
        $arr_cart_p_shoulders[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_dartpoint'] as $key => $value) {
        $i++;
        $arr_cart_p_dartpoint[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_chestlength'] as $key => $value) {
        $i++;
        $arr_cart_p_chestlength[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_chest'] as $key => $value) {
        $i++;
        $arr_cart_p_chest[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_waist'] as $key => $value) {
        $i++;
        $arr_cart_p_waist[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_shirtlength'] as $key => $value) {
        $i++;
        $arr_cart_p_shirtlength[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_hip'] as $key => $value) {
        $i++;
        $arr_cart_p_hip[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_armhole'] as $key => $value) {
        $i++;
        $arr_cart_p_armhole[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_thigh'] as $key => $value) {
        $i++;
        $arr_cart_p_thigh[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_knee'] as $key => $value) {
        $i++;
        $arr_cart_p_knee[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_calf'] as $key => $value) {
        $i++;
        $arr_cart_p_calf[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_pantlength'] as $key => $value) {
        $i++;
        $arr_cart_p_pantlength[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_pantwaist'] as $key => $value) {
        $i++;
        $arr_cart_p_pantwaist[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_tailor_charges'] as $key => $value) {
        $i++;
        $arr_cart_p_tailor_charges[$i] = $value;
    }

    $i=0;
    foreach ($_SESSION['cart_p_design_pic'] as $key => $value) {
        $i++;
        $arr_cart_p_design_pic[$i] = $value;
    }

    $stmt_order = $pdo->prepare("INSERT INTO tbl_order (
                            order_id,
                            customer_id,
                            order_amount, 
                            payment_id,
                            order_status
                            ) 
                            VALUES (?,?,?,?,?)");
    $sql_order = $stmt_order->execute(array(
        $order_no,
        $_SESSION['customer']['cust_id'],
        $amount,
        $payment_id,
        'Pending'
    ));

    for ($i=1;$i<=count($arr_cart_p_id);$i++) {
        $stmt_order_details = $pdo->prepare("INSERT INTO tbl_order_details (
                order_id,
                p_id,
                p_name,
                size, 
                color,
                quantity, 
                unit_price, 
                p_type,
                shoulders,
                dart_point,
                chest_length,
                chest,
                waist,
                shirt_length,
                hip,
                arm_hole,
                thigh,
                knee,
                calf,
                pant_length,
                pant_waist,
                tailor_charges,
                design_pic
                ) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $sql_order_details = $stmt_order_details->execute(array(
            $order_no,
            $arr_cart_p_id[$i],
            $arr_cart_p_name[$i],
            $arr_cart_size_name[$i],
            $arr_cart_color_name[$i],
            $arr_cart_p_qty[$i],
            $arr_cart_p_current_price[$i],
            $arr_cart_p_type[$i],
            $arr_cart_p_shoulders[$i],
            $arr_cart_p_dartpoint[$i],
            $arr_cart_p_chestlength[$i],
            $arr_cart_p_chest[$i],
            $arr_cart_p_waist[$i],
            $arr_cart_p_shirtlength[$i],
            $arr_cart_p_hip[$i],
            $arr_cart_p_armhole[$i],
            $arr_cart_p_thigh[$i],
            $arr_cart_p_knee[$i],
            $arr_cart_p_calf[$i],
            $arr_cart_p_pantlength[$i],
            $arr_cart_p_pantwaist[$i],
            $arr_cart_p_tailor_charges[$i],
            $arr_cart_p_design_pic[$i]
        ));
    }


    for ($c=1;$c<=count($arr_cart_p_id);$c++) {
        $stmt_qty_sel = $pdo->prepare("SELECT * FROM tbl_product where p_id=?");
        $stmt_qty_sel->execute(array($arr_cart_p_id[$c]));
        $result_qty_sel = $stmt_qty_sel->fetchAll(PDO::FETCH_ASSOC);

        $final_quantity = $result_qty_sel[0]['p_qty'] - $arr_cart_p_qty[$c];
        $stmt_upd_qty = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
        $stmt_upd_qty->execute(array($final_quantity,$arr_cart_p_id[$c]));
    }



    try {
        $emailhtml = "";
        $emailhtml .= "<table width='100%'>";
        $emailhtml .= "<tbody>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td colspan='4'>New order inquiry form submitted. detail is given below : </td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td width='25%'><b>Customer Name</b></td>";
        $emailhtml .= "<td width='25%'>" . $_SESSION['customer']['cust_name'] . "</td>";
        $emailhtml .= "<td width='25%'><b>Date</b></td>";
        $emailhtml .= "<td width='25%'>" . $payment_date . "</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td width='25%'><b>Email</b></td>";
        $emailhtml .= "<td width='25%'>" . $_SESSION['customer']['cust_email'] . "</td>";
        $emailhtml .= "<td width='25%'><b>Phone</b></td>";
        $emailhtml .= "<td width='25%'>" . $_SESSION['customer']['cust_phone']. "</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td width='25%'><b>City</b></td>";
        $emailhtml .= "<td width='25%'>" . $_SESSION['customer']['cust_s_city'] . "</td>";
        $emailhtml .= "<td width='25%'><b>Address</b></td>";
        $emailhtml .= "<td width='25%'>" . $_SESSION['customer']['cust_s_address'] . "</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td width='25%'><b>Zipcode</b></td>";
        $emailhtml .= "<td width='25%'>" . $_SESSION['customer']['cust_s_zipcode'] . "</td>";
        $emailhtml .= "<td width='25%'><b>Country</b></td>";
        $emailhtml .= "<td width='25%'>" . getcountryname($_SESSION['customer']['cust_s_country']) . "</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td colspan='4'>&nbsp;</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td colspan='4'>&nbsp;</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td width='100%' colspan='4'>";
        $emailhtml .= "<table width='100%' style='text-align:center;'>";
        $emailhtml .= "<thead>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<th style='text-align:center;'>Product id</th>";
        $emailhtml .= "<th style='text-align:center;'>Product name</th>";
        // $emailhtml .= "<th style='text-align:center;'>Product Image</th>";
        $emailhtml .= "<th style='text-align:center;'>Size</th>";
        $emailhtml .= "<th style='text-align:center;'>Color</th>";
        $emailhtml .= "<th style='text-align:center;'>Quantity</th>";
        $emailhtml .= "<th style='text-align:center;'>Price</th>";
        $emailhtml .= "<th style='text-align:center;'>Product Type</th>";
        $emailhtml .= "<th style='text-align:center;'>Shoulders</th>";
        $emailhtml .= "<th style='text-align:center;'>Dart Point</th>";
        $emailhtml .= "<th style='text-align:center;'>Chest Length</th>";
        $emailhtml .= "<th style='text-align:center;'>Chest</th>";
        $emailhtml .= "<th style='text-align:center;'>Waist</th>";
        $emailhtml .= "<th style='text-align:center;'>Shirst_length</th>";
        $emailhtml .= "<th style='text-align:center;'>Hip</th>";
        $emailhtml .= "<th style='text-align:center;'>Arm Hole</th>";
        $emailhtml .= "<th style='text-align:center;'>Thigh</th>";
        $emailhtml .= "<th style='text-align:center;'>Knee</th>";
        $emailhtml .= "<th style='text-align:center;'>Calf</th>";
        $emailhtml .= "<th style='text-align:center;'>Pant Length</th>";
        $emailhtml .= "<th style='text-align:center;'>Pant Waist</th>";
        $emailhtml .= "<th style='text-align:center;'>Tailor Charges</th>";
        $emailhtml .= "<th style='text-align:center;'>Desing Pic</th>";
        $emailhtml .= "</tr>";
        $emailhtml .= "</thead>";
        $emailhtml .= "<tbody>";

        $table_total_price = 0;
        $pimg = array();
        for ($k=1;$k<=count($arr_cart_p_id);$k++) {
            $emailhtml .= "<tr>";
            $emailhtml .= "<td>" . $arr_cart_p_id[$k] . "</td>";
            $emailhtml .= "<td>" . $arr_cart_p_name[$k] . "</td>";
            $pimg = explode(".", $arr_cart_p_featured_photo[$k]);
            // $emailhtml .= "<td><img src=cid:'" . $pimg[0] . "' width='80'></td>";
            $emailhtml .= "<td>" . $arr_cart_size_name[$k] . "</td>";
            $emailhtml .= "<td>" . $arr_cart_color_name[$k] . "</td>";
            $emailhtml .= "<td>" . $arr_cart_p_qty[$k] . "</td>";
            $emailhtml .= "<td>" . $arr_cart_p_current_price[$k] . "</td>";
            $emailhtml .= "<td>" .  $arr_cart_p_type[$k] . "</td>";
            if ($arr_cart_p_type[$k]=='customize') {
                $emailhtml .= "<td>" . $arr_cart_p_shoulders[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_dartpoint[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_chestlength[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_chest[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_waist[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_shirlength[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_hip[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_armhole[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_thigh[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_knee[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_calf[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_pantlength[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_pantwaist[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_tailor_charges[$k] . "</td>";
                $emailhtml .= "<td>" . $arr_cart_p_design_pic[$k] . "</td>";
            } else {
                $emailhtml .= "<td colspan='15'></td>";
            }
            $emailhtml .= "</tr>";

            $row_total_price = $arr_cart_p_current_price[$k]*$arr_cart_p_qty[$k];
            $table_total_price = $table_total_price + $row_total_price;
        }

        if (isset($_SESSION['coupon'])) {
            $discount = round($table_total_price-(($table_total_price*$coupon_percentage)/100));
        } else {
            $discount = 0;
        }

        $emailhtml .= "<tr>";
        $emailhtml .= "<td colspan='20'>&nbsp;</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td colspan='20'>&nbsp;</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td width='100%' colspan='20'>";
        $emailhtml .= "<table width='100%' style='text-align:center;'>";
        $emailhtml .= "<tbody>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td colspan='19' style='text-align:right;'><strong>Total:</strong></td>";
        $emailhtml .= "<td style='text-align:center;'>".$table_total_price."</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td colspan='19' style='text-align:right;'><strong>Discount:</strong></td>";
        $emailhtml .= "<td style='text-align:center;'>".$discount."</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<tr>";
        $emailhtml .= "<td colspan='19' style='text-align:right;'><strong>Shipping Cost:</strong></td>";
        $emailhtml .= "<td style='text-align:center;'>".$shipping_cost."</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "<td colspan='19' style='text-align:right;'><strong>Grand Total:</strong></td>";
        $emailhtml .= "<td style='text-align:center;'>".round($table_total_price+$shipping_cost-(($table_total_price*$_SESSION['coupon'])/100))."</td>";
        $emailhtml .= "<tr>";
        $emailhtml .= "</tbody>";
        $emailhtml .= "</table>";
        $emailhtml .= "</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "</tbody>";
        $emailhtml .= "</table>";
        $emailhtml .= "</td>";
        $emailhtml .= "</tr>";
        $emailhtml .= "</tbody>";
        $emailhtml .= "</table>";

        try {
            $mail->isSMTP();                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;               // Enable SMTP authentication
            $mail->Username = 'clothingbrandhf@gmail.com';   // SMTP username
            $mail->Password = 'pzzueueibayegyhf';   // SMTP password
            $mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                    // TCP port to connect to

            $mail->setFrom('clothingbrandhf@gmail.com', 'HF Clothing');
            $mail->addAddress($_SESSION['customer']['cust_email'], $_SESSION['customer']['cust_name']);
            $mail->addReplyTo('clothingbrandhf@gmail.com', 'HF Clothing');

            $mail->isHTML(true);
            $mail->Subject = "Order Confirmation";

            // $mail->Body = $emailhtml;
            // for ($ii=1;$ii<=count($arr_cart_p_featured_photo);$ii++) {
            //     $mail->AddEmbeddedImage(BASE_URL.'assets/uploads/'.$arr_cart_p_featured_photo[$jj], $pimg[0]);
            // }
            $mail->send();

            $mail->setFrom($_SESSION['customer']['cust_email'], $_SESSION['customer']['cust_name']);
            $mail->addAddress('clothingbrandhf@gmail.com', 'HF Clothing');
            $mail->addReplyTo($_SESSION['customer']['cust_email'], $_SESSION['customer']['cust_name']);

            $mail->isHTML(true);
            $mail->Subject = "New Order Received";

            // $mail->Body = $emailhtml;
            // for ($jj=1;$jj<=count($arr_cart_p_featured_photo);$jj++) {
            //     $mail->AddEmbeddedImage(BASE_URL.'assets/uploads/'.$arr_cart_p_featured_photo[$jj], $pimg[0]);
            // }

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }


        unset($_SESSION['cart_p_id']);
        unset($_SESSION['cart_size_id']);
        unset($_SESSION['cart_size_name']);
        unset($_SESSION['cart_color_id']);
        unset($_SESSION['cart_color_name']);
        unset($_SESSION['cart_p_qty']);
        unset($_SESSION['cart_p_type']);
        unset($_SESSION['cart_p_current_price']);
        unset($_SESSION['cart_p_name']);
        unset($_SESSION['cart_p_featured_photo']);
        unset($_SESSION['cart_p_shoulders']);
        unset($_SESSION['cart_p_dartpoint']);
        unset($_SESSION['cart_p_chestlength']);
        unset($_SESSION['cart_p_chest']);
        unset($_SESSION['cart_p_waist']);
        unset($_SESSION['cart_p_shirtlength']);
        unset($_SESSION['cart_p_hip']);
        unset($_SESSION['cart_p_armhole']);
        unset($_SESSION['cart_p_thigh']);
        unset($_SESSION['cart_p_knee']);
        unset($_SESSION['cart_p_calf']);
        unset($_SESSION['cart_p_pantlength']);
        unset($_SESSION['cart_p_pantwaist']);
        unset($_SESSION['cart_p_tailor_charges']);
        unset($_SESSION['cart_design_pic']);

        header('location:feedback.php');
    } catch (Exception $e) {
        $error = $e->getMessage(); ?>
<script type="text/javascript">
    alert('Error: <?php echo $error; ?>');
</script><?php
    }
}
?>

<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Checkout</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->

<!-- Start Cart  -->
<div class="cart-box-main">
    <div class="page">
        <div class="container">
            <?php if (!isset($_SESSION['customer'])): ?>
            <div class="row new-account-login">
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="title-left">
                        <h3>Account Login</h3>
                    </div>
                    <h5>
                        <a href="login.php" role="button">
                            Click here to Login
                        </a>
                    </h5>
                </div>
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="title-left">
                        <h3>Create New Account</h3>
                    </div>
                    <h5><a href="registration.php" role="button">
                        Click here to Register</a>
                    </h5>
                </div>
            </div>
            <?php else: ?>
            <div class="row">
                <div class="col-lg-12">
                    <h3
                        style="font-size: 22px;font-weight: 600;padding-bottom: 14px;margin-bottom: 25px;border-bottom: 3px solid #d33b33;">
                        Order Details</h3>
                    <div class="table-main table-responsive cart">
                        <table class="table">
                            <tr>
                                <th style="font-size: 16px;font-weight: 600;color:#000;">Images</th>
                                <th style="font-size: 16px;font-weight: 600;color:#000;">Product Name</th>
                                <th style="font-size: 16px;font-weight: 600;color:#000;">Size</th>
                                <th style="font-size: 16px;font-weight: 600;color:#000;">Color</th>
                                <th style="font-size: 16px;font-weight: 600;color:#000;">Price</th>
                                <th style="font-size: 16px;font-weight: 600;color:#000;">Quantity</th>
                                <th style="font-size: 16px;font-weight: 600;color:#000;">Total</th>
                                <th style="font-size: 16px;font-weight: 600;color:#000;">Measurement</th>
                                <th style="font-size: 16px;font-weight: 600;color:#000;">Tailor Charges</th>
                            </tr>
                            <?php
                            $table_total_price = 0;

                            $i=0;
                            foreach ($_SESSION['cart_p_id'] as $key => $value) {
                                $i++;
                                $arr_cart_p_id[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_size_id'] as $key => $value) {
                                $i++;
                                $arr_cart_size_id[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_size_name'] as $key => $value) {
                                $i++;
                                $arr_cart_size_name[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_color_id'] as $key => $value) {
                                $i++;
                                $arr_cart_color_id[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_color_name'] as $key => $value) {
                                $i++;
                                $arr_cart_color_name[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_qty'] as $key => $value) {
                                $i++;
                                $arr_cart_p_qty[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_current_price'] as $key => $value) {
                                $i++;
                                $arr_cart_p_current_price[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_name'] as $key => $value) {
                                $i++;
                                $arr_cart_p_name[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_featured_photo'] as $key => $value) {
                                $i++;
                                $arr_cart_p_featured_photo[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_shoulders'] as $key => $value) {
                                $i++;
                                $arr_cart_p_shoulders[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_dartpoint'] as $key => $value) {
                                $i++;
                                $arr_cart_p_dartpoint[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_chestlength'] as $key => $value) {
                                $i++;
                                $arr_cart_p_chestlength[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_chest'] as $key => $value) {
                                $i++;
                                $arr_cart_p_chest[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_waist'] as $key => $value) {
                                $i++;
                                $arr_cart_p_waist[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_shirtlength'] as $key => $value) {
                                $i++;
                                $arr_cart_p_shirtlength[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_hip'] as $key => $value) {
                                $i++;
                                $arr_cart_p_hip[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_armhole'] as $key => $value) {
                                $i++;
                                $arr_cart_p_armhole[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_thigh'] as $key => $value) {
                                $i++;
                                $arr_cart_p_thigh[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_knee'] as $key => $value) {
                                $i++;
                                $arr_cart_p_knee[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_calf'] as $key => $value) {
                                $i++;
                                $arr_cart_p_calf[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_pantlength'] as $key => $value) {
                                $i++;
                                $arr_cart_p_pantlength[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_pantwaist'] as $key => $value) {
                                $i++;
                                $arr_cart_p_pantwaist[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_tailor_charges'] as $key => $value) {
                                $i++;
                                $arr_cart_p_tailor_charges[$i] = $value;
                            }

                            $i=0;
                            foreach ($_SESSION['cart_p_design_pic'] as $key => $value) {
                                $i++;
                                $arr_cart_p_design_pic[$i] = $value;
                            }
                            ?>
                            <tbody>
                                <?php
                                $table_tailor_charges = 0;
                                $is_tailor_charges = 'no';
                                for ($i=1;$i<=count($arr_cart_p_id);$i++): ?>
                                <tr>
                            </td>
                            <td class="thumbnail-img">
                                <a href="shop.html">
                                    <!-- <img class="img-fluid" src="images\mask5.jpg" alt="" /> -->
                                    <img class="img-fluid"
                                         src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>"
                                         alt="">
                                </a>
                            </td>
                            <td class="name-pr" width="50%">
                                <a
                                   href="shop.php?id=<?php echo $arr_cart_p_id[$i]; ?>&type=sub"><?php echo $arr_cart_p_name[$i]; ?></a>
                            </td>
                            <td><?php if (empty($arr_cart_size_name[$i])) {
    echo '-';
} else {
    echo $arr_cart_size_name[$i];
}?>
                            </td>
                            <td><?php if (empty($arr_cart_color_name[$i])) {
    echo '-';
} else {
    echo $arr_cart_color_name[$i];
} ?>
                            </td>
                            <td>Rs. <?php echo $arr_cart_p_current_price[$i]; ?>
                            </td>
                            <td><?php echo $arr_cart_p_qty[$i]; ?>
                            </td>
                            <td class="text-right">
                                <?php
                                $row_total_price = $arr_cart_p_current_price[$i]*$arr_cart_p_qty[$i];
                                $table_total_price = $table_total_price + $row_total_price;
                                ?>
                                Rs.<?php echo $row_total_price; ?>
                            </td>
                            <td class="text-left">
                                <?php
                                if (!empty($arr_cart_p_shoulders[$i])) {
                                    echo 'Shoulder: '.$arr_cart_p_shoulders[$i].'<br>';
                                }
                                if (!empty($arr_cart_p_dartpoint[$i])) {
                                    echo 'Dart Point:'.$arr_cart_p_dartpoint[$i].'<br>';
                                }
                                if (!empty($arr_cart_p_chestlength[$i])) {
                                    echo 'Chest Length:'.$arr_cart_p_chestlength[$i].'<br>';
                                }
                                if (!empty($arr_cart_p_chest[$i])) {
                                    echo 'Chest:'.$arr_cart_p_chest[$i].'<br>';
                                }
                                if (!empty($arr_cart_p_waist[$i])) {
                                    echo 'Waist:'.$arr_cart_p_waist[$i].'<br>';
                                }
                                if (!empty($arr_cart_p_shirlength[$i])) {
                                    echo 'Shirt Length:'.$arr_cart_p_shirlength[$i].'<br>';
                                }
                                if (!empty($arr_cart_p_hip[$i])) {
                                    echo 'Hip:'.$arr_cart_p_hip[$i].'<br>';
                                }
                                if (!empty($arr_cart_armhole[$i])) {
                                    echo 'Arm Hole:'.$arr_cart_armhole[$i].'<br>';
                                }
                                if (!empty($arr_cart_p_thigh[$i])) {
                                    echo 'Thigh:'.$arr_cart_p_thigh[$i].'<br>';
                                }
                                if (!empty($arr_cart_p_knee[$i])) {
                                    echo 'Knee:'.$arr_cart_p_knee[$i].'<br>';
                                }
                                if (!empty($arr_cart_p_calf[$i])) {
                                    echo 'Calf:'.$arr_cart_p_calf[$i].'<br>';
                                }
                                if (!empty($arr_cart_p_pantlength[$i])) {
                                    echo 'Pant Length:'.$arr_cart_p_pantlength[$i].'<br>';
                                }
                                if (!empty($arr_cart_p_pantwaist[$i])) {
                                    echo 'Pant Waist:'.$arr_cart_p_pantwaist[$i].'<br>';
                                }
                                ?>
                                <?php
                                if (!empty($arr_cart_p_design_pic[$i])) {
                                ?>
                                <img class="img-fluid"
                                     src="assets/uploads/<?php echo $arr_cart_p_design_pic[$i]; ?>">
                                <?php
                                }
                                ?>
                            </td>
                            <td class="text-left">
                                <?php
                                if (!empty($arr_cart_p_tailor_charges[$i])) {
                                    echo $arr_cart_p_tailor_charges[$i];

                                    $table_tailor_charges = $table_tailor_charges + $arr_cart_p_tailor_charges[$i];

                                    $is_tailor_charges = 'yes';
                                }
                                ?>
                            </td>
                            </tr>
                        <?php endfor; ?>
                        <tr>
                            <th colspan="8" class="total-text text-right">Sub Total</th>
                            <th class="total-amount text-right">Rs. <?php echo $table_total_price; ?>
                            </th>
                        </tr>

                        <tr>
                            <td colspan="8" class="total-text text-right">Shipping Cost
                            </td>
                            <td class="total-amount text-right">Rs.<?php echo $shipping_cost; ?>
                            </td>
                        </tr>
                        <?php if ($is_tailor_charges == 'yes') { ?>
                        <tr>
                            <td colspan="8" class="total-text text-right">Tailor Charges
                            </td>
                            <td class="total-amount text-right">Rs.<?php  echo $table_tailor_charges; ?>
                            </td>
                        </tr>

                        <?php } ?>

                        <tr>
                            <td colspan="8" class="total-text text-right">Total
                            </td>
                            <td class="total-amount text-right">Rs.<?php echo $table_total_price; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8" class="total-text text-right">Discount
                            </td>
                            <td class="total-amount text-right">Rs.<?php if (isset($_SESSION['coupon'])) {
    echo round(($table_total_price*$_SESSION['coupon'])/100);
} else {
    echo '0';
} ?>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="8" class="total-text text-right">Total
                            </th>
                            <th class="total-amount text-right">
                                <?php
                                if (isset($_SESSION['coupon'])) {
                                    $grand_total = round($table_total_price+$table_tailor_charges-(($table_total_price*$_SESSION['coupon'])/100));
                                } else {
                                    $grand_total = round($table_total_price+$table_tailor_charges);
                                }
                                $final_total = $grand_total+$shipping_cost;
                                ?>
                                Rs. <?php echo $final_total; ?>
                            </th>
                        </tr>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="billing-address">
                <div class="row">
                    <div class="col-md-6">
                        <h3
                            style="font-size: 22px;font-weight: 600;padding-bottom: 14px;margin-bottom: 25px;border-bottom: 3px solid #d33b33;">
                            Billing Address</h3>
                        <table class="table table-responsive table-bordered bill-address">
                            <tr>
                                <td
                                    style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                                    Full Name</td>
                                <td style="width: 70%"><?php echo $_SESSION['customer']['cust_b_name']; ?>
                            </p>
                            </td>
                        </tr>
                    <tr>
                        <td
                            style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                            Phone Number</td>
                        <td><?php echo $_SESSION['customer']['cust_b_phone']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                            Country</td>
                        <td>
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                            $statement->execute(array($_SESSION['customer']['cust_b_country']));
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                echo $row['country_name'];
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                            Address</td>
                        <td>
                            <?php echo nl2br($_SESSION['customer']['cust_b_address']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                            City</td>
                        <td><?php echo $_SESSION['customer']['cust_b_city']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                            Zip Code</td>
                        <td><?php echo $_SESSION['customer']['cust_b_zip']; ?>
                        </td>
                    </tr>
                    </table>
            </div>
            <div class="col-md-6">
                <h3
                    style="font-size: 22px;font-weight: 600;padding-bottom: 14px;margin-bottom: 25px;border-bottom: 3px solid #d33b33;">
                    Shipping Address</h3>
                <table class="table table-responsive table-bordered bill-address">
                    <tr>
                        <td
                            style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                            Full Name</td>
                        <td style="width: 70%"><?php echo $_SESSION['customer']['cust_s_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                            Phone Number</td>
                        <td><?php echo $_SESSION['customer']['cust_s_phone']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                            Country</td>
                        <td>
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                            $statement->execute(array($_SESSION['customer']['cust_s_country']));
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                echo $row['country_name'];
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                            Address</td>
                        <td>
                            <?php echo nl2br($_SESSION['customer']['cust_s_address']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                            City</td>
                        <td><?php echo $_SESSION['customer']['cust_s_city']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="color:#000;font-weight:bold;width: 200px;padding: 8px;line-height: 1.42857143;">
                            Zip Code</td>
                        <td><?php echo $_SESSION['customer']['cust_s_zip']; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="clear"></div>
<h3
    style="font-size: 22px;font-weight: 600;padding-bottom: 14px;margin-bottom: 25px;border-bottom: 3px solid #d33b33;">
    Payment Section</h3>
<div class="row">
    <?php
    $checkout_access = 1;
    if (
        ($_SESSION['customer']['cust_b_name']=='') ||
        ($_SESSION['customer']['cust_b_phone']=='') ||
        ($_SESSION['customer']['cust_b_country']=='') ||
        ($_SESSION['customer']['cust_b_address']=='') ||
        ($_SESSION['customer']['cust_b_city']=='') ||
        ($_SESSION['customer']['cust_b_zip']=='') ||
        ($_SESSION['customer']['cust_s_name']=='') ||
        ($_SESSION['customer']['cust_s_phone']=='') ||
        ($_SESSION['customer']['cust_s_country']=='') ||
        ($_SESSION['customer']['cust_s_address']=='') ||
        ($_SESSION['customer']['cust_s_city']=='') ||
        ($_SESSION['customer']['cust_s_zip']=='')
    ) {
        $checkout_access = 0;
    }
    ?>
    <?php if ($checkout_access == 0): ?>
    <div class="col-md-12">
        <div style="color:red;font-size:22px;margin-bottom:50px;">
            You must have to fill up all the billing and shipping information from your dashboard panel
            in order to checkout the order. Please fill up the information going to <a
                                                                                       href="customer-billing-shipping-update.php"
                                                                                       style="color:red;text-decoration:underline;"><u></u>this link</u></a>.
    </div>
</div>
<?php else: ?>
<div class="col-md-6">
    <div class="row">
        <div class="col-md-8 form-group">
            <label style="font-size: 16px;color:#000;"><strong>Select Payment Method *</strong></label>
            <select name="payment_method" class="form-control select2" id="paymentmethod">
                <option value="">Select a Method</option>
                <option value="Stripe">Credit Card</option>
                <option value="COD">Cash On Delivery</option>
            </select>
        </div>
        <div class="col-md-2 form-group" style="vertical-align: bottom;">
            <a href="cart.php" class="ml-auto btn hvr-hover">Go to Cart</a>
        </div>
        <div class="col-md-2 form-group">
            <a style="margin-left:3px!important;vertical-align: bottom;" href="shop.php?type=all"
               class="ml-auto btn hvr-hover">Continue
                Shopping</a>
        </div>
        <div class="col-md-12 ">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="table-main table-responsive" style="margin-left:15px;width:90%!important;">
                    <input type="hidden" name="payment" value="posted">
                    <input type="hidden" name="orderpayment" id="orderpayment" value="">
                    <input type="hidden" name="amount"
                           value="<?php echo $final_total; ?>">
                    <table>
                        <tbody>
                            <tr id="stripe_form">
                                <td>
                                    <table class="table">
                                        <tr>
                                            <td><strong>Card Number *<strong></td>
                                                <td><input
                                                           style="width: 100%!important;height:30px!important;padding: 0px 5px!important;"
                                                           type="number" name="card_number" id="card_number"
                                                           class="form-control card-number">
                                                    <span id="card_error" style="color:red;"></span>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>CVV *<strong></td>
                                                        <td><input
                                                                   style="width: 100%!important;height:30px!important;padding: 0px 5px!important;"
                                                                   type="number" name="card_cvv" id="card_cvv"
                                                                   class="form-control card-cvc">
                                                            <span id="cvv_error" style="color:red;"></span>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Month *<strong></td>
                                                                <td><input
                                                                           style="width: 100%!important;height:30px!important;padding: 0px 5px!important;"
                                                                           type="number" name="card_month" min="1" max="12"
                                                                           id="card_month"
                                                                           class="form-control card-expiry-month">
                                                                    <span id="month_error" style="color:red;"></span>
                                                                </td>

                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Year *<strong></td>
                                                                        <td><input
                                                                                   style="width: 100%!important;height:30px!important;padding: 0px 5px!important;"
                                                                                   type="number" name="card_year" min="2022" max="2030"
                                                                                   id="card_year"
                                                                                   class="form-control card-expiry-year">
                                                                            <span id="year_error" style="color:red;"></span>
                                                                        </td>
                                                                        </tr>
                                    </table>
                                                            </td>
                                                        </tr>
                                                        <tr id="cash_on_delivery">
                                                            <td>
                                                                <table class="table">
                                                                    <tr>
                                                                        <td><strong>Payment Method:<strong></td>
                                                                            <td>Cash on Delivery</td>
                                                                            </tr>
                                                                </table>
                                                                    </td>
                                                        </tr>
                                                        <tr id="submit_button">
                                                            <td colspan="2">
                                                                <input type="submit" class="btn btn-primary" value="Pay Now"
                                                                       name="paynow" id="paynow">
                                                                <div id="msg-container"></div>
                                                            </td>
                                                        </tr>
                                        </tbody>
                                    </table>
                                        </div>
                        </form>

                        </div>

                </div>
                </div>
            <?php endif; ?>
        </div>

        <?php endif; ?>
    </div>
</div>
</div>
<div style="margin-bottom:50px;"></div>
<!-- End Cart -->
<?php require_once('footer.php');
