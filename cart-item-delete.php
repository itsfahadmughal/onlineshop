<?php require_once('header.php'); ?>

<?php

// Check if the product is valid or not
if( !isset($_REQUEST['id']) || !isset($_REQUEST['size']) || !isset($_REQUEST['color'])  ) {
    header('location: cart.php');
    exit;
}

$i=0;
foreach($_SESSION['cart_p_id'] as $key => $value) {
    $i++;
    $arr_cart_p_id[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_size_id'] as $key => $value) {
    $i++;
    $arr_cart_size_id[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_size_name'] as $key => $value) {
    $i++;
    $arr_cart_size_name[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_color_id'] as $key => $value) {
    $i++;
    $arr_cart_color_id[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_color_name'] as $key => $value) {
    $i++;
    $arr_cart_color_name[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_p_qty'] as $key => $value) {
    $i++;
    $arr_cart_p_qty[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_p_current_price'] as $key => $value) {
    $i++;
    $arr_cart_p_current_price[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_p_name'] as $key => $value) {
    $i++;
    $arr_cart_p_name[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_p_featured_photo'] as $key => $value) {
    $i++;
    $arr_cart_p_featured_photo[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_design_pic'] as $key => $value) {
    $i++;
    $arr_cart_design_pic[$i] = $value;
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
unset($_SESSION['cart_p_design_pic']);


$k=1;
for($i=1;$i<=count($arr_cart_p_id);$i++) {
    if( ($arr_cart_p_id[$i] == $_REQUEST['id']) && ($arr_cart_size_id[$i] == $_REQUEST['size']) && ($arr_cart_color_id[$i] == $_REQUEST['color']) ) {
        continue;
    } else {
        $_SESSION['cart_p_id'][$k] = $arr_cart_p_id[$i];
        $_SESSION['cart_size_id'][$k] = $arr_cart_size_id[$i];
        $_SESSION['cart_size_name'][$k] = $arr_cart_size_name[$i];
        $_SESSION['cart_color_id'][$k] = $arr_cart_color_id[$i];
        $_SESSION['cart_color_name'][$k] = $arr_cart_color_name[$i];
        $_SESSION['cart_p_qty'][$k] = $arr_cart_p_qty[$i];
        $_SESSION['cart_p_current_price'][$k] = $arr_cart_p_current_price[$i];
        $_SESSION['cart_p_name'][$k] = $arr_cart_p_name[$i];
        $_SESSION['cart_p_featured_photo'][$k] = $arr_cart_p_featured_photo[$i];
        $_SESSION['cart_p_shoulders'][$k] = $cart_p_shoulders[$i];
        $_SESSION['cart_p_dartpoint'][$k] = $cart_p_dartpoint[$i];
        $_SESSION['cart_p_chestlength'][$k] = $cart_p_chestlength[$i];
        $_SESSION['cart_p_chest'][$k] = $cart_p_chest[$i];
        $_SESSION['cart_p_waist'][$k] = $cart_p_waist[$i];
        $_SESSION['cart_p_shirtlength'][$k] = $cart_p_shirtlength[$i];
        $_SESSION['cart_p_hip'][$k] = $cart_p_hip[$i];
        $_SESSION['cart_p_armhole'][$k] = $cart_p_armhole[$i];
        $_SESSION['cart_p_thigh'][$k] = $cart_p_thigh[$i];
        $_SESSION['cart_p_knee'][$k] = $cart_p_knee[$i];
        $_SESSION['cart_p_calf'][$k] = $cart_p_calf[$i];
        $_SESSION['cart_p_pantlength'][$k] = $cart_p_pantlength[$i];
        $_SESSION['cart_p_pantwaist'][$k] = $cart_p_pantwaist[$i];
        $_SESSION['cart_p_tailor_charges'][$k] = $cart_p_tailor_charges[$i];
        $_SESSION['cart_p_design_pic'][$k] = $arr_cart_p_design_pic[$i];
        
        $k++;
    }
}


header('location: cart.php');
?>