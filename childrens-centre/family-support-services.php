<!--
	childrens-centre -  family-support-services
-->
<?php $page = 'cc' ;?>
<?php include('../edit/runtime.php'); ?>
<?php include('../head.php'); ?>

<body>
<?php include('../nav.php'); ?>

<?php include('../subnav.php'); ?>


	<div id="headerBackground">
		<div id="header">
				<h1><?php perch_content('Support Services Title'); ?></h1>
		</div><!-- #header -->
	</div><!-- #headerBackground -->
	
	<div id="support" class="section">
		
		<div class="column eight">
			<?php perch_content('Support Services Title and Blurb'); ?>
		</div><!-- .column -->
		<div class="column four">
			<h2><?php perch_content('Get Support Title'); ?></h2>
			<?php perch_content('Get Support Blurb'); ?>
		</div><!-- .column -->
		
		<div class="clear"></div>
		
		
		<div class="three-column">
			<hr />
			
			<?php perch_content('Support Services'); ?>

		</div><!-- .three-column -->
		
		<div class="clear"></div>
		
	</div><!-- .section -->
	
<?php include('../footer.php'); ?>
