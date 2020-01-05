<article class="post">

	<!-- Plugins Page Begin -->
	<?php Theme::plugins('pageBegin') ?>

	<!-- Post's header -->
	<header>
		<div class="title">
			<h1><?php echo $page->title() ?></h1>
			<p><?php echo $page->description() ?></p>
		</div>
	</header>

	<!-- Cover Image -->
	<?php
		if($page->coverImage()) {
			echo '<a href="'.$page->permalink().'" class="image featured"><img src="'.$page->coverImage().'" alt="Cover Image"></a>';
		}
	?>

	<!-- Post's content, the first part if has pagebrake -->
	<?php echo $page->content() ?>

	<!-- Plugins Page End -->
	<?php Theme::plugins('pageEnd') ?>

</article>