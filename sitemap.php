<?php include("header.php"); ?>

<?php 

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $contact_map = $row['contact_map_iframe'];
}

?>

<div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
  <!--Main layout-->
<main class=" m-0 p-0">
  <div class="container-fluid m-0 p-0">

    <!--Google map-->
    <div id="map-container-google-4" class="z-depth-1-half map-container-4" style="height: 500px">
    <?php echo $contact_map; ?>
      <!-- <iframe src="https://maps.google.com/maps?q=manhatan&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
        style="border:0" allowfullscreen></iframe> -->
    </div>

  </div>
</main>

       
<?php include("footer.php"); ?>