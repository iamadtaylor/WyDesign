<?php
    if ($CurrentUser->logged_in()) {
        echo '</div>';
    }
?>
    <div id="footer">
		<div class="credit">
			<p><a href="http://grabaperch.com"><img src="<?php echo PERCH_LOGINPATH; ?>/assets/img/perch.gif" width="35" height="12" alt="Perch" /></a>
			<?php echo PerchUtil::html(PerchLang::get('by')); ?> <a href="http://edgeofmyseat.com">edgeofmyseat.com</a></p>
		</div>
    <?php  if ($CurrentUser->logged_in()) { ?>	
		<div class="version">
		    <?php
		        if ($Perch->version != $Settings->get('latest_version')->settingValue()) {
		            echo '<a href="http://grabaperch.com/update">' . PerchLang::get('You are running Perch') . ' ' .$Perch->version;
		            echo ' - ' . PerchLang::get('a newer version of Perch is available.') . '</a>';
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
    <?php if (PERCH_DEBUG) PerchUtil::output_debug(); ?>
</body>
</html>