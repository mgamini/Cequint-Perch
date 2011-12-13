<?php include('perch/runtime.php'); ?>
<?php 
$thisPage="Contact";
$pgDesc = 'Page Description here';
$keyWords = 'Keywords here';
include ('header.php');
?>

<div id="contentWrapper" class="container">
  <div id="contactContent" class="row tabs">
	<div id="fullTitle" class="twelvecol last">
    	<?php perch_content('Header'); ?>
    </div>
  	<div id="location" class="fourcol">
		<?php perch_content('Address and Contact'); ?>
    </div>
    <div id="map" class="eightcol last">
      	<?php perch_content('Map'); ?>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>