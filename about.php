<?php include("header.php"); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $about_title = $row['about_title'];
    $about_content = $row['about_content'];
    $about_banner = $row['about_banner'];
}
?>

    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo $about_title; ?></h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $about_title; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start About Page  -->
    <div class="about-box-main">
        <!-- <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="noo-sh-title">Who We are</h2>
                    <p>"Welcome! We are the owner of H_F Clothing Brand.We have a huge collections of ready meade cloths, acessories as well as custom cut and sew facility to customize cloths according to your desires and demand.We're dedicated to giving you the very best of our products.We communicate directly with our tailors in Sialkot, Pakistan, to make sure that every single person involved in the making of our clothes is treated fairly. This way, no one slips under the radar, and no one is invisible.We provide important information about our tailors, right here on this website, so that everyone is able to have access to information about how their clothes are made. This means people are able to see that no one has been harmed or exploited in the making of their clothes, which is sadly the reality in many other cases."</p>
                </div>
                <div class="col-lg-6">
                    <div class="banner-frame"> <img class="img-thumbnail img-fluid" src="assets/images/about-img.jpg" alt="" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="service-block-inner">
                        <h3>We are Trusted</h3>
                        <p>Always fascinated by distinguished styles, the company bent its efforts to bringing colors, designs, fabrics & magic together. The initiative turned out to be a success and the company quickly became popular for its quality.This meld of exquisite design and high class fabric has resulted in the breakthrough of a kind retail brand. </p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="service-block-inner">
                        <h3>We are Professional</h3>
                        <p> Traces its roots from 10 years remarkably recognized wholesale textile industry, being exclusive in designs patterns drifted towards the creation of brand 'H_F'.A high-street brand introduced in the textile industry, H_F is celebrated for combining 100% pure fabric with unprecedented design aesthetic to create designer wear at an affordable price.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="service-block-inner">
                        <h3>OUR STORIES</h3>
                        <p> Our range of clothing has something for everyone: Daily wear, party wear, formal wear, silk tunics, scarves and unstitched fabric. The overarching theme of the collections is providing affordable designer clothes to the masses.We provide the variaty of unstitched and custom cloth according to your design and measurements. </p>
                    </div>
                </div>
            </div>
        </div> -->
        <?php echo $about_content; ?>
    </div>
    <!-- End About Page  -->
    
<?php include("footer.php"); ?>
