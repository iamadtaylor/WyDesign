<!--
	childrens-centre -  wigwam
-->
<?php $page = 'cc' ;?>
<?php include('../edit/runtime.php'); ?>
<?php include('../head.php'); ?>

<body>
<?php include('../nav.php'); ?>

<?php include('../subnav.php'); ?>


	<div id="headerBackground">
		<div id="header">
				<h1 id="wigwam-header">WIGWAM</h1>
		</div><!-- #header -->
	</div><!-- #headerBackground -->
	
	<div id="wigwam" class="section">
		
		<div id="content" class="column eight">
			<h2>What is Wigwag?</h2>
			<p>The Wigwam club offers safe childcare for children before school, after school and even during holiday and school closures.
			The children are offer the chance to take part in fun activities as well as exciting trips throughout the year.</p>
		</div><!-- #content -->
		
		<div class="column four">
			<h2>Contact</h2>
			<p>For any enquires please contact: Marlene Owens, Childcare Co-ordinator, 0121 464 3974</p>
		</div><!-- .column -->
	
		<div class="clear"></div>
		
		<div class="three-column">
			<hr />
			
			<?php perch_content('Wigwam Clubs'); ?>

		</div><!-- .three-column -->
		
	</div><!-- .section -->
	
<?php include('../footer.php'); ?>
