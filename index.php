<?php include("header.php"); ?>

<!-- Start Slider -->
<div id="slides-shop" class="cover-slides" style="height: 500px;">
    <ul class="slides-container">
        <?php
        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_slider");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {            
        ?>
        <li class="text-<?php echo strtolower($row['position']); ?>">
            <img src="assets/uploads/<?php echo $row['photo']; ?>" alt="">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php if(isset($row['heading'])){?>
                        <h1 class="m-b-20"><?php echo $row['heading']; ?></h1>
                        <?php } ?>
                        <?php if(isset($row['content'])){?>
                        <p class="m-b-40"><?php echo $row['content']; ?></p>
                        <?php } ?>
                        <?php if(isset($row['button_text'])){?>
                        <p><a class="btn hvr-hover" href="<?php echo $row['button_url']; ?>"><?php echo $row['button_text']; ?></a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </li>
        <?php } ?>
    </ul>
    <div class="slides-navigation">
        <a href="#" class="next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
        <a href="#" class="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
    </div>
</div>
<!-- End Slider -->

<!-- Start Categories  -->
<div class="categories-shop">
    <div class="container">
        <div class="row">
            <?php
            $i=0;
            $statement = $pdo->prepare("SELECT * FROM tbl_product ORDER BY RAND() LIMIT 6");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
            foreach ($result as $row) { 
                $p_id = $row['p_id'];
            ?>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="shop-cat-box">

                    <img class="img-fluid cursor-pointer" onclick="redirect_url('<?php echo "product.php?id=$p_id&type=sub"; ?>')" style="height:475px;" src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="" />

                    <a class="btn hvr-hover" href="product.php?id=<?php echo $row['p_id']; ?>&type=sub"><?php echo get_midcat_name($pdo, $row['midcat_id']); ?></a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- End Categories -->

<!-- Start Products  -->
<div class="products-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-all text-center">
                    <h1>Featured Products</h1>
                </div>
            </div>
        </div>

        <div class="row special-list">
            <?php
            $i=0;
            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_featured=? ORDER BY RAND() LIMIT 8");
            $statement->execute(array(1));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
            foreach ($result as $row) {            
            ?>
            <div class="col-lg-3 col-md-6 special-grid">
                <div class="products-single fix">
                    <div class="box-img-hover">
                        <img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" class="img-fluid" style="height:390px;" alt="Image">
                        <div class="mask-icon">
                            <ul>
                                <li><a href="wishlist.php?id=<?php echo $row['p_id']; ?>" target="_blank" data-toggle="tooltip" data-placement="right"
                                       title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                            </ul>
                            <?php if($row['p_qty']!= 0){ ?>
                            < <a class="cart" href="product.php?id=<?php echo $row['p_id']; ?>&type=sub">Add to Cart</a>
                        <?php }else{ ?>
                        <h1 style="font-weight:bold;color:red;">Out of Stock</h1>
                        <?php } ?>

                    </div>
                </div>
                <div class="why-text">
                    <h4 style="text-align:center;"><a href="product.php?id=<?php echo $row['p_id']; ?>&type=sub"><?php echo $row['p_name']; ?></a></h4>
                    <h5 style="text-align:center;"><a href="product.php?id=<?php echo $row['p_id']; ?>&type=sub">Rs.<?php echo $row['p_current_price']; ?></a></h5>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
</div>
<!-- End Products  -->

<?php include("footer.php"); ?>