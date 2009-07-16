<!--
	Out of school club
-->
<?php $script = "clubs.js"; ?>
<?php include('../edit/runtime.php'); ?>
<?php include('../head.php'); ?>

<body>
	
	<?php include('../nav.php'); ?>
		
	<div id="headerBackground">
			<div id="header">
			<img src="/css/grid.png" width="435" height="300" alt="Grid"/>
		
	
			<div id="content">
				<h1><?php perch_content('Page Title'); ?></h1>
				<?php perch_content('Out of school clubs blurb'); ?>
			</div>
			<div class="clear"></div>
		</div><!-- #header -->
	</div><!-- #headerBackground -->
	
		<div id="out-of-school-clubs" class="section">
		
		<div class="column nine">
	
			<h2>Our clubs</h2>
	
			<ul id="clubs">
				<?php perch_content('Clubs and details'); ?>
			</ul>

		</div>


		<div id="anyone" class="column three">
	
			<h2>How can your child join in?</h2>
	
			<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
			
			<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
	
		</div><!-- #anyone -->
		<div class="clear"></div>
		
	</div><!-- .section -->
	
<?php include('../footer.php'); ?>

