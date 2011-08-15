<?php include('perch/runtime.php'); ?>
<?php 
$thisPage="Home";
$pgDesc = 'Page Description here';
$keyWords = 'Keywords here';
include ('header.php');
?>


<div id="flashWrapper" class="container">
  <div id="flashRow" class="row">
    <div class="row twelvecol last">
      <?php perch_content('Homepage flash intro'); ?>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>