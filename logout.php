<?php
ob_start();
session_start();
include 'admin/inc/config.php';
unset($_SESSION['customer']);
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


header("location: login.php");
