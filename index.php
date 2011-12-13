<?php include('perch/runtime.php'); ?>
<?php 
$thisPage="Home";
$pgDesc = 'Page Description here';
$keyWords = 'Keywords here';
include ('header.php');
?>

<div class="container" id="homeMain">
    <div id="flashWrapper">
      <div id="flashRow" class="row">
        <div class="row twelvecol last">
          <?php perch_content('Homepage flash intro'); ?>
        </div>
      </div>
    </div>
	<div id="contentWrapper">
    	<div class="row">
        	<div class="heroText twelvecol last">
            	<?php perch_content('Hero text'); ?>
            </div>
                <a class="heroLink calloutLink" href="/our_story">Hear our story</a>            
        </div>
    	<div class="row">
        	<div class="twelvecol last heroClients">
            	<h3>Our Clients</h3>
                <hr />
                <a href="/customers"><?php perch_content('Hero clients'); ?></a>
            </div>	
            <a class="heroLink calloutLink" href="/customers">Meet our customers</a>            
        </div>  
    	<div class="row">
        	<div class="twelvecol last heroProducts">
            <h3>Our Products</h3>
            <hr />
                <?php perch_content('Hero products'); ?>
                <br />
                            <a class="heroLink calloutLink" href="/products">See our products</a>
            </div>	

        </div>   

    
    
</div>

<?php include('footer.php'); ?>