<?php include('perch/runtime.php'); ?>
<?php 
$thisPage="Our Story";
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
  <div id="content" class="row">
  	<div id="sidebar" class="twocol last">
		<?php perch_pages_navigation(); ?>
    </div>
    <div class="tencol">
    	<div id="main" role="main">
      		<?php perch_content('Text Block'); ?>
        </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>