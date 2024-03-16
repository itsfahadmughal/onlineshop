<?php require_once('header.php'); ?>


<?php
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

$error_message = '';
$success_message = '';
$cstatus=0;
$cpercentage =0;
if (isset($_POST['coupon'])) {
    if (!empty($_POST['couponcode'])) {
        $stmt_coupon = $pdo->prepare("SELECT * FROM tbl_coupons where coupon_code=?");
        $stmt_coupon->execute(array(trim($_POST['couponcode'])));
        $result_coupon = $stmt_coupon->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result_coupon as $c) {
            $coupon_status = $c['cstatus'];
            $coupon_percentage = $c['discount_percentage'];
        }
    
        if ($stmt_coupon->RowCount() == 0) {
            $coupon_error = "No coupon found";
        } elseif ($coupon_status==0) {
            $coupon_error = "Coupon has expired";
        } else {
            $coupon_success = "Coupon Applied Successfully";
            $_SESSION['coupon'] = $coupon_percentage;
            $cstatus = $coupon_status;
            $cpercentage = $coupon_percentage;
        }
    } else {
        $coupon_error = "Enter Coupon Code";
    }
}


if(isset($_SESSION['customer'])){
    $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
    $statement->execute(array($_SESSION['customer']['cust_country']));
    $total = $statement->rowCount();
    if($total) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $shipping_cost = $row['amount'];
        }
    } else {
        $shipping_cost = 0;
    }
}else{
     $shipping_cost = 0;
}

if (isset($_POST['form1'])) {
    $i = 0;
    $statement = $pdo->prepare("SELECT * FROM tbl_product");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $i++;
        $table_product_id[$i] = $row['p_id'];
        $table_quantity[$i] = $row['p_qty'];
    }

    $i=0;
    foreach ($_POST['product_id'] as $val) {
        $i++;
        $arr1[$i] = $val;
    }
    $i=0;
    foreach ($_POST['quantity'] as $val) {
        $i++;
        $arr2[$i] = $val;
    }
    $i=0;
    foreach ($_POST['product_name'] as $val) {
        $i++;
        $arr3[$i] = $val;
    }
    
    $allow_update = 1;
    for ($i=1;$i<=count($arr1);$i++) {
        for ($j=1;$j<=count($table_product_id);$j++) {
            if ($arr1[$i] == $table_product_id[$j]) {
                $temp_index = $j;
                break;
            }
        }
        if ($table_quantity[$temp_index] < $arr2[$i]) {
            $allow_update = 0;
            $error_message .= '"'.$arr2[$i].'" items are not available for "'.$arr3[$i].'"\n';
        } else {
            $_SESSION['cart_p_qty'][$i] = $arr2[$i];
        }
    }
    $error_message .= '\nOther items quantity are updated successfully!'; ?>

<?php if ($allow_update == 0){ ?>
<script>
    alert('<?php echo $error_message; ?>');
</script>
<?php }else{ 
        $success_message = "All Items Quantity Update is Successful!";
} ?>
<?php
}
?>

<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Cart</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active">Cart</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->

