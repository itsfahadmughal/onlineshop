<?php require_once('header.php'); ?>

<?php
$tailor_charrges = '';

if (isset($_REQUEST['id']) && $_REQUEST['id'] !='') {
    $i=0;
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id =? and p_is_active = ?");
    $statement->execute(array($_REQUEST['id'],1));
    $result_prod = $statement->fetchAll(PDO::FETCH_ASSOC);
    $photo[] = '';
    array_push($photo, $result_prod[0]['p_featured_photo']);


    $statement = $pdo->prepare("SELECT * FROM tbl_product_size WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $size[] = $row['size_id'];
    }

    $statement = $pdo->prepare("SELECT * FROM tbl_product_color WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $color[] = $row['color_id'];
    }
}

if (isset($_POST['form_add_to_cart'])) {

    // getting the currect stock of this product
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=? and p_is_active = ?");
    $statement->execute(array($_REQUEST['id'],1));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $current_p_qty = $row['p_qty'];
    }
    if (($current_p_qty - $_POST['p_qty']) < 0):
        $temp_msg = 'Sorry! There are only '.$current_p_qty.' item(s) in stock'; ?>
<script type="text/javascript">
    alert('<?php echo $temp_msg; ?>');
</script>
<?php
    else:
    if (isset($_SESSION['cart_p_id'])) {
        $arr_cart_p_id = array();
        $arr_cart_size_id = array();
        $arr_cart_color_id = array();
        $arr_cart_p_qty = array();
        $arr_cart_p_current_price = array();
        $arr_cart_p_tailor_charges = array();
        $arr_cart_p_design_pic = array();
    

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
        foreach ($_SESSION['cart_color_id'] as $key => $value) {
            $i++;
            $arr_cart_color_id[$i] = $value;
        }


        $added = 0;
        if (!isset($_POST['size_id'])) {
            $size_id = 0;
        } else {
            $size_id = $_POST['size_id'];
        }
        if (!isset($_POST['color_id'])) {
            $color_id = 0;
        } else {
            $color_id = $_POST['color_id'];
        }
        for ($i=1;$i<=count($arr_cart_p_id);$i++) {
            if (($arr_cart_p_id[$i]==$_REQUEST['id']) && ($arr_cart_size_id[$i]==$size_id) && ($arr_cart_color_id[$i]==$color_id)) {
                $added = 1;
                break;
            }
        }
        if ($added == 1) {
            // echo '<script  type="text/javascript">alert("This product is already added to the shopping cart.")</script>';
            header("location: cart.php");
        } else {
            $i=0;
            foreach ($_SESSION['cart_p_id'] as $key => $res) {
                $i++;
            }
            $new_key = $i+1;

            if (isset($_POST['size_id'])) {
                $size_id = $_POST['size_id'];

                $statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=?");
                $statement->execute(array($size_id));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $size_name = $row['size_name'];
                }
            } else {
                $size_id = 0;
                $size_name = '';
            }
            
            if (isset($_POST['color_id'])) {
                $color_id = $_POST['color_id'];
                $statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
                $statement->execute(array($color_id));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $color_name = $row['color_name'];
                }
            } else {
                $color_id = 0;
                $color_name = '';
            }
          

            $_SESSION['cart_p_id'][$new_key] = $_REQUEST['id'];
            $_SESSION['cart_size_id'][$new_key] = $size_id;
            $_SESSION['cart_size_name'][$new_key] = $size_name;
            $_SESSION['cart_color_id'][$new_key] = $color_id;
            $_SESSION['cart_color_name'][$new_key] = $color_name;
            $_SESSION['cart_p_qty'][$new_key] = $_POST['p_qty'];
            $_SESSION['cart_p_type'][$new_key] = $_POST['p_type'];
            $_SESSION['cart_p_current_price'][$new_key] = $_POST['p_current_price'];
            $_SESSION['cart_p_name'][$new_key] = $_POST['p_name'];
            $_SESSION['cart_p_featured_photo'][$new_key] = $_POST['p_featured_photo'];
            if (!empty($_POST['shoulders'])) {
                $_SESSION['cart_p_shoulders'][$new_key] = $_POST['shoulders'];
            } else {
                $_SESSION['cart_p_shoulders'][$new_key] = '';
            }
            if (!empty($_POST['dartpoint'])) {
                $_SESSION['cart_p_dartpoint'][$new_key] = $_POST['dartpoint'];
            } else {
                $_SESSION['cart_p_dartpoint'][$new_key] = '';
            }
            if (!empty($_POST['chestlength'])) {
                $_SESSION['cart_p_chestlength'][$new_key] = $_POST['chestlength'];
            } else {
                $_SESSION['cart_p_chestlength'][$new_key] = '';
            }
            if (!empty($_POST['chest'])) {
                $_SESSION['cart_p_chest'][$new_key] = $_POST['chest'];
            } else {
                $_SESSION['cart_p_chest'][$new_key] = '';
            }
            if (!empty($_POST['waist'])) {
                $_SESSION['cart_p_waist'][$new_key] = $_POST['waist'];
            } else {
                $_SESSION['cart_p_waist'][$new_key] = '';
            }
            if (!empty($_POST['shirtlength'])) {
                $_SESSION['cart_p_shirtlength'][$new_key] = $_POST['shirtlength'];
            } else {
                $_SESSION['cart_p_shirtlength'][$new_key] = '';
            }
            if (!empty($_POST['hip'])) {
                $_SESSION['cart_p_hip'][$new_key] = $_POST['hip'];
            } else {
                $_SESSION['cart_p_hip'][$new_key] = '';
            }
            if (!empty($_POST['armhole'])) {
                $_SESSION['cart_p_armhole'][$new_key] = $_POST['armhole'];
            } else {
                $_SESSION['cart_p_armhole'][$new_key] = '';
            }
            if (!empty($_POST['thigh'])) {
                $_SESSION['cart_p_thigh'][$new_key] = $_POST['thigh'];
            } else {
                $_SESSION['cart_p_thigh'][$new_key] = '';
            }
            if (!empty($_POST['knee'])) {
                $_SESSION['cart_p_knee'][$new_key] = $_POST['knee'];
            } else {
                $_SESSION['cart_p_knee'][$new_key] = '';
            }
            if (!empty($_POST['calf'])) {
                $_SESSION['cart_p_calf'][$new_key] = $_POST['calf'];
            } else {
                $_SESSION['cart_p_calf'][$new_key] = '';
            }
            if (!empty($_POST['pantlength'])) {
                $_SESSION['cart_p_pantlength'][$new_key] = $_POST['pantlength'];
            } else {
                $_SESSION['cart_p_pantlength'][$new_key] = '';
            }
            if (!empty($_POST['pantwaist'])) {
                $_SESSION['cart_p_pantwaist'][$new_key] = $_POST['pantwaist'];
            } else {
                $_SESSION['cart_p_pantwaist'][$new_key] = '';
            }
            

            if (isset($_POST['tailor'])) {
                if (isset($_POST['tailor']) && $_POST['tailor']=='None') {
                    $_SESSION['cart_p_tailor_charges'][$new_key] = '';
                } else {
                    $stmt_tcharges = $pdo->prepare("SELECT * FROM tbl_tailorcharges WHERE t_id=?");
                    $stmt_tcharges->execute(array($_POST['tailor']));
                    $res_tcharges = $stmt_tcharges->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($res_tcharges as $r_tcharges) {
                        if ($r_tcharges['t_id'] == $_POST['tailor']) {
                            $_SESSION['cart_p_tailor_charges'][$new_key] = $r_tcharges['charges'];
                        }
                    }
                }
            } else {
                $_SESSION['cart_p_tailor_charges'][$new_key] = '';
            }


            $_SESSION['cart_p_design_pic'][$new_key] = '';

        
            if (!empty($_FILES['design_pic']['name'])) {
                $path = $_FILES['design_pic']['name'];
                $path_tmp = $_FILES['design_pic']['tmp_name'];

                if ($path !='') {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $file_name = basename($path, '.' . $ext);
                    if ($ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif') {
                        echo '<script  type="text/javascript">alert(You must have to upload jpg, jpeg, gif or png file)</script>';
                    }
                    // updating the data
                    $final_name = time().'.'.$ext;
                    // echo "Desing Pic = ".$final_name;
                    move_uploaded_file($path_tmp, 'assets/uploads/'.$final_name);
                    $_SESSION['cart_p_design_pic'][$new_key] = $final_name;
                }
            }

            // echo '<script  type="text/javascript">alert("Product is added to the cart successfully!")</script>';
            header("location: cart.php");
        }
    } else {
        if (isset($_POST['size_id'])) {
            $size_id = $_POST['size_id'];

            $statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=?");
            $statement->execute(array($size_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $size_name = $row['size_name'];
            }
        } else {
            $size_id = 0;
            $size_name = '';
        }
        
        if (isset($_POST['color_id'])) {
            $color_id = $_POST['color_id'];
            $statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
            $statement->execute(array($color_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $color_name = $row['color_name'];
            }
        } else {
            $color_id = 0;
            $color_name = '';
        }
        

        $_SESSION['cart_p_id'][1] = $_REQUEST['id'];
        $_SESSION['cart_size_id'][1] = $size_id;
        $_SESSION['cart_size_name'][1] = $size_name;
        $_SESSION['cart_color_id'][1] = $color_id;
        $_SESSION['cart_color_name'][1] = $color_name;
        $_SESSION['cart_p_qty'][1] = $_POST['p_qty'];
        $_SESSION['cart_p_current_price'][1] = $_POST['p_current_price'];
        $_SESSION['cart_p_name'][1] = $_POST['p_name'];
        $_SESSION['cart_p_type'][1] = $_POST['p_type'];
        $_SESSION['cart_p_featured_photo'][1] = $_POST['p_featured_photo'];

        if (isset($_POST['shoulders'])) {
            $_SESSION['cart_p_shoulders'][1] = $_POST['shoulders'];
        } else {
            $_SESSION['cart_p_shoulders'][1] = '';
        }
        if (isset($_POST['dartpoint'])) {
            $_SESSION['cart_p_dartpoint'][1] = $_POST['dartpoint'];
        } else {
            $_SESSION['cart_p_dartpoint'][1] = '';
        }
        
        if (isset($_POST['chestlength'])) {
            $_SESSION['cart_p_chestlength'][1] = $_POST['chestlength'];
        } else {
            $_SESSION['cart_p_chestlength'][1] = '';
        }

        if (isset($_POST['chest'])) {
            $_SESSION['cart_p_chest'][1] = $_POST['chest'];
        } else {
            $_SESSION['cart_p_chest'][1] = '';
        }
        
        if (isset($_POST['waist'])) {
            $_SESSION['cart_p_waist'][1] = $_POST['waist'];
        } else {
            $_SESSION['cart_p_waist'][1] = '';
        }
        if (isset($_POST['shirtlength'])) {
            $_SESSION['cart_p_shirtlength'][1] = $_POST['shirtlength'];
        } else {
            $_SESSION['cart_p_shirtlength'][1] = '';
        }

        if (isset($_POST['hip'])) {
            $_SESSION['cart_p_hip'][1] = $_POST['hip'];
        } else {
            $_SESSION['cart_p_hip'][1] = '';
        }
        
        if (isset($_POST['armhole'])) {
            $_SESSION['cart_p_armhole'][1] = $_POST['armhole'];
        } else {
            $_SESSION['cart_p_armhole'][1] = '';
        }
        
        if (isset($_POST['thigh'])) {
            $_SESSION['cart_p_thigh'][1] = $_POST['thigh'];
        } else {
            $_SESSION['cart_p_thigh'][1] = '';
        }
        
        if (isset($_POST['knee'])) {
            $_SESSION['cart_p_knee'][1] = $_POST['knee'];
        } else {
            $_SESSION['cart_p_knee'][1] = '';
        }

        if (isset($_POST['calf'])) {
            $_SESSION['cart_p_calf'][1] = $_POST['calf'];
        } else {
            $_SESSION['cart_p_calf'][1] = '';
        }

        if (isset($_POST['pantlength'])) {
            $_SESSION['cart_p_pantlength'][1] = $_POST['pantlength'];
        } else {
            $_SESSION['cart_p_pantlength'][1] = '';
        }
        
        if (isset($_POST['pantwaist'])) {
            $_SESSION['cart_p_pantwaist'][1] = $_POST['pantwaist'];
        } else {
            $_SESSION['cart_p_pantwaist'][1] = '';
        }

        
        if (!isset($_POST['tailor'])) {
            $_SESSION['cart_p_tailor_charges'][1] = '';
        } elseif ($_POST['tailor']=='None') {
            $_SESSION['cart_p_tailor_charges'][1] = '';
        } else {
            $stmt_tcharges = $pdo->prepare("SELECT * FROM tbl_tailorcharges WHERE t_id=?");
            $stmt_tcharges->execute(array($_POST['tailor']));
            $res_tcharges = $stmt_tcharges->fetchAll(PDO::FETCH_ASSOC);
                
            foreach ($res_tcharges as $r_tcharges) {
                if ($r_tcharges['t_id'] == $_POST['tailor']) {
                    $_SESSION['cart_p_tailor_charges'][1] = $r_tcharges['charges'];
                }
            }
        }
     

        
        $_SESSION['cart_p_design_pic'][1] = '';

        if (!empty($_FILES['design_pic']['name'])) {
            $path = $_FILES['design_pic']['name'];
            $path_tmp = $_FILES['design_pic']['tmp_name'];

            if ($path !='') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $file_name = basename($path, '.' . $ext);
                if ($ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif') {
                    echo '<script  type="text/javascript">alert(You must have to upload jpg, jpeg, gif or png file)</script>';
                }
                // updating the data
                $final_name = time().'.'.$ext;
                // echo "Desing Pic = ".$final_name;
                move_uploaded_file($path_tmp, 'assets/uploads/'.$final_name);
                $_SESSION['cart_p_design_pic'][1] = $final_name;
            }
        }
        
        // echo '<script  type="text/javascript">alert("Product is added to the cart successfully!")</script>';
        header("location: cart.php");
    }
    endif;

    cart_count_update();
}

