<?php
	//Set sidebar value
	$sidebar = "";
	if($user->admin_sidebar == "OPEN"){
		$sidebar = "hidden-xs in";
	}
?>
<div class="column col-sm-2 col-xs-1 sidebar-offcanvas" id="sidebar">
	<?php if($settings['site_webby'] == "Yes"){ ?>
		<img class="center-block img-responsive" alt="Webby the Clown Spider" title="It's Webby the terrifying and slightly annoying <?php echo $this->config->item('app_name','webcomic'); ?> mascot!" src="/assets/icons/webcomical.png" />
	<?php } ?>
	<ul class="nav" id="menu">
		<li>
			<a title="Minimise Sidebar" id="minimise" data-toggle="offcanvas">
				<span class="glyphicon glyphicon-resize-horizontal"></span>&nbsp;
				<span class="collapse <?php echo $sidebar; ?>">Minimise Sidebar</span>
			</a>
		</li>
		<li>
			<a title="View Site" href="/">
				<span class="glyphicon glyphicon-new-window"></span>&nbsp;
				<span class="collapse <?php echo $sidebar; ?>">View Site</span>
			</a>
		</li>
		<li>
			<a title="User Management" <?php if(stristr(uri_string(),'user') || stristr(uri_string(),'manage_password')){ ?>class="active"<?php } ?> data-target="#admin-user" data-toggle="collapse">
				<span class="glyphicon glyphicon-user"></span>&nbsp;
				<span class="collapse <?php echo $sidebar; ?>">User Management <span class="glyphicon glyphicon-triangle-bottom"></span></span>
			</a>
			<ul class="nav nav-stacked left-submenu <?php if(!stristr(uri_string(),'user') && !stristr(uri_string(),'change_password')){ ?>collapse<?php } else { ?>in<?php } ?>" id="admin-user">
				<li>
					<a title="Create a new user" <?php if(stristr(uri_string(),'create_user')){ ?>class="active"<?php } ?> href="/admin/create_user/">
						<span class="glyphicon glyphicon-plus"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Create a new user</span>
					</a>
				</li>
				<li>
					<a title="Edit your profile" <?php if(stristr(uri_string(),'manage_users') && $this->uri->segment(3) == $user->id){ ?>class="active"<?php } ?> href="/admin/manage_users/<?php echo $user->id; ?>">
						<span class="glyphicon glyphicon-pencil"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Edit your profile</span>
					</a>
				</li>
				<li>
					<a title="Manage users" <?php if(stristr(uri_string(),'manage_users') && !$this->uri->segment(3)){ ?>class="active"<?php } ?> href="/admin/manage_users/">
						<span class="glyphicon glyphicon-sunglasses"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Manage users</span>
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a title="Webcomic Appearance" <?php if(stristr(uri_string(),'webcomic')){ ?>class="active"<?php } ?> data-target="#admin-appearance" data-toggle="collapse">
				<span class="glyphicon glyphicon-eye-open"></span>&nbsp;
				<span class="collapse <?php echo $sidebar; ?>">Webcomic Appearance <span class="glyphicon glyphicon-triangle-bottom"></span></span>
			</a>
			<ul class="nav nav-stacked left-submenu <?php if(!stristr(uri_string(),'webcomic')){ ?>collapse<?php } else { ?>in<?php } ?>" id="admin-appearance">
				<li>
					<a title="Settings" <?php if(stristr(uri_string(),'webcomic_settings')){ ?>class="active"<?php } ?> href="/admin/webcomic_settings/">
						<span class="glyphicon glyphicon-list"></span>
						<span class="collapse <?php echo $sidebar; ?>">Settings</span>
					</a>
				</li>
				<li>
					<a title="Template Themes" <?php if(stristr(uri_string(),'webcomic_appearance')){ ?>class="active"<?php } ?> href="/admin/webcomic_appearance/">
						<span class="glyphicon glyphicon-picture"></span>
						<span class="collapse <?php echo $sidebar; ?>">Template Themes</span>
					</a>
				</li>
				<li>
					<a title="Banners" <?php if(stristr(uri_string(),'webcomic_banners')){ ?>class="active"<?php } ?> href="/admin/webcomic_banners/">
						<span class="glyphicon glyphicon-modal-window"></span>
						<span class="collapse <?php echo $sidebar; ?>">Banners</span>
					</a>
				</li>
				<li>
					<a title="Navigation" <?php if(stristr(uri_string(),'webcomic_navigation')){ ?>class="active"<?php } ?> href="/admin/webcomic_navigation/">
						<span class="glyphicon glyphicon-move"></span>
						<span class="collapse <?php echo $sidebar; ?>">Navigation</span>
					</a>
				</li>
				<li>
					<a title="Favicon" <?php if(stristr(uri_string(),'webcomic_favicon')){ ?>class="active"<?php } ?> href="/admin/webcomic_favicon/">
						<span class="glyphicon glyphicon-star"></span>
						<span class="collapse <?php echo $sidebar; ?>">Favicon</span>
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a title="Pages Management" <?php if(stristr(uri_string(),'page')){ ?>class="active"<?php } ?> data-target="#admin-pages" data-toggle="collapse">
				<span class="glyphicon glyphicon-duplicate"></span>&nbsp;
				<span class="collapse <?php echo $sidebar; ?>">Pages Management <span class="glyphicon glyphicon-triangle-bottom"></span></span>
			</a>
			<ul class="nav nav-stacked left-submenu <?php if(!stristr(uri_string(),'page')){ ?>collapse<?php } else { ?>in<?php } ?>" id="admin-pages">
				<li>
					<a title="Edit 'about' page" <?php if(stristr(uri_string(),'about_page') && !$this->uri->segment(3)){ ?>class="active"<?php } ?> href="/admin/about_page/">
						<span class="glyphicon glyphicon-info-sign"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Edit 'About' Page</span>
					</a>
				</li>
				<li>
					<a title="Add a new comic page" <?php if(stristr(uri_string(),'create_page') && !$this->uri->segment(3)){ ?>class="active"<?php } ?> href="/admin/create_page/">
						<span class="glyphicon glyphicon-plus"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Add a new comic page</span>
					</a>
				</li>
				<li>
					<a title="Manage existing comic pages" <?php if(stristr(uri_string(),'manage_pages')){ ?>class="active"<?php } ?> href="/admin/manage_pages">
						<span class="glyphicon glyphicon-pencil"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Manage existing comic pages</span>
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a title="Chapter Management" <?php if(stristr(uri_string(),'chapter')){ ?>class="active"<?php } ?> data-target="#admin-chapters" data-toggle="collapse">
				<span class="glyphicon glyphicon-tasks"></span>&nbsp;
				<span class="collapse <?php echo $sidebar; ?>">Chapter Management <span class="glyphicon glyphicon-triangle-bottom"></span></span>
			</a>
			<ul class="nav nav-stacked left-submenu <?php if(!stristr(uri_string(),'chapter')){ ?>collapse<?php } else { ?>in<?php } ?>" id="admin-chapters">
				<li>
					<a title="Add a new comic chapter" <?php if(stristr(uri_string(),'create_chapter/chapter') && !$this->uri->segment(4)){ ?>class="active"<?php } ?> href="/admin/create_chapter/chapter">
						<span class="glyphicon glyphicon-align-justify"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Add a new comic chapter</span>
					</a>
				</li>
				<li>
					<a title="Add a new comic subchapter" <?php if(stristr(uri_string(),'create_chapter/subchapter')){ ?>class="active"<?php } ?> href="/admin/create_chapter/subchapter">
						<span class="glyphicon glyphicon-align-left"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Add a new comic subchapter</span>
					</a>
				</li>
				<li>
					<a title="Manage comic chapters" <?php if(stristr(uri_string(),'manage_chapters')){ ?>class="active"<?php } ?> href="/admin/manage_chapters/">
						<span class="glyphicon glyphicon-pencil"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Manage comic chapters</span>
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a title="Characters and Tags" <?php if(stristr(uri_string(),'character') || stristr(uri_string(),'tag')){ ?>class="active"<?php } ?> data-target="#admin-characters" data-toggle="collapse">
				<span class="glyphicon glyphicon-tags"></span>&nbsp;
				<span class="collapse <?php echo $sidebar; ?>">Characters and Tags <span class="glyphicon glyphicon-triangle-bottom"></span></span>
			</a>
			<ul class="nav nav-stacked left-submenu <?php if(!stristr(uri_string(),'character') && !stristr(uri_string(),'tag')){ ?>collapse<?php } else { ?>in<?php } ?>" id="admin-characters">
				<li>
					<a title="Add a new character profile" <?php if(stristr(uri_string(),'create_character') && !$this->uri->segment(4)){ ?>class="active"<?php } ?> href="/admin/create_character/">
						<span class="glyphicon glyphicon-user"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Add a new character</span>
					</a>
				</li>
				<li>
					<a title="Manage comic characters" <?php if(stristr(uri_string(),'manage_characters')){ ?>class="active"<?php } ?> href="/admin/manage_characters/">
						<span class="glyphicon glyphicon-pencil"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Manage comic characters</span>
					</a>
				</li>
				<li>
					<a title="Add a new tag" <?php if(stristr(uri_string(),'create_tag') && !$this->uri->segment(4)){ ?>class="active"<?php } ?> href="/admin/create_tag/">
						<span class="glyphicon glyphicon-tag"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Add a new tag</span>
					</a>
				</li>
				<li>
					<a title="Manage comic tags" <?php if(stristr(uri_string(),'manage_tags')){ ?>class="active"<?php } ?> href="/admin/manage_tags/">
						<span class="glyphicon glyphicon-tags"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Manage comic tags</span>
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a title="Redirects" <?php if(stristr(uri_string(),'redirect')){ ?>class="active"<?php } ?> data-target="#admin-redirects" data-toggle="collapse">
				<span class="glyphicon glyphicon-share-alt"></span>&nbsp;
				<span class="collapse <?php echo $sidebar; ?>">Redirects <span class="glyphicon glyphicon-triangle-bottom"></span></span>
			</a>
			<ul class="nav nav-stacked left-submenu <?php if(!stristr(uri_string(),'redirect')){ ?>collapse<?php } else { ?>in<?php } ?>" id="admin-redirects">
				<li>
					<a title="Add a new redirect" <?php if(stristr(uri_string(),'create_redirect') && !$this->uri->segment(4)){ ?>class="active"<?php } ?> href="/admin/create_redirect/">
						<span class="glyphicon glyphicon-plus"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Add a new redirect</span>
					</a>
				</li>
				<li>
					<a title="Manage redirects" <?php if(stristr(uri_string(),'manage_redirects')){ ?>class="active"<?php } ?> href="/admin/manage_redirects/">
						<span class="glyphicon glyphicon-pencil"></span> 
						<span class="collapse <?php echo $sidebar; ?>">Manage redirects</span>
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a title="User Manual" <?php if(stristr(uri_string(),'manual')){ ?>class="active"<?php } ?> href="/admin/manual">
				<span class="glyphicon glyphicon-book"></span>&nbsp;
				<span class="collapse <?php echo $sidebar; ?>">User Manual
			</a>
		</li>
		<li>
			<a title="User Manual" <?php if(!$this->uri->segment(2)){ ?>class="active"<?php } ?> href="/admin">
				<span class="glyphicon glyphicon-stats"></span>&nbsp;
				<span class="collapse <?php echo $sidebar; ?>">Visitor Stats
			</a>
		</li>
		<li>
			<a title="Logout" href="/auth/logout">
				<span class="glyphicon glyphicon-log-out"></span>&nbsp;
				<span class="collapse <?php echo $sidebar; ?>">Logout
			</a>
		</li>
	</ul>
</div>
<script type="text/javascript">
	
	//Main class (shrink/enlarge)
	$('[data-toggle=offcanvas]').click(function(){
		sidebar_toggle();
	});
	
	//Function for handling sidebar
	function sidebar_toggle(){
		
		//Main class (shrink/enlarge)
		$('.row-offcanvas').toggleClass('active');
		
		//Toggle minimisation
		$('.collapse').not('.nav-stacked').toggleClass('in');
		//$('.collapse').toggleClass('hidden-xs');
		//$('.collapse .nav-stacked').toggleClass('hidden-xs').toggleClass('visible-xs').toggleClass('in');
		
		//Set value for of submenu is open or closed
		if($('.collapse').not('.left-submenu').hasClass('in')){
			sidebar = 'OPEN';
		} else {
			sidebar = 'CLOSED';
		}
		
		//Update user pref for sidebar
		$.ajax({
			type	: 'POST',
			url		: '/admin/update_sidebar/'+sidebar
		});
		
	}
	
</script>
