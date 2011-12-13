<?php include('perch/runtime.php'); ?>
<?php 
$thisPage="Careers";
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
       		<li><a href="#ourpeople" id="ourpeopleLink">Meet our people</a></li>
        	<li><a href="#whyjoin" id="whyjoinLink">Why join our team?</a></li>
            <li><a href="#positions" id="positionsLink">Current Positions</a></li>
            <li><a href="#perks" id="perksLink">Perks & Benefits</a></li>
        </ul>
    </div>
    <div id="main" class="tencol">
    	<div id="ourpeople" role="main">
			<?php perch_content('Meet Our People'); ?>
            <a href="#positions" class="calloutLink">See Current Positions</a>
        </div>  
    	<div id="whyjoin" role="main">
      		<?php perch_content('Why Join Our Team?'); ?>
        </div>  
    	<div id="positions" role="main">
			<?php perch_content('Current Positions'); ?>
        </div>     
    	<div id="perks" role="main">
			<?php perch_content('Perks and Benefits'); ?>
        </div>  
    </div>
  </div>
</div>

<?php include('footer.php'); ?>