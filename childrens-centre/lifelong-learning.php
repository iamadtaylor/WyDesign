<!--
	childrens-centre -  lifelong-learning
-->
<?php $page = 'cc' ;?>
<?php include('../edit/runtime.php'); ?>
<?php include('../head.php'); ?>
<?php include('../edit/plugins/archiveExtractor/archiveExtractor.php');?>


<body>
<?php include('../nav.php'); ?>

<?php include('../subnav.php'); ?>


	<div id="headerBackground">
		<div id="header">
				<h1><?php perch_content('Page Title'); ?></h1>
		</div><!-- #header -->
	</div><!-- #headerBackground -->
	
	<div id="classes" class="section">
		
		<div id="content" class="column eight">
			<?php perch_content('Life long learning blurb'); ?>

		</div><!-- #content -->
		
		<div class="column four">
			<ul>
			<?php
				$archive = archiveExtractor('Lifelong Learning Courses','/childrens-centre/lifelong-learning.php');

				$limit = count($archive);

				for ($i=0; $i < $limit; $i++) { 
					echo '<li><a href="#'.$archive[$i]->course_id.'" title="'.$archive[$i]->course_title.'">'.$archive[$i]->course_title.'</a></li>';
				}
			
			
			?></ul>
			
		</div><!-- .column -->

		
		<div class="clear"></div>
		
		<?php perch_content('Lifelong Learning Courses'); ?>
		
	</div><!-- .section -->
	
<?php include('../footer.php'); ?>
