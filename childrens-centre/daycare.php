<!--
	childrens-centre -  daycare
-->
<?php $page = 'cc' ;?>
<?php include('../edit/runtime.php'); ?>
<?php include('../head.php'); ?>

<body>
<?php include('../nav.php'); ?>

<?php include('../subnav.php'); ?>


	<div id="headerBackground">
		<div id="header">
				<h1><?php perch_content('Page Title'); ?></h1>
		</div><!-- #header -->
	</div><!-- #headerBackground -->
	
	<div id="daycare" class="section">
		
		<div id="content" class="column seven">
			<?php perch_content('Daycare Blurb'); ?>
			

		</div><!-- #content -->
		
		<div class="column five">
			<img src="../img/uniform/children-in-unifrm.png" width="435" height="441" alt="Children In Unifrm"/>
		</div><!-- .column -->
	
		<div class="three-column">
			<div class="column">
				<?php perch_content('Tiny Tots'); ?>
			</div><!-- .column -->
			
			<div class="column">
				<?php perch_content('Little Nippers'); ?>
			</div><!-- .column -->
			
			<div class="column">
				<?php perch_content('Explorers'); ?>
			</div><!-- .column -->
			
		</div><!-- .three-column -->
		<div class="clear"></div>
		<div class="column six">
			<h2><?php perch_content('Daycare Costs Title'); ?></h2>
			<table>
				<?php perch_content('Daycare Costs Table'); ?>
			</table>
			
			<?php perch_content('Daycare Costs Additional Information'); ?>
		</div><!-- .column -->
		<div class="column six">
			<h2><?php perch_content('Daycare Contact Details Titles'); ?></h2>
			<?php perch_content('Daycare Contact Details'); ?>
			<?php perch_content('Daycare prospectus'); ?>
		</div><!-- .column -->
	</div><!-- .section -->
	
<?php include('../footer.php'); ?>
