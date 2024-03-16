<?php
    
include("header.php");

$valid = 1;
$result = '';
$flag = 0;

if (isset($_POST['form1'])) {
    if (empty($_POST['ordid'])) {
        $valid = 0;
        $error_message = "Enter Order ID";
    }

    if ($valid == 1) {
        $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE order_id=?");
        $statement->execute(array($_POST['ordid']));
        $total = $statement->rowCount();
        $result = $statement->fetchAll();

        if ($total == 0) {
            $valid = 0;
            $error_message = "Enter Order ID";
        } else {
            $flag = 1;
            foreach ($result as $row) {
                $order_date = $row['datentime'];
                $order_status = $row['order_status'];
            }
        }
    }
}

?>

<div class="page-banner" style="background-color:#444;">
    <div class="inner">
        <h1 style="text-align:center;padding:30px;color:#fff">Track Order</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <br><br>
                    <h1>
                        <center>Track Order</center>
                    </h1>
                    <br>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="col-md-12">
                            <div class="user-content" style="text-align:center;">
                                <table class="table table-bordered" style="width:50%; margin:0 auto;">
                                    <tbody>
                                        <?php
                                        if ($error_message != '') {
                                            echo "<div class='error' style='padding: 10px;background:#dc3545;margin-bottom:20px;color:#fff;width:540px;margin:0 auto;'>".$error_message."</div><br>";
                                        }
                                        ?>
                                        <tr>
                                            <td class="align-middle text-right"><b>Order Number</b></td>
                                            <td>
                                                <input style="width:100%;height:40px;" type="number"
                                                    class="form-control" name="ordid">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input style="width:100%;height:40px;" type="submit" type="submit"
                                                    class="btn btn-primary" value="Search" name="form1">
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </form><br>
                    <?php

                        if ($flag == 1) {
                            ?>
                    <div class="col-md-12">
                        <div class="user-content" style="text-align:center;">
                            <table class="table" style="width:48%; margin:0 auto;">
                                <thead class="bg-danger">
                                    <tr>
                                        <th colspan="2" align="center" style="padding:0.20em;">
                                            <span style="font-size:25px; color:#fff;">Order Status</span>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="40%;" style="font-size:20px;" align="center"><b>Order Date</b></td>
                                        <td width="60%;" style="font-size:20px;"><?php if (isset($order_date)) {
                                echo $order_date;
                            } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="font-size:20px;"><b>Order Status</b></td>
                                        <td align="center" style="font-size:20px;"><?php if (isset($order_status)) {
                                echo ucwords($order_status);
                            } ?>
                                        </td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                    <?php
                        }
                ?>

                </div>
            </div>
        </div>
    </div>
</div>
<br>
<?php include("footer.php"); ?>
</body>

</html>