<!-- Start Cart  -->
<div class="cart-box-main">
    <div class="container">
        <?php if (!isset($_SESSION['cart_p_id'])): ?>
        <?php echo 'Cart is empty'; ?>
        <?php else: ?>
        <form action="" method="post">
            <?php $csrf->echoInputField(); ?>
            <?php if(isset($success_message) && $success_message!=''){ ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success_message; ?>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Measurement</th>
                                    <th>Tailor Charges</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
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
                                        <a href="shop.php?id=<?php echo $arr_cart_p_id[$i]; ?>&type=sub">
                                            <!-- <img class="img-fluid" src="images\mask5.jpg" alt="" /> -->
                                            <img class="img-fluid"
                                                src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>"
                                                alt="">
                                        </a>
                                    </td>
                                    <td width="20%" class="name-pr">
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
                                    <td>
                                        <input type="hidden" name="product_id[]"
                                            value="<?php echo $arr_cart_p_id[$i]; ?>">
                                        <input type="hidden" name="product_name[]"
                                            value="<?php echo $arr_cart_p_name[$i]; ?>">
                                        <input type="number" style="width:50px;" class="input-text qty text" step="1"
                                            min="1" max="" name="quantity[]"
                                            value="<?php echo $arr_cart_p_qty[$i]; ?>"
                                            title="Qty" size="4" pattern="[0-9]*" inputmode="numeric">
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
                                                if(!empty($arr_cart_p_design_pic[$i])){
                                        ?>
                                                    <img class="img-fluid" src="assets/uploads/<?php echo $arr_cart_p_design_pic[$i]; ?>">
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
                                    <td class="text-center">
                                        <a onclick="return confirmDelete();"
                                            href="cart-item-delete.php?id=<?php echo $arr_cart_p_id[$i]; ?>&size=<?php echo $arr_cart_size_id[$i]; ?>&color=<?php echo $arr_cart_color_id[$i]; ?>"
                                            class="trash"><i class="fa fa-trash"></i></a>
                                    </td>
                                    <!-- <td class="remove-pr">
                                                <a href="#">
                                            <i class="fas fa-times"></i>
                                        </a>
                                            </td> -->
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="update-box">
                        <div class="col-12 d-flex shopping-box" style="width:410px;float:right;">
                            <input type="submit" class="ml-auto btn hvr-hover" value="Update Cart" type="submit"
                                name="form1">
                            <a href="shop.php?type=all" class="ml-auto btn hvr-hover">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row my-5">
            <div class="col-lg-6 col-sm-6">
                <div class="coupon-box">
                    <div class="input-group input-group-sm">
                        <form action="" method="post">
                            <?php $csrf->echoInputField(); ?>
                            <input class="form-control w-100" placeholder="Enter your coupon code"
                                aria-label="Coupon code" name="couponcode" type="text">
                            <?php
                                                if (isset($coupon_error)) {
                                                    echo '<span style="color:red;">'.$coupon_error.'</span>';
                                                }
                                                if (isset($coupon_success)) {
                                                    echo '<span style="color:green;">'.$coupon_success.'</span>';
                                                }
                                            ?>
                            <div class="input-group-append">
                                <button class="btn btn-theme w-100" style="height:50px;" type="submit"
                                    name="coupon">Apply Coupon</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-lg-8 col-sm-12"></div>
            <div class="col-lg-4 col-sm-12">
                <div class="order-box">
                    <h3>Order summary</h3>
                    <div class="d-flex">
                        <h4>Sub Total</h4>
                        <div class="ml-auto font-weight-bold">Rs. <?php echo $table_total_price; ?>
                        </div>
                    </div>
                    <div class="d-flex">
                        <h4>Discount</h4>
                        <div class="ml-auto font-weight-bold"><?php 
                        if(isset($cstatus)==1){
                                                echo $cpercentage.'%';
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                        </div>
                    </div>
                    
                    <?php if($is_tailor_charges == 'yes') { ?>
                        <hr class="my-1">
                        <div class="d-flex">
                            <h4>Tailor Charges</h4>
                            <div class="ml-auto font-weight-bold"> Rs. 
                                <?php  echo $table_tailor_charges; ?>
                            </div>
                        </div>
                        
                    <?php } ?>
                    
                    <hr class="my-1">
                    <div class="d-flex">
                        <h4>Coupon Discount</h4>
                        <div class="ml-auto font-weight-bold"> Rs. <?php 

                        if(isset($cstatus)==1){
                                                echo round(($table_total_price*$cpercentage)/100);
                                            } else {
                                                echo '0';
                                            }
                                            ?>
                        </div>
                    </div>
                    <div class="d-flex">
                        <h4>Shipping Cost</h4>
                        <div class="ml-auto font-weight-bold"> <?php echo $shipping_cost; ?> </div>
                    </div>
                    <hr>
                    <div class="d-flex gr-total">
                        <h5>Grand Total</h5>
                        <div class="ml-auto h5"> Rs.<?php  
                            if(isset($cstatus)==1){
                                                echo round($table_total_price+$table_tailor_charges+$shipping_cost-(($table_total_price*$cpercentage)/100));
                                            } else {
                                                echo $table_total_price;
                                            }?>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="col-12 d-flex shopping-box"><a href="checkout.php" class="ml-auto btn hvr-hover">Checkout</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<!-- End Cart -->

<?php require_once('footer.php');
