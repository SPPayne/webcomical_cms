<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php if($site['site_webby'] == "Yes"){ ?>
				<a class="navbar-brand hidden-xs hidden-sm hidden-md" href="<?php echo base_url(); ?>admin">
					<img style="margin-top:-15px;margin-right:-5px;height:50px;" alt="Webby the Clown Spider" title="It's Webby the terrifying and slightly annoying webcomic mascot! You can turn him off if you want to!" src="<?php echo base_url(); ?>assets/icons/webcomical_small.png" /> 
				</a>
			<?php } ?>
			<a class="hidden-sm hidden-md navbar-brand" href="<?php echo base_url(); ?>admin">
				<img style="height:25px;" alt="<?php echo $this->config->item('app_name','webcomic'); ?>" title="<?php echo $this->config->item('app_name','webcomic'); ?>" src="<?php echo base_url(); ?>assets/icons/webcomical_txt.png" /> 
			</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li>
					<a title="Visit admin panel" href="<?php echo base_url(); ?>admin"><span class="glyphicon glyphicon-home"></span> Admin panel</a>
				</li>
				<?php if(isset($page) && !empty($page)){ ?>
					<li>
						<a title="Edit this current page" href="<?php echo base_url(); ?>admin/create_page/<?php echo $page->comicid; ?>"><span class="glyphicon glyphicon-pencil"></span> Edit this page</a>
					</li>
				<?php } ?>
				<li class="dropdown">
					<a title="Pages" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="glyphicon glyphicon-duplicate"></span> Pages <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a title="Add new page" href="<?php echo base_url(); ?>admin/create_page"><span class="glyphicon glyphicon-plus"></span> Add new</a></li>
						<li><a title="Manage pages" href="<?php echo base_url(); ?>admin/manage_pages"><span class="glyphicon glyphicon-pencil"></span> Manage</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a title="Characters" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="glyphicon glyphicon-user"></span> Characters <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a title="Add new character" href="<?php echo base_url(); ?>admin/create_character"><span class="glyphicon glyphicon-plus"></span> Add new</a></li>
						<li><a title="Manage characters" href="<?php echo base_url(); ?>admin/manage_characters"><span class="glyphicon glyphicon-pencil"></span> Manage</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a title="Tags" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="glyphicon glyphicon-tags"></span> Tags <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a title="Add new tag" href="<?php echo base_url(); ?>admin/create_tag"><span class="glyphicon glyphicon-plus"></span> Add new</a></li>
						<li><a title="Manage tags" href="<?php echo base_url(); ?>admin/manage_tags"><span class="glyphicon glyphicon-pencil"></span> Manage</a></li>
					</ul>
				</li>
				<li>
					<a title="Webcomic Settings" href="<?php echo base_url(); ?>admin/webcomic_settings"><span class="glyphicon glyphicon-list"></span> Edit comic settings</a>
				</li>
				<li>
					<a title="Log out" href="<?php echo base_url(); ?>auth/logout"><span class="glyphicon glyphicon-log-out"></span> Log out</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- Push page down a little so we can see the header -->
<div>
	<br />
</div>
