<!--
	Parents -  school-meals
-->
<?php $page = 'p' ;?>
<?php include('../edit/runtime.php'); ?>
<?php include('../head.php'); ?>

<body>
<?php include('../nav.php'); ?>

<?php include('../subnav.php'); ?>


	<div id="headerBackground">
		<div id="header">
				<h1>Wychall Primary School and Children's Centre</h1>
		</div><!-- #header -->
	</div><!-- #headerBackground -->
	
	<div id="school-meals" class="section">
		
		<div id="content" class="column eight">
			<h2><?php perch_content('School Meals Title'); ?></h2>
			<?php perch_content('School Meals Information'); ?>
			

		</div><!-- #content -->
		
		<div class="column four">
			<img src="../img/icon/calendar.png" width="60" height="39" alt="Calendar"/>
			<h3><?php perch_content('Additional Item Title'); ?></h3>
			<ul>
				<?php perch_content('Additional Item List'); ?>
			</ul>
		</div><!-- .column -->
		
		<div class="column twelve first-in-row">
			<h3><?php perch_content('Example Menus Title'); ?></h3>
			<?php perch_content('Example Menus Blurb'); ?>
			
			<?php perch_content('Menu week 1'); ?>
			
			<?php perch_content('Menu week 2'); ?>
						
		</div><!-- .column -->

		
		<div class="clear"></div>
		
	</div><!-- .section -->
	
<?php include('../footer.php'); ?>
