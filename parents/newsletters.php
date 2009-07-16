<!--
	Parents -  newsletters
-->
<?php $page = 'p' ;?>
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
	
	<div id="classes" class="section">
		
		<div id="content" class="column">
			<?php perch_content('Newsletter blurb'); ?>
			
			<ul>
				<?php perch_content('Newsletters'); ?>
			</ul>
			

		</div><!-- #content -->
		
		<div class="column four">
			<p>placeholder</p>
		</div><!-- .column -->

		
		<div class="clear"></div>
		
	</div><!-- .section -->
	
<?php include('../footer.php'); ?>
