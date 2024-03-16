<?php
    
include("header.php");

?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php require_once('cust-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <h3>Payment Details</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Paid Amount</th>
                                    <th>Payment Status</th>
                                    <th>Payment Method</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                            $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE order_id=?");
                                            $statement->execute(array($_REQUEST['id']));
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row['payment_date']; ?>
                                            </td>
                                            <td><?php echo $row['paid_amount']; ?>
                                            </td>
                                            <td><?php echo $row['payment_status']; ?>
                                            </td>
                                            <td><?php echo $row['payment_method']; ?>
                                            </td>
                                        </tr>
                                    <?php
                                            }
                                        ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <h3>Product Details</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Product Type</th>
                                    <th>Measurement</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    <?php
                                    $statement1 = $pdo->prepare("SELECT * FROM tbl_order_details WHERE order_id=?");
                                    $statement1->execute(array($_REQUEST['id']));
                                    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result1 as $row1) {
                                        ?>
                                    <tr>
                                    <td><?php echo $row1['p_name']; ?>
                                    </td>
                                    <td><?php echo $row1['size']; ?>
                                    </td>
                                    <td><?php echo $row1['color']; ?>
                                    </td>
                                    <td><?php echo $row1['quantity']; ?>
                                    </td>
                                    <td><?php echo $row1['unit_price']; ?>
                                    </td>
                                    <td><?php echo $row1['p_type']; ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo 'Shoulders: '.$row1['shoulders'].'<br>';
                                        echo 'Dart Point: '.$row1['dart_point'].'<br>';
                                        echo 'Chest Length: '.$row1['chest_length'].'<br>';
                                        echo 'Chest: '.$row1['chest'].'<br>';
                                        echo 'Waist: '.$row1['waist'].'<br>';
                                        echo 'Shirt Length: '.$row1['shirt_length'].'<br>';
                                        echo 'Hip: '.$row1['hip'].'<br>';
                                        echo 'Arm Hole: '.$row1['arm_hole'].'<br>';
                                        echo 'Thigh: '.$row1['thigh'].'<br>';
                                        echo 'Knee: '.$row1['knee'].'<br>';
                                        echo 'Calf: '.$row1['calf'].'<br>';
                                        echo 'Pant Length: '.$row1['pant_length'].'<br>';
                                        echo 'Pant Waist: '.$row1['pant_waist'].'<br>'; ?>
                                    </td>
                                    </tr>
                                    <?php
                                    }
                                            ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
</body>

</html>