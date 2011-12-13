<?php include('perch/runtime.php'); ?>
<?php 
$thisPage="News";
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
        	<li><a href="#news" id="newsLink">Cequint in the news</a></li>
            <li><a href="#events" id="eventsLink">events</a></li>
            <li><a href="#awards" id="awardsLink">Awards and accolades</a></li>
        </ul>
    </div>
    <div id="main" class="tencol">
    	<div id="news" role="main">
      		<?php perch_content('News'); ?>
        </div>
    	<div id="events" role="main">
			<?php perch_content('Events'); ?>
        </div>    
    	<div id="awards" role="main">
			<?php perch_content('Awards'); ?>
        </div>     
    </div>
  </div>
</div>

<?php include('footer.php'); ?>