<!--
	PARENTS -  term-dates
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
	
	<div id="term-dates" class="section">
		
		<div id="content" class="column">
			<?php perch_content('Term dates');?>
		</div><!-- #content -->
		
		<div class="column six">
			<?php perch_content('Additional term information');?>
		</div><!-- .column -->

		
		<div class="clear"></div>
		
	</div><!-- .section -->
	
<?php include('../footer.php'); ?>
