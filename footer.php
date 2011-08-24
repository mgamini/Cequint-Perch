<div id="footerWrapper" class="container">
  <footer id="footer" role="contentinfo" class="row">
    <div id="footerbar" class="twelvecol last">
    	<p><?php perch_content('Copyright info');?></p>
    </div>
  </footer>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/jquery-ui.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script> 
<script src="js/plugins.js"></script> 
<script src="js/script.js"></script> 
<script src="js/jquery.ba-bbq.min.js"></script>
<script type="text/javascript">
$(function(){
	
var tabs = $('.tabs'),
tab_a_selector = 'ul.sideTabs a';
tabs.tabs({ event: 'change', fx: { opacity: 'toggle' } });

tabs.find( tab_a_selector ).click(function(){
	var state = {},
	id = $(this).closest( '.tabs' ).attr( 'id' ),
	idx = $(this).parent().prevAll().length;
	state[ id ] = idx;	$.bbq.pushState( state );

});

$(window).bind( 'hashchange', function(e) {
	tabs.each(function(){
		var idx = $.bbq.getState( this.id, true ) || 0;
		$(this).find( tab_a_selector ).eq( idx ).triggerHandler( 'change' );
	});
})
$(window).trigger( 'hashchange' );


var myimages=new Array()
function preloadimages(){
for (i=0;i<preloadimages.arguments.length;i++){
myimages[i]=new Image()
myimages[i].src=preloadimages.arguments[i]
}
}

preloadimages("http://localhost/perch/images/linkCalloutHover.png, http://localhost/perch/images/icons/caller_id_stories_selected.png, http://localhost/perch/images/icons/community_selected.png, http://localhost/perch/images/icons/enhanced_id_selected.png, http://localhost/perch/images/icons/events_selected.png, http://localhost/perch/images/icons/evolution_selected.png, http://localhost/perch/images/icons/leadership_selected.png, http://localhost/perch/images/icons/management_selected.png, http://localhost/perch/images/icons/meet_people_selected.png, http://localhost/perch/images/icons/news_selected.png, http://localhost/perch/images/icons/perks_selected.png, http://localhost/perch/images/icons/positions_selected.png, http://localhost/perch/images/icons/rewards_selected.png, http://localhost/perch/images/icons/why_join_selected.png")

$('div.peopleFlyout .photo').hover(function(){
	$(this).siblings('.quote').fadeIn('fast');
},function(){
	$(this).siblings('.quote').fadeOut('fast');
});

});
</script>
<!--[if lt IE 7 ]>
	<script src="js/libs/dd_belatedpng.js"></script>
	<script> DD_belatedPNG.fix('img, .png_bg');</script>
	<![endif]--> 
<script>
		var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']]; // Change UA-XXXXX-X to be your site's ID
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
</body>
</html>