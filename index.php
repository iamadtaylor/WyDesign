<!--
	HOMEPAGE
-->
<?php include('edit/runtime.php'); ?>
<?php include('head.php'); ?>
<?php include('plugins/archiveExtractor.php');?>

<body>
	
	<?php include('nav.php'); ?>
		
	<div id="headerBackground">
			<div id="header">
			<img src="/css/grid.png" width="435" height="300" alt="Grid"/>
		
	
			<div id="homeContent">
				<h1>Wychall Primary School and Children's Centre</h1>
				<p>Wychall Primary school aims to develop young people from 3 to 11 years, providing a safe, secure environment that ensures children are confident to explore, challenge and enjoy their learning, so optimising their individual potential to achieve.</p>
				<p>We are a dedicated staff that works to ensure that school provides a warm, welcoming and stimulating surroundings for all children, with an emphasis on the provision of high quality teaching and learning.</p>
			</div>
			<div class="clear"></div>
		</div><!-- #header -->
	</div><!-- #headerBackground -->
	
		<div id="content" class="section three-column">
		
		<div id="parents" class="column homepage">
	
			<h2>Parents</h2>
	
			<ol>
			<?php
				$archive = archiveExtractor('Dates for the calendar','/parents/special-dates.php');

				$limit = count($archive);
				// $limit = 2;

				for ($i=0; $i < $limit; $i++) { 
					echo '<li>'.$archive[$i]->event_name.'</li>';
				}
			
			
			?>
			   <li>
					<h3>Uniforms</h3>
					<p>dont forget this that or the other. order forms are <a href="#here" title="here">here</a></p>
				</li>
		
				<li>
		
					<h3>Term and Holiday dates</h3>
					<p>Welcome to our parents page where you"ll find dates, special events, topics, newletters and clubs that you need to know for this term... </p>
				</li>
		
				<li>
		
					<h3>School Trips</h3>
					<p>dont forget this that or the other. order forms are <a href="#here" title="here">here</a></p>
				</li>
				
				<li>
		
					<h3>School Clubs</h3>
					<p>dont forget this that or the other. order forms are <a href="#here" title="here">here</a></p>
				</li>
			</ol>

		</div><!-- #parents -->

		<div id="children" class="column homepage">
	
			<h2>Children</h2>
	
			<ol>
			   <li>
					<h3>Uniforms</h3>
					<p>dont forget this that or the other. order forms are <a href="#here" title="here">here</a></p>
				</li>
		
				<li>
		
					<h3>Uniforms</h3>
					<p>dont forget this that or the other. order forms are <a href="#here" title="here">here</a></p>
				</li>
		
				<li>
		
					<h3>Uniforms</h3>
					<p>dont forget this that or the other. order forms are <a href="#here" title="here">here</a></p>
				</li>
			</ol>
	
		</div><!-- #children -->

		<div id="anyone" class="column  homepage">
	
			<h2>Everyone	</h2>
	
			<ol>
			   <li>
					<h3>Uniforms</h3>
					<p>dont forget this that or the other. order forms are <a href="#here" title="here">here</a></p>
				</li>
		
				<li>
		
					<h3>Uniforms</h3>
					<p>dont forget this that or the other. order forms are <a href="#here" title="here">here</a></p>
				</li>
		
				<li>
		
					<h3>Uniforms</h3>
					<p>dont forget this that or the other. order forms are <a href="#here" title="here">here</a></p>
				</li>
			</ol>
	
		</div><!-- #anyone -->
		<div class="clear"></div>
		
	</div><!-- .section -->
	
<?php include('footer.php'); ?>

