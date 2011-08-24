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
  <div id="content" class="row tabs">
  	<div id="sidebar" class="twocol last">
		<ul class="sideTabs">
        	<li><a href="#evolution" id="evolutionLink">Evolution</a></li>
            <li><a href="#leadership" id="leadershipLink">Leadership</a></li>
            <li><a href="#community" id="communityLink">Community</a></li>
        </ul>
    </div>
    <div id="main" class="tencol">
    	<div id="evolution" role="main">
      		<?php perch_content('Evolution'); ?>
        </div>
    	<div id="leadership" role="main">
			<?php perch_content('Leadership'); ?>
        </div>
    	<div id="community" role="main">
      		<?php perch_content('Community'); ?>
        </div>                
    </div>
  </div>
</div>

<?php include('footer.php'); ?>