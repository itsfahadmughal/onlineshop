<?php require_once('header.php'); ?>

<?php
// if (!isset($_REQUEST['type']) || !isset($_REQUEST['id'])) {
//     header('location: index.php');
//     exit;
// }
if (isset($_REQUEST['id']) && isset($_REQUEST['type'])) {
    if ($_REQUEST['type'] == 'all') {
        $statement = $pdo->prepare("SELECT * FROM tbl_product where p_is_active = ?");
        $statement->execute(array(1));
        $result_prod = $statement->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($_REQUEST['type'] == 'sub') {
        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE midcat_id=? and p_is_active = ?");
        $statement->execute(array($_REQUEST['id'],1));
        $result_prod = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $no_product = "No Product Found;";
    }
} elseif (!isset($_REQUEST['id']) && isset($_REQUEST['type'])) {
    if ($_REQUEST['type'] == 'all') {
        $statement = $pdo->prepare("SELECT * FROM tbl_product where p_is_active = ?");
        $statement->execute(array(1));
        $result_prod = $statement->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($_REQUEST['type'] == 'sub') {
        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE midcat_id=? and p_is_active = ?");
        $statement->execute(array($_REQUEST['id'],1));
        $result_prod = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $no_product = "No Product Found;";
    }
} else {
    $no_product = "No Product Found;";
}

?>

<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Shop</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <?php
                        if (isset($_REQUEST['type']) == 'all') {
                            ?>
                    <li class="breadcrumb-item">Shop</li>';
                    <?php
                        } elseif (isset($_REQUEST['type']) == 'sub') {
                            ?>
                    <li class="breadcrumb-item"><?php echo get_midcat_name($pdo, $result_prod[0]['midcat_id']); ?>
                    </li>;
                    <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->

<!-- Start Shop Page  -->
<div class="shop-box-inner">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-sm-12 col-xs-12 sidebar-shop-left">
                <div class="product-categori">
                    <div class="filter-sidebar-left">
                        <?php require_once('sidebar-category.php'); ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-sm-12 col-xs-12 shop-content-right">
                <div class="right-product-box">
                    <div class="row product-categorie-box">
                        <div class="list-view-box">
                            <?php
                                    foreach ($result_prod as $row_prod) {
                                        ?>
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                    <div class="products-single fix">
                                        <div class="box-img-hover">
                                            <img class="d-block w-100"
                                                src="assets/uploads/<?php echo $row_prod['p_featured_photo']; ?>"
                                                alt="First slide">
                                            <div class="mask-icon">
                                                <ul>
                                                    <li><a href="wishlist.php?id=<?php echo $row_prod['p_id']; ?>" target="_blank" data-toggle="tooltip" data-placement="right"
                                            title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-8 col-xl-8">
                                    <div class="why-text full-width" style="margin-top:5px;margin-bottom:5px;">
                                        <h4><?php echo $row_prod['p_name']; ?>
                                        </h4>
                                        <h5>
                                            <?php if ($row_prod['p_old_price']!=0) {
                                            echo '<del>Rs.'.$row_prod['p_old_price'].'</del>';
                                        } ?>Rs.<?php echo $row_prod['p_current_price']; ?>
                                        </h5>
                                        <h1>Description</h1>
                                        <p><?php echo $row_prod['p_short_description']; ?>
                                        </p>
                                        <?php if($row_prod['p_qty']>0){ ?>
                                        <a class="btn hvr-hover"
                                            href="product.php?id=<?php echo $row_prod['p_id']; ?>">Add
                                            to Cart</a>
                                        <?php }else{ ?>
                                            <h1 style="font-weight:bold;color:red;">Out of Stock</h1>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>

<!-- End Shop Page -->

<?php require_once('footer.php');
