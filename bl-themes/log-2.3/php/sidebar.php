<!-- Intro -->
<section id="intro">
	<header>
		<h2><?php echo $site->title() ?></h2>
		<p><?php echo $site->slogan() ?></p>
	</header>
</section>

<?php Theme::plugins('siteSidebar') ?>

<!-- Footer -->
<section id="footer">
	<ul class="icons">
	<?php
		 echo '<li><a href="https://vk.com/mirivlad" class="fa-vk"><span class="label">VK</span></a></li>';
		if($site->twitter()) {
			echo '<li><a href="'.$site->twitter().'" class="fa-twitter"><span class="label">Twitter</span></a></li>';
		}

		if($site->facebook()) {
			echo '<li><a href="'.$site->facebook().'" class="fa-facebook"><span class="label">Facebook</span></a></li>';
		}

		if($site->codepen()) {
			echo '<li><a href="'.$site->codepen().'" class="fa-codepen"><span class="label">CodePen</span></a></li>';
		}

		if($site->instagram()) {
			echo '<li><a href="'.$site->instagram().'" class="fa-instagram"><span class="label">Instagram</span></a></li>';
		}

		if($site->gitlab()) {
			echo '<li><a href="'.$site->gitlab().'" class="fa-gitlab"><span class="label">GitLab</span></a></li>';
		}

		if($site->github()) {
			echo '<li><a href="'.$site->github().'" class="fa-github"><span class="label">GitHub</span></a></li>';
		}

		if($site->linkedin()) {
			echo '<li><a href="'.$site->linkedin().'" class="fa-linkedin"><span class="label">LinkedIn</span></a></li>';
		}
		
		if($site->mastodon()) {
			echo '<li><a href="'.$site->mastodon().'" class="fa-mastodon"><span class="label">Mastodon</span></a></li>';
		}

		if( $plugins['all']['pluginRSS']->installed() ) {
			echo '<li><a href="'.DOMAIN_BASE.'rss.xml'.'" class="fa-rss"><span class="label">RSS</span></a></li>';
		}

		if( $plugins['all']['pluginSitemap']->installed() ) {
			echo '<li><a href="'.DOMAIN_BASE.'sitemap.xml'.'" class="fa-sitemap"><span class="label">Sitemap</span></a></li>';
		}
	?>
	</ul>
	<p class="copyright"><?php echo $site->footer() ?> | <a href="http://www.bludit.com">BLUDIT</a></p>
</section>
