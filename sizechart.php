<?php
    include("header.php");
?>
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 

                    $statement = $pdo->prepare("SELECT * FROM tbl_sizechart");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                ?>
                    <img class="img-fluid" src="assets/uploads/<?php echo $row['sizechart_image']; ?>" />
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include("footer.php"); ?>
</body>

</html>