<!--
	Parents -  prospectus
-->
<?php $page = 'p' ;?>
<?php include('../edit/runtime.php'); ?>
<?php include('../head.php'); ?>

<body>
<?php include('../nav.php'); ?>

<?php include('../subnav.php'); ?>


	<div id="headerBackground">
		<div id="header">
				<h1><?php perch_content('Title'); ?></h1>
		</div><!-- #header -->
	</div><!-- #headerBackground -->
	
	<div id="prospectus" class="section">
		
		<div id="content" class="column seven">
			<img src="../img/uniform/children-in-unifrm.png" width="435" height="441" alt="Children In Unifrm"/>
			

		</div><!-- .column -->
		
		<div class="column five">
			<?php perch_content('Prospectus blurb'); ?>
			
			<?php perch_content('prospectus file'); ?>
			
		</div><!-- .column -->

		
		<div class="clear"></div>
		
	</div><!-- .section -->
	
<?php include('../footer.php'); ?>
