<!--
	Parents -  special-dates
-->
<?php 
$page = 'p' ;
$script = "dates.js";
include('../edit/runtime.php');
include('../head.php');
?>

<body>
<?php include('../nav.php'); ?>

<?php include('../subnav.php'); ?>


	<div id="headerBackground">
		<div id="header">
				<h1>Wychall Primary School and Children's Centre</h1>
		</div><!-- #header -->
	</div><!-- #headerBackground -->
	
	<div id="special-dates" class="section">
		
		<div id="content" class="column six">
			<h3>School trips</h3>
			<table>
				<tr>
					<th>Date</th>
					<th>Classes</th>
					<th>Destination</th>
				</tr>
				
				<?php perch_content('School Trips') ?>
				
			</table>

		</div><!-- #content -->
		
		<div class="column six">
			<h3>Dates for the calendar</h3>
			<ul class="dates">

				<?php perch_content('Dates for the calendar') ?>

			</ul>
		
		</div><!-- .column -->

		
		<div class="clear"></div>
		
	</div><!-- .section -->
	
<?php include('../footer.php'); ?>
