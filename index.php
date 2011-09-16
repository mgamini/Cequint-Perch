<?php include('perch/runtime.php'); ?>
<?php 
$thisPage="Home";
$pgDesc = 'Page Description here';
$keyWords = 'Keywords here';
include ('header.php');
?>

<div class="container">
    <div id="flashWrapper">
      <div id="flashRow" class="row">
        <div class="row twelvecol last">
          <?php perch_content('Homepage flash intro'); ?>
        </div>
      </div>
    </div>
	<div id="contentWrapper">
    	<div class="row twelvecol last">
        	<div id="heroText">
            	<?php perch_content('Hero text'); ?>
            </div>
                <a class="heroLink" href="/our_story">Hear our story</a>            
        </div>
    	<div class="row twelvecol last">
        	<div id="heroClients">
            	<h3>Our Clients</h3>
                <hr />
                <?php perch_content('Hero clients'); ?>
            </div>	
            <a class="heroLink" href="/customers">Meet our customers</a>            
        </div>  
    	<div class="row twelvecol last">
        	<div id="heroProducts">
                <?php perch_content('Hero products'); ?>
            </div>	
            <a class="heroLink" href="/products">See our products</a>            
        </div>   
        <div class="row twelvecol last">
        	<div id="heroPositions">
                <?php perch_content('Current Positions'); ?>
            </div>	
            <a class="heroLink" href="/careers">See our open positions</a>            
        </div>       
    </div>
    
    
</div>

<?php include('footer.php'); ?>