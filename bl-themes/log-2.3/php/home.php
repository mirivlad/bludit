<!-- Show each post on this page -->
<?php foreach ($content as $page): ?>

<article class="post">

	<!-- Show plugins, Hook: Post Begin -->
	<?php Theme::plugins('pageBegin') ?>

	<!-- Post's header -->
	<header>
		<div class="title">
			<h1><a href="<?php echo $page->permalink() ?>"><?php echo $page->title() ?></a></h1>
			<p><?php echo $page->description() ?></p>
		</div>
		<div class="meta">
	                <?php
	                	// Get the user who created the post.
	                	$User = $page->user();

	                	// Default author is the username.
	                	$author = $User->username();

	                	// If the user complete the first name or last name this will be the author.
						if( Text::isNotEmpty($User->firstName()) || Text::isNotEmpty($User->lastName()) ) {
							$author = $User->firstName().' '.$User->lastName();
						}
			?>
			<time class="published" datetime="<?php echo $page->date() ?>"><?php echo $page->date() ?></time>
		</div>
	</header>

	<!-- Cover Image -->
	<?php
		if($page->coverImage()) {
			echo '<a href="'.$page->permalink().'" class="image featured"><img src="'.$page->coverImage().'" alt="Cover Image"></a>';
		}else{
			// Get the Plugin-Object
			$pluginOpenGraph = getPlugin("pluginOpenGraph");
/* 			echo "<pre>";
			var_dump($pluginOpenGraph); die();
			echo "</pre>"; */
			// Print the plugin label
			if (Text::isNotEmpty($pluginOpenGraph->db['defaultImage'])) {
				$img = $pluginOpenGraph->db['defaultImage'];
				echo '<a href="'.$page->permalink().'" class="image featured"><img src="'.$img.'" alt="Cover Image"></a>';
			}
		}
	?>

	<!-- Post's content, the first part if has pagebrake -->
	<?php echo $page->contentBreak(); ?>
	
	<!-- Post's footer -->
	<footer>

		<!-- Read more button -->
	        <?php if($page->readMore()) { ?>
		<ul class="actions">
			<li><a href="<?php echo $page->permalink() ?>" class="button"><?php $L->p('Read more') ?></a></li>
		</ul>
		<?php } ?>

		<!-- Post's tags -->
		<ul class="stats">
		<?php
			$pageTags = $page->tags(true);

			foreach($pageTags as $tagKey=>$tagName) {
				echo '<li><a href="'.HTML_PATH_ROOT.$url->filters('tag').'/'.$tagKey.'">'.$tagName.'</a></li>';
			}
		?>
		</ul>
	</footer><br>
<script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="https://yastatic.net/share2/share.js"></script>
<div class="ya-share2" style="margin-left: -0.5em;" data-services="vkontakte,facebook,odnoklassniki,twitter,linkedin,lj,pocket,tumblr,viber,whatsapp,skype,telegram"></div>
	<!-- Plugins Post End -->
	<?php Theme::plugins('pageEnd') ?>

</article>

<?php endforeach; ?>

<!-- Pagination -->
<?php if (Paginator::numberOfPages()>1): ?>
	<ul class="actions pagination">

	<!-- Show previus page link -->
	<?php if(Paginator::showPrev()) { ?>
		<li><a href="<?php echo Paginator::previousPageUrl() ?>" class="button big previous"><?php $L->p('Previous Page') ?></a></li>
    <?php } ?>

	<!-- Show next page link -->
	<?php if(Paginator::showNext()) { ?>
		<li><a href="<?php echo Paginator::nextPageUrl() ?>" class="button big next"><?php $L->p('Next Page') ?></a></li>
    <?php } ?>

	</ul>
<?php endif ?>
