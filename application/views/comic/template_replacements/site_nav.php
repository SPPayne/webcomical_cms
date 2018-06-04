<nav id="site_navbar" class="navbar navbar-default">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#site_navbar_items" aria-controls="site_navbar_items" aria-expanded="false" aria-label="Toggle navigation">
			<span class="sr-only">Toggle site navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand hidden-sm hidden-md hidden-lg" href="#">
			Navigate Site:
		</a>
	</div>
	<div class="navbar-collapse collapse" id="site_navbar_items">
		<ul class="nav navbar-nav">
			<li <?php if($this->router->fetch_method() == "index"){ ?>class="active"<?php } ?>>
				<a class="nav-link" href="/">Home</a>
			</li>
			<?php if(isset($site['about']) && $site['about']){ ?>
				<li <?php if($this->router->fetch_method() == "about"){ ?>class="active"<?php } ?>>
					<?php $this->load->view('comic/template_replacements/link_about'); ?>
				</li>
			<?php } ?>
			<?php if(isset($site['archive']) && $site['archive']){ ?>
				<li <?php if($this->router->fetch_method() == "archive"){ ?>class="active"<?php } ?>>
					<?php $this->load->view('comic/template_replacements/link_archive'); ?>
				</li>
			<?php } ?>
			<?php if(isset($site['characters']) && $site['characters']){ ?>
				<li <?php if($this->router->fetch_method() == "character_profiles"){ ?>class="active"<?php } ?>>
					<?php $this->load->view('comic/template_replacements/link_profiles'); ?>
				</li>
			<?php } ?>
		</ul>
		<div class="navbar-form form-inline pull-right">
			<?php $this->load->view('comic/template_replacements/search_bar'); ?>
		</div>
	</div>
</nav>
