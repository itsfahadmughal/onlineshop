<?php include("header.php"); ?>

  <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Our Services</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Our Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Services  -->
    <div class="services-box-main">
        <div class="container">
            <div class="row my-5">
            <?php
                $statement = $pdo->prepare("SELECT * FROM tbl_service where show_status=1");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
            ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="service-block-inner">
                        <h3><?php echo $row['title']; ?></h3>
                        <p><?php echo $row['content']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>