?>

<!-- Start All Title Box 
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Shop Detail</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active">Shop Detail </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->

<!-- Start Shop Detail  -->
<div class="shop-detail-box-main">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-6">
                <div id="carousel-example-1" class="single-product-slider carousel
                    slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <?php
                            $count = 0;
                            $statement2 = $pdo->prepare("SELECT photo
                                                        FROM tbl_product_photo WHERE p_id = ?");
                            $statement2->execute(array($_REQUEST['id']));
                            if ($statement2->rowCount() > 0) {
                                $result_photo = $statement2->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result_photo as $row_photo) {
                                    array_push($photo, $row_photo['photo']);
                                }
                            }
                            
                            foreach (array_filter($photo) as $p) {
                                ?>
                        <div class="carousel-item <?php if ($count == 0) {
                                    echo 'active';
                                } ?>"> <img class="d-block
                                                w-100" src="assets/uploads/<?php if ($p !='') {
                                    echo $p;
                                } ?>" alt="slide"> </div>
                        <?php
                          $count++;
                            } ?>
                    </div>
                    <a class="carousel-control-prev" href="#carousel-example-1" role="button" data-slide="prev">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-example-1" role="button" data-slide="next">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                        <span class="sr-only">Next</span>
                    </a>
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-1" data-slide-to="0" class="active">
                            <img class="d-block w-100 img-fluid" src="assets/images/smp-img-01.jpg" alt="" />
                        </li>
                        <li data-target="#carousel-example-1" data-slide-to="1">
                            <img class="d-block w-100 img-fluid" src="assets/images/smp-img-02.jpg" alt="" />
                        </li>
                        <li data-target="#carousel-example-1" data-slide-to="2">
                            <img class="d-block w-100 img-fluid" src="assets/images/smp-img-03.jpg" alt="" />
                        </li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-6">
                <div class="single-product-details">
                    <h1>Product Detail</h1><br>
                    <h2><?php echo $result_prod[0]['p_name']; ?>
                    </h2>
                    <p><?php echo $result_prod[0]['p_description']; ?>
                    </p>
                    <form action="" method="post" enctype='multipart/form-data'>
                        <div class="p-quantity">
                            <div class="row">
                                <?php if (isset($size)): ?>
                                <div class="col-md-12 mb_20">
                                    <span style="font-size:18px; color:brown;">Select Size </span><br>
                                    <select name="size_id" class="form-control select2" style="width:auto;">
                                        <?php
                                            $statement_size = $pdo->prepare("SELECT * FROM tbl_size");
                                            $statement_size->execute();
                                            $result_size = $statement_size->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result_size as $row_size) {
                                                if (in_array($row_size['size_id'], $size)) {
                                                    ?>
                                        <option
                                            value="<?php echo $row_size['size_id']; ?>">
                                            <?php echo $row_size['size_name']; ?>
                                        </option>
                                        <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                                <?php endif; ?>

                                <?php if (isset($color)): ?>
                                <div class="col-md-12">
                                    <span style="font-size:18px; color:#d33b33;">Select Color </span><br>
                                    <select name="color_id" class="form-control select2" style="width:auto;">
                                        <?php
                                            $statement_color = $pdo->prepare("SELECT * FROM tbl_color");
                                            $statement_color->execute();
                                            $result_color = $statement_color->fetchAll(PDO::FETCH_ASSOC);
                  
                                            foreach ($result_color as $row_color) {
                                                if (in_array($row_color['color_id'], $color)) {
                                                    ?>
                                        <option
                                            value="<?php echo $row_color['color_id']; ?>">
                                            <?php echo $row_color['color_name']; ?>
                                        </option>
                                        <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                                <?php endif; ?>

                            </div>

                        </div><br>
                        <div class="p-price">
                            <span style="font-size:18px; color:#d33b33;">Product Price</span><br>
                            <span>
                                <?php if ($result_prod[0]['p_old_price'] !=''): ?>
                                <del>Rs. <?php echo $result_prod[0]['p_old_price']; ?></del>
                                <?php endif; ?>
                                <span style="font-size:18px;color:#d33b33;">Rs. <?php echo $result_prod[0]['p_current_price']; ?></span>
                            </span>
                        </div>
                        <input type="hidden" name="p_type"
                            value="<?php echo $result_prod[0]['p_type']; ?>">
                        <input type="hidden" name="p_current_price"
                            value="<?php echo $result_prod[0]['p_current_price']; ?>">
                        <input type="hidden" name="p_name"
                            value="<?php echo $result_prod[0]['p_name']; ?>">
                        <input type="hidden" name="p_featured_photo"
                            value="<?php echo $result_prod[0]['p_featured_photo']; ?>">
                        <br>

                        <?php
                                if ($result_prod[0]['p_qty'] != 0) { ?>
                        <span style="font-size:18px; color:#d33b33;">Quantity</span><br>
                        <div class="p-quantity">
                            <input type="number" class="input-text qty" step="1" min="1"
                                max="<?php echo $result_prod[0]['p_qty']; ?>"
                                name="p_qty" size="20" pattern="[0-9]*" inputmode="numeric" value="1">
                        </div>
                        <?php } else {?>
                        <h1 style="font-weight:bold;color:red;">Out of Stock</h1>
                        <?php } ?>
                        <br>
                        <br>
                        <a style="color:blue;" href="sizechart.php" target="_blank">Click here to see size chart</a>
                        <br>
                        <?php if ($result_prod[0]['p_qty'] != 0) { ?>
                        <?php if ($result_prod[0]['p_type']!='readymade') { ?>
                        <button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample"
                            style="font-size:18px;background-color:#d33b33;color:#fff; width:auto;margin-left:0px;">
                            Design Your Own
                        </button>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <table class="table" <?php if ($result_prod[0]['p_type'] == 'facemask') { ?>
                                    style="display:none!important;" <?php } ?> >
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="4" scope="col">Shirt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="w-10" style="vertical-align:middle;"><label
                                                    for="inputCity">Shoulders</label></td>
                                            <td class="w-40" style="vertical-align:middle;">
                                            <input type="number" min="1" max="99" step="0.01" id="shoulders"
                                                    class="form-control" style="width:100%" name="shoulders"></td>
                                            <td class="w-10" style="vertical-align:middle;"><label for="inputCity">Dart
                                                    Point</label></td>
                                            <td class="w-30" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="dartpoint"
                                                    class="form-control" style="width:100%" name="dartpoint"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-10" style="vertical-align:middle;"><label for="inputCity">Chest
                                                    Length</label></td>
                                            <td class="w-10" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="chestlength"
                                                    class="form-control" style="width:100%" name="chestlength"></td>
                                            <td class="w-10" style="vertical-align:middle;"><label
                                                    for="inputCity">Chest</label></td>
                                            <td class="w-10" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="chest"
                                                    class="form-control" style="width:100%" name="chest"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-10" style="vertical-align:middle;"><label
                                                    for="inputCity">Waist</label></td>
                                            <td class="w-10" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="waist"
                                                    class="form-control" style="width:100%" name="waist"></td>
                                            <td class="w-10" style="vertical-align:middle;"><label for="inputCity">Shirt
                                                    Length</label></td>
                                            <td class="w-10" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="shirtlength"
                                                    class="form-control" style="width:100%" name="shirtlength"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-10" style="vertical-align:middle;"><label
                                                    for="inputCity">Hip</label></td>
                                            <td class="w-10" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="hip"
                                                    class="form-control" style="width:100%" name="hip"></td>
                                            <td class="w-10" style="vertical-align:middle;"><label for="inputCity">Arm
                                                    Hole</label></td>
                                            <td class="w-10" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="armhole"
                                                    class="form-control" style="width:100%" name="armhole"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th <?php if ($result_prod[0]['p_type'] == 'facemask') {
                                    echo "style='display:none;'";
                                }?>
                                                colspan="4" scope="col">Pant
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr <?php if ($result_prod[0]['p_type'] == 'facemask') {
                                    echo "style='display:none;'";
                                }?>>
                                            <td class="w-10" style="vertical-align:middle;"><label
                                                    for="inputCity">Thigh</label></td>
                                            <td class="w-10" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="thigh"
                                                    class="form-control" style="width:100%" name="thigh"></td>
                                            <td class="w-10" style="vertical-align:middle;"><label
                                                    for="inputCity">Knee</label></td>
                                            <td class="w-10" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="knee"
                                                    class="form-control" style="width:100%" name="knee"></td>
                                        </tr>
                                        <tr <?php if ($result_prod[0]['p_type'] == 'facemask') {
                                    echo "style='display:none;'";
                                }?>>
                                            <td class="w-10" style="vertical-align:middle;"><label
                                                    for="inputCity">Calf</label></td>
                                            <td class="w-10" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="calf"
                                                    class="form-control" style="width:100%" name="calf"></td>
                                            <td class="w-10" style="vertical-align:middle;"><label for="inputCity">Pant
                                                    Length</label></td>
                                            <td class="w-10" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="pantlength"
                                                    class="form-control" style="width:100%" name="pantlength"></td>
                                        </tr>
                                        <tr <?php if ($result_prod[0]['p_type'] == 'facemask') {
                                    echo "style='display:none;'";
                                }?>>
                                            <td class="w-10" style="vertical-align:middle;"><label for="inputCity">Pant
                                                    Waist</label></td>
                                            <td class="w-10" style="vertical-align:middle;">
                                            <input type="number" step="0.01" id="pantwaist"
                                                    class="form-control pantwaist" style="width:100%" name="pantwaist"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-10" style="vertical-align:middle;"><label
                                                    for="inputCity">Upload Design</label></td>
                                            <td colspan="3" class="w-90" style="vertical-align:middle;">
                                                <input type="file" name="design_pic" class="form-control"
                                                    style="width:100%">
                                            </td>
                                        </tr>
                                        <tr <?php if ($result_prod[0]['p_type'] == 'facemask') {
                                    echo "style='display:none;'";
                                }?>>
                                            <td class="w-10" style="vertical-align:middle;"><label
                                                    for="inputCity">Select Tailor</label></td>
                                            <?php
                                            $stmt_tailor = $pdo->prepare("SELECT * FROM tbl_tailorcharges");
                                            $stmt_tailor->execute();
                                            if ($stmt_tailor->RowCount()>0) {
                                                ?>
                                            <td colspan="3" class="w-90" style="vertical-align:middle;">
                                                <div class="col-md-12 form-group">
                                                    <select class="form-control select2" name="tailor" id="tailor">
                                                        <option value="None">Select Tailor</option>
                                                        <?php
                                                            $result_tailor = $stmt_tailor->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result_tailor as $row_tailor) {
                                                    ?>
                                                        <option
                                                            value="<?php echo $row_tailor['t_id']; ?>">
                                                            <?php echo $row_tailor['tailor_category']; ?>
                                                            - Rs. <?php echo $row_tailor['charges']; ?>
                                                        </option>
                                                        <?php
                                                } ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <?php
                                            } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php } ?>

                        <br>
                        <?php if ($result_prod[0]['p_qty'] != 0) { ?>
                        <input class="btn" style="font-size:18px;background-color:#d33b33;color:#fff;" type="submit"
                            value="Add to cart" name="form_add_to_cart">
                        <?php }?>
                        <div class="btn-cart btn-cart1">

                        </div>
                        <?php } ?>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<br>
<?php require_once('footer.php');
