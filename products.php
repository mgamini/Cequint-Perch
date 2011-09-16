<?php include('perch/runtime.php'); ?>
<?php 
$thisPage="Products";
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
  <div id="content" class="row tabs">
  	<div id="sidebar" class="twocol last">
		<ul class="sideTabs">
        	<li><a href="#ecid" id="ecidLink">Enhanced Caller ID</a></li>
            <li><a href="#stories" id="storiesLink">Best Mobile Caller ID Stories</a></li>
        </ul>
    </div>
    <div id="main" class="tencol">
    	<div id="ecid" role="main">
      		<?php perch_content('ECID'); ?>
        </div>
    	<div id="stories" role="main">
			<?php perch_content('Stories'); ?>
        </div>         
    </div>
  </div>
</div>

<?php include('footer.php'); ?> 