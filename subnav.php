
<?php if ($page == 'p'): ?>

	<div class="subnavBackground">
		<ul id="subnav" class="section">
			<li><a href="newsletters.php" title="Wychall's Newsletters archive">Newsletters</a></li>
			<li><a href="term-dates.php" title="Wychall's term dates">Term dates</a></li>
			<li><a href="special-dates.php" title="Special dates for your calendars">Special dates</a></li>
			<li><a href="policy.php" title="Wychall's policies">Policies</a></li>
			<li><a href="prospectus.php" title="A printable version of the prospectus">Prospectus</a></li>
			<li><a href="school-meals.php" title="Sample school meals">School meals</a></li>
			<li><a href="uniform.php" title="Wychall's school uniform">Uniform</a></li>
		</ul>
	
	</div><!-- .subnavBackground -->
	
<?php elseif ($page == 'tandl'): ?>

	<div class="subnavBackground">
		<ul id="subnav" class="section">
			<li><a href="classes.php" title="Classes and staff">Classes and Staff</a></li>
			<li><a href="#nowhere" title="Aliquam tincidunt mauris eu risus">Pupils work</a></li>
			<li><a href="#nowhere" title="Morbi in sem quis dui placerat ornare">Current topics</a></li>
		</ul>
	
	</div><!-- .subnavBackground -->
	
<?php elseif ($page == 'cc'): ?>

	<div class="subnavBackground">
		<ul id="subnav" class="section">
			<li><a href="lifelong-learning.php" title="Lifelong learning">Lifelong learning</a></li>
			<li><a href="family-support-services.php" title="Family support services">Family support services</a></li>
			<li><a href="community-events.php" title="Community events">Community events</a></li>
			<li><a href="daycare.php" title="Daycare">Daycare</a></li>
			<li><a href="wigwam.php" title="WIGWAM">WIGWAM</a></li>
		</ul>
	
	</div><!-- .subnavBackground -->



<?php else : ?>


	<div class="subnavBackground">
		<ul id="subnav" class="section">
			<li><a href="#nowhere" title="Lorum ipsum dolor sit amet">Lorem</a></li>
			<li><a href="#nowhere" title="Aliquam tincidunt mauris eu risus">Aliquam</a></li>
			<li><a href="#nowhere" title="Morbi in sem quis dui placerat ornare">Morbi</a></li>
			<li><a href="#nowhere" title="Praesent dapibus, neque id cursus faucibus">Praesent</a></li>
			<li><a href="#nowhere" title="Pellentesque fermentum dolor">Pellentesque</a></li>
		</ul>
	
	</div><!-- .subnavBackground -->



<?php endif; ?>