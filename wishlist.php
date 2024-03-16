<?php include("header.php"); ?>

<?php
// print_r($_SESSION);

if(!isset($_SESSION['customer'])){
    header('location: index.php');
}

if(isset($_GET['id']) || isset($_GET['id']) != ''){
    $customer_id = $_SESSION['customer']['cust_id'];
    $product_id = $_GET['id'];

    $statement2 = $pdo->prepare("SELECT * FROM tbl_wishlist where p_id=?");
    $statement2->execute(array($_GET['id']));
    if($statement2->RowCount() == 0){
        $statement = $pdo->prepare("INSERT INTO tbl_wishlist (   
            customer_id,
            p_id
            ) VALUES (?,?)");
            $statement->execute(array(
                $_SESSION['customer']['cust_id'],
                $_GET['id']
        ));
    }
}


if(isset($_GET['pid']) && $_GET['pid'] != ''){
    $statement1 = $pdo->prepare("delete from tbl_wishlist WHERE p_id=?");
    $statement1->execute(array($_GET['pid']));
}

?>

    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Wishlist</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active">Wishlist</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Wishlist  -->
    <div class="wishlist-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                    <?php
                        $i=0;
                        $statement3 = $pdo->prepare("SELECT
                                                    t1.p_id,
                                                    t1.p_name,
                                                    t1.p_current_price,
                                                    t1.p_qty,
                                                    t1.p_featured_photo
                                                FROM
                                                    tbl_product t1
                                                JOIN tbl_wishlist t2 ON
                                                    t1.p_id = t2.p_id
                                                WHERE t2.customer_id =?
                                                ORDER BY
                                                    t2.p_id
                                                DESC");
                        $statement3->execute(array($_SESSION['customer']['cust_id']));
                        $result3 = $statement3->fetchAll(PDO::FETCH_ASSOC);    
                        if($statement3->RowCount() > 0){                        
                            foreach ($result3 as $row3) {            
                    ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Unit Price </th>
                                    <th>Quantity</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td class="thumbnail-img">
                                            <a href="product.php?id=<?php echo $row3['p_id']; ?>&type=sub" target="_blank">
                                                <img class="img-fluid" src="assets/uploads/<?php echo $row3['p_featured_photo']; ?>" alt="" />
                                            </a>
                                    </td>
                                    <td class="name-pr">
                                        <a href="product.php?id=<?php echo $row3['p_id']; ?>&type=sub" target="_blank">
                                            <?php echo $row3['p_name']; ?>
                                        </a>
                                    </td>
                                    <td class="price-pr">
                                        <?php echo $row3['p_current_price']; ?>
                                    </td>
                                    <td class="quantity-box">
                                        <?php echo $row3['p_qty']; ?>
                                    </td>
                                    <td class="remove-pr">
                                        <a onclick="return confirmDelete();" href="wishlist.php?pid=<?php echo $row3['p_id']; ?>">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                            </tr>
                            </tbody>
                        </table>
                        <?php }
                            }else{
                                echo '<h3 style="text-align:center;">No Products in Wishlist</h3>';
                            } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Wishlist -->

    <?php include("footer.php"); ?>