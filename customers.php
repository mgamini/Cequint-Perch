<?php include('perch/runtime.php'); ?>
<?php 
$thisPage="Customers";
$pgDesc = 'Page Description here';
$keyWords = 'Keywords here';
include ('header.php');
?>


<div id="flashWrapper" class="container">
  <div id="flashRow" class="row">
    <div class="twelvecol last">
      <?php perch_content('Flash Intro'); ?>
    </div>
  </div>
</div>

<div id="contentWrapper" class="container">
  <div id="customersContent" class="row tabs">
    <div id="main" class="tencol">
    	<div id="customers" role="main">
      		<?php perch_content('Testimonials'); ?>
        </div>        
    </div>
  	<div id="ourCustomers" class="twocol last">
		<?php perch_content('Our Customers'); ?>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>