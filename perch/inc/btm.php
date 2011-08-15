<?php
    if ($CurrentUser->logged_in()) {
        echo '</div>';
    }
?>
    <div id="footer">
		<div class="credit">
            <?php
                if (!$Settings->get('hideBranding')->settingValue()) {
            ?>
			<p><a href="http://grabaperch.com"><img src="<?php echo PERCH_LOGINPATH; ?>/assets/img/perch.gif" width="35" height="12" alt="Perch" /></a>
			<?php echo PerchUtil::html(PerchLang::get('by')); ?> <a href="http://edgeofmyseat.com">edgeofmyseat.com</a></p>
            <?php
                }else{
                    echo '&nbsp;';
                }
        	?>
		</div>
    <?php  if ($CurrentUser->logged_in()) { ?>	
		<div class="version">
		    <?php
		        if (($CurrentUser->userRole() == 'Admin') && ($Perch->version < $Settings->get('latest_version')->settingValue())) {
		            echo '<a href="http://grabaperch.com/update">' . sprintf(PerchLang::get('You are running version %s - a newer version is available.'), $Perch->version) . '</a>';
		        }
		    
		    ?>
		</div>
	<?php  } ?>
	</div>
<?php
    if (!$CurrentUser->logged_in()) {
        echo '</div>';
    }
?>	
    <script type="text/javascript">
        Perch.Lang.init({
            'Apps':'<?php echo PerchLang::get('Apps'); ?>'
        });
    </script>
    <?php if (PERCH_DEBUG) PerchUtil::output_debug(); ?>
</body>
</html>
