<h1><?php echo $this->config->item('app_name','webcomic'); ?> User Manual</h1>
<p>Welcome to <?php echo $this->config->item('app_name','webcomic'); ?>! See below for reference on how to use this app.</p>

<hr />

<h2>Index:</h2>
<ul>
	<li>
		<a href="#install">00. Installation</a>
		<ul>
			<li><a href="#installation-fall-down-go-bye-bye">Installation Troubleshooting</a></li>
		</ul>
	</li>
	<li><a href="#login">01. Logging In</a></li>
	<li><a href="#admin">02. The Admin Sidebar</a></li>
	<li><a href="#users">03. User Management</a></li>
	<li>
		<a href="#appearance">04. Webcomic Appearance</a>
		<ul>
			<li><a href="#settings">Settings</a></li>
			<li><a href="#themes">Template Themes</a></li>
			<li><a href="#banners">Banners</a></li>
			<li><a href="#navigation">Navigation</a></li>
			<li><a href="#favicon">Favicon</a></li>
		</ul>
	</li>
	<li>
		<a href="#templates">05. Templating</a>
		<ul>
			<li><a href="#template-requirements">Template Requirements</a></li>
			<li><a href="#template-stubs">Template Stubs</a></li>
			<li><a href="#template-page-files">Template Page Files</a></li>
			<li><a href="#template-design">Designing Your Template</a></li>
		</ul>
	</li>
	<li>
		<a href="#pages">06. Pages Management</a>
		<ul>
			<li><a href="#about">Edit 'about' page</a></li>
			<li><a href="#add-new-comic">Add new comic</a></li>
			<li><a href="#manage-pages">Manage existing comic pages</a></li>
		</ul>
	</li>
	<li>
		<a href="#chapters">07. Chapter Management</a>
		<ul>
			<li><a href="#add-chapter">Add a new comic chapter</a></li>
			<li><a href="#add-subchapter">Add a new comic subchapter</a></li>
			<li><a href="#manage-chapters">Manage comic chapters</a></li>
		</ul>
	</li>
	<li>
		<a href="#tags">08. Characters and Tags</a>
		<ul>
			<li><a href="#add-character">Add a new character</a></li>
			<li><a href="#manage-characters">Manage comic characters</a></li>
			<li><a href="#add-tag">Add a new tag</a></li>
			<li><a href="#manage-tags">Manage comic tags</a></li>
		</ul>
	</li>
	<li>
		<a href="#redirects">09. Redirects</a>
		<ul>
			<li><a href="#add-redirect">Add a new redirect</a></li>
			<li><a href="#manage-redirects">Manage redirects</a></li>
		</ul>
	</li>
	<li><a href="#search">10. Webcomic Search</a></li>
	<li><a href="#sitemap">11. robots.txt, sitemap.xml and Other Mysterious Files</a></li>
	<li><a href="#stubs">12. Template Stubs Reference</a></li>
	<li><a href="#glossary">Glossary of Terms</a></li>
	<li>
		<a href="#faqs">FAQs</a>
		<ul>
			<li><a href="#why-oh-why">Why Did You Build This?</a></li>
			<li><a href="#credits">Did You Build This From Scratch?</a></li>
			<li><a href="#can-i-can-i-please-please-please">Can I Modify This App?</a></li>
			<li><a href="#license">User License</a></li>
			<li><a href="#wishlist">The Wishlist</a></li>
			<li><a href="#contact">How Do I Contact You?</a></li>
		</ul>
	</li>
</ul>

<hr />

<h3 id="install">00. Installation</h3>
<p><?php echo $this->config->item('app_name','webcomic'); ?>, like any software, has a few minimum requirements. Please note that the app <i>should</i> work in later versions and might even work in older versions but these are the ideal minimum requirements based on the app's development:</p>
<ul>
	<li>PHP 5.5 (possibly 5.4)</li>
	<li>MySQL 5.6 (possibly 5.5)</li>
	<li>Apache (or Apache2) web server*</li>
</ul>
<p class="small">*The app relies on a few .htaccess files for URL rewrites but it may be possible to translate these into equivalent rules for servers using NGINX.</p>
<p>Normally these will be features of a UNIX-based OS but Microsoft IIS servers may offer equivalent features.</p>
<p>Unzip the app to your webspace - this can either be in the "root" of the server or in a sub-folder (or directory) e.g. you could have it installed at http://dev.webcomical.co.uk or http://dev.webcomical.co.uk/comics/ (insert your own domain in for these addresses, obviously).</p>
<p>Loading your website up should present a login page featuring Webby's gormless visage (don't worry, you can get rid of him later).</p>
<p class="text-center"><img title="The installation screen" alt="The installation screen" class="bordered" src="/assets/user_guide/00_install_screen.png" /></p>
<p>While the screen should be fairly self-explanatory, here is an overview of what details you will be required to fill in:</p>
<ul>
	<li><b>Website URL -</b> the full web address including the prefix (usually http:// or https:// depending on whether you have an *SSL certificate). While you may know your web address, the app will not know what it is and cannot make a 100% safe guess! Hence why you are asked to enter it.</li>
	<li><b>Timezone -</b> set your preferred global location; this will affect publication dates for your comic pages!</li>
	<li><b>Hostname -</b> normally "localhost", but can be different depending on where your database is located! Please refer to your web host for further info (or just try localhost, that is what it is most of the time).</li>
	<li><b>Database Username and Password -</b> your login credentials for you **MySQL database. Please refer to your web host for instructions on setting up databases.</li>
	<li><b>Database Name - </b> also known as the name of your "schema", the app will attempt to create a database with this name. If your web server is running restricted permissions, instead create a new schema/database manually (usually via phpMyAdmin) and then enter the name in this field after. Please refer to your web host for queries regarding database creation.</li>
</ul>
<p class="small">*While this app can run without SSL (Secure Socket Layer), I would recommend getting one if you can. Many search engines will penalise your website for not having one!</p>
<p class="small">**It would be irresponsible for me not to at least suggest creating a new MySQL user with limited permissions to run this app with; basic read, write, update and delete functionality will do, however you may need to grant table creation permissions for first-time installation.</p>
<p>You are also asked to enter some user details to generate your first user account. Please ensure to use a valid email address as this will be used to send you a password reset if you get locked out!</p>
<p>Once you have filled in all the fields, click "install" at the bottom of the form. If there are any errors you will be prompted to correct them.</p>
<p>If all goes well, the app will install and redirect you to the login page! If not...</p>
<h4 id="installation-fall-down-go-bye-bye">Installation Troubleshooting</h4>
<p>If you get any problems installing <?php echo $this->config->item('app_name','webcomic'); ?>, it could be worth trying one of the following steps:</p>
<ul>
	<li>If you get a White Screen of Death where you are presented with a blank page, edit the .htaccess file in the root of the app and change the word "production" to "development". Refreshing the page should now present some errors which might give you some idea as to what the problem is. Just remember to change "development" back to "production" once everything is installed.</li>
	<li>
		Part of the installation writes to and changes various files, so make sure that the app has permissions to update files. Please refer to your web host documentation regarding file permissions. A rough guide should be that directories are set to 0755 and files are set to 0644 - the Linux command line statements for setting these permissions are:
		<ul>
			<li>find . -type d -print0 | xargs -0 chmod 0755 #For directories</li>
			<li>find . -type f -print0 | xargs -0 chmod 0644 #For files</li>
		</ul>
	</li>
	<li>As mentioned above, the app will attempt to create the database if it doesn't already exist; if your server has restrictive permissions it may not be allowed to and will probably fall over. You can mitigate this by manually creating the database or schema yourself and entering the name of it on the installation page.</li>
	<li>On a Linux/Unix environment you may also have to run something like "sudo chown -R www-data:www-data ." in the directory that holds the application files.</li>
	<li>If the installation is interrupted you may end up with a malformed install; it is always worth removing all files and recopying a fresh batch of the app files up if you think this is the case.</li>
</ul>

<hr />

<h3 id="login">01. Logging In</h3>
<p>Presumably if you're reading this, then you managed to get past the login screen! It will always be accessible from <a title="Your admin panel!" href="<?php echo base_url(); ?>auth"><?php echo base_url(); ?>auth</a>.</p>
<p>You can login using either your username or your email address.</p>
<p>Should you forget your password, you can click "forgot your password" on the login screen and, after entering your username, can get a new password sent to the email address associated with your account.</p>
<p>Worst case scenario, if you get locked out of your account and no longer have access to the email address associated with your account, you will just have to access the database and tinker with the "users" table!</p>
<p>There is a tickbox on the login page for "keep me logged in" - ticking this will keep you logged in to <?php echo $this->config->item('app_name','webcomic'); ?> even if closing the browser window. The session lasts for <?php echo floor($this->config->item('user_expire','ion_auth')/3600); ?> hours before it will expire.</p>

<hr />

<h3 id="admin">02. The Admin Sidebar</h3>
<p class="text-center"><img title="The admin sidebar" alt="The admin sidebar" class="bordered" src="/assets/user_guide/02_sidebar.png" /></p>
<p>The admin panel features a "sidebar" where all the admin features can be accessed. Most of the features will be outlined below in greater detail but a few items I will describe here:</p>
<ul>
	<li><b>Minimise Sidebar -</b> by default the sidebar is shown in full with all the labels on display, but clicking this will minimise the sidebar to show only the icons.</li>
	<li><b>View Site -</b> clicking this at any point will go the webcomic's home page.</li>
	<li><b>Logout -</b> does what it says on the tin! Clicking this will end your current session and log you out of the admin panel.</li>
</ul>

<hr />

<h3 id="users">03. User Management</h3>
<p class="text-center"><img title="The user management options" alt="The user management options" class="bordered" src="/assets/user_guide/03_user_management.png" /></p>
<p>You can add users by selecting "<b>Create a new user</b>" from the admin sidebar. All the fields on the create new user form are required and I recommend setting a real email address for purposes of resetting passwords (see notes above!).</p>
<p>You cannot add a user with a username or an email address already on an existing user account.</p>
<p>You can edit your own user profile by selecting "<b>Edit your profile</b>" from the sidebar.</p>
<p>You can also edit any other user profiles by selecting "<b>Manage users</b>" from the admin sidebar and then selecting the user you want to edit from the drop-down menu.</p>
<p>To delete a user's profile, select their profile from "<b>Manage users</b>"; there will be a tickbox for "delete this user's account". You will be prompted for confirmation before the deletion is carried out.</p>
<p class="text-center"><img title="The delete user tickbox" alt="The delete user tickbox" class="bordered" src="/assets/user_guide/03_delete_user.png" /></p>
<p>Please note that you cannot delete your own profile!</p>

<hr />

<h3 id="appearance">04. Webcomic Appearance</h3>
<p>Webcomic Appearance encompasses many facets of how your webcomic is displayed.</p>
<p class="text-center"><img title="Webcomic appearance options" alt="Webcomic appearance options" class="bordered" src="/assets/user_guide/04_webcomic_appearance.png" /></p>
<h4 id="settings">Settings</h4>
<p>The settings page covers lots of things, from the title of your comic, various terminologies (e.g. do you have episodes, acts, pages, etc?) and RSS feed settings.</p>
<p>If you wish to use comments, you can link a <a title="DISQUS" href="https://disqus.com/">Disqus</a> account in this panel. I recommend using Disqus as it allows users to log in using existing social media accounts, encouraging engagement.</p>
<p>Most importantly, if you find the <?php echo $this->config->item('app_name','webcomic'); ?> mascot Webby to be frustratingly annoying, you can turn him off here and all traces of him will magically diappear from the app!</p>
<?php if($settings['site_webby'] == "Yes"){ ?>
	<p class="text-center"><a rel="nofollow" href="https://www.youtube.com/watch?v=P8aIhJCAvjw"><img title="TA-DAAA!" alt="TA-DAAA!" src="/assets/icons/loading-webby.gif" /></a></p>
	<p>How could you hate this lil' guy though? Also, yes, this bit of the user guide will also disappear if you turn Webby off.</p>
<?php } ?>
<h4 id="themes">Template Themes</h4>
<p>This part of the admin panel handles how your comic is displayed. By default the comic will used a generic "baked-in" template but you can select any of the other themes from this section to instantly change how your comic is displayed.</p>
<p><?php echo $this->config->item('app_name','webcomic'); ?> comes bundled with four different comic templates but you can add your own; please see <a title="05. Templating" href="#templates">the next section</a> for complete details on customising your own template.<p>
<h4 id="banners">Banners</h4>
<p>A banner is the image that displays at the top of the webcomic, usually a stylised version of the title. I recommend keeping this banner as horizontal and thin as possible but I'm not here to tell you how to run your webcomic!</p>
<p>If you upload multiple banners, the webcomic will randomly pick one every time a page is loaded. You might want to use this feature if, for example, you wanted a different character to appear in the banner every time a page is loaded.</p>
<p>Uploaded banners can be deleted on this page by clicking the <b>dustbin icon (<span class="glyphicon glyphicon-trash"></span>)</b> next to them (you will be prompted for confirmation before deletion).</p>
<p>You can also suppress banners from being shown by toggling the "show on website" switch next to each banner to "no". You might want to do this if, for instance, you have banners which feature characters that have not shown up in the comic yet.</p>
<p>If no banners are uploaded, the webcomic's title will show at the top of the comic in plain text.</p>
<h4 id="navigation">Navigation</h4>
<p>"Navigation" refers to how readers of your comic switch between pages. This page allows you to set certain buttons to appear on the top navigation bar (above the current page), on the bottom (under the current page), on both, or on neither.</p>
<p>This panel assumes that you are going to have both top and bottom navigation bars on your comic - if your comic format allows you to only require one then please take that into account when making selections here!</p>
<p>This panel also lets you upload a single image that contains your navigation buttons so you can customise their appearance on your webcomic.</p>
<h4 id="favicon">Favicon</h4>
<p>This panel lets you upload a "favicon" - details of what a favicon actually is are described <a title="The favicon upload page describes what a favicon is. I don't really want to replicate that information here!" href="/admin/webcomic_favicon">on this panel</a>.</p>
<p>To change your favicon, just upload a new favicon file; this will overwrite your existing one.</p>

<hr />

<h3 id="templates">05. Templating</h3>
<p><?php echo $this->config->item('app_name','webcomic'); ?> has a rudimentary templating system built in. Templates can be added, removed and edited in the <b>/assets/templates/</b> directory.</p>
<p>Creating or modifying templates unfortunately does require some basic knowledge of HTML (and possibly CSS!); however, the level of HTML required is fairly basic. I recommend starting out by duplicating one of the existing templates and editing it.</p>
<p>Please note that the templates bundled with the app have been optimised for viewing on mobile devices; it does this via a framework called "Bootstrap". Not using the structured HTML provided in the templates may break your webcomic site for viewing on mobile devices!</p>
<p>I recommend the following resources if you are looking to build your own templates:</p>
<ul>
	<li><a title="W3Schools on HTML" href="https://www.w3schools.com/html/default.asp">W3Schools on HTML</a></li>
	<li><a title="W3Schools on CSS" href="https://www.w3schools.com/css/default.asp">W3Schools on CSS</a></li>
	<li><a title="W3Schools on Bootstrap" href="https://www.w3schools.com/bootstrap/default.asp">W3Schools on Bootstrap</a></li>
</ul>
<h4 id="template-requirements">Template Requirements</h4>
<p>A completely valid <?php echo $this->config->item('app_name','webcomic'); ?> template preferably consists of the following:</p>
<ul>
	<li>A folder created in the /assets/templates folder with a web-friendly name (i.e. lower case with no spaces or special characters - dashes or underscores are allowed though).</li>
	<li>An optional index.html file where...
		<ul>
			<li>The first line is the name of the template</li>
			<li>The second line is the description of the template</li>
		</ul>
	</li>
	<li>An optional 200x200 pixel .png image that represents your template with the file name "preview" (so the full file name would be "preview.png").</li>
	<li>A template.html file containing something (preferably the HTML markup code for your webcomic!).
</ul>
<p>The first and last items on the list above are the only essential factors to whether your template is considered "valid". Templates that are broken will generate an error like the one below on the <a title="Selecting a template for your webcomic" href="#themes">Webcomic Appearance Panel</a>.</p>
<p class="text-center"><img title="A broken template error message" alt="A broken template error message" class="bordered" src="/assets/user_guide/05_broken_template.png" /></p>
<h4 id="template-stubs">Template Stubs</h4>
<p>Templating basically consists of creating HTML files that contain "stubs", which are special tags that act as placeholders for sections of your webcomic.</p>
<p>For example, inserting the stub <b>[%COMIC_NAV%]</b> into your HTML files will tell <?php echo $this->config->item('app_name','webcomic'); ?> where you want the webcomic navigation to be loaded on the page. Similarly, placing <b>[%COMIC%]</b> in your HTML file tells the app where you want the actual comic page to load and <b>[%COMIC_BANNER%]</b> tells the app where you want your banner images to load!</p>
<p>There are a whole bunch of useful stubs you can use in your HTML templates; see the <a title="Template Stubs Reference" href="#stubs">Template Stubs Reference</a> section of this guide for full details of what stubs exist, what they do and what pages they can be used on.</p>
<p>Please note that stubs do not work universally across all pages; some stubs serve specific purposes. See the reference section below for full details.</p>
<h4 id="template-page-files">Template Page Files</h4>
<p>Within a template folder, you create specific files to represent specific pages on your webcomic. The default file is "template.html", which represents your main comic view.</p>
<p>If you wanted to customise you cast listing page, you would create a file in your template directory/folder called "cast_list.html" and fill this with the HTML code you wish to display on that particular page.</p>
<p>The only required file is template.html - the other template pages are completely optional. If the app cannot find a template file for a given page when it goes to load that page, it will default back to using <?php echo $this->config->item('app_name','webcomic'); ?>'s default layout for that page.</p>
<p>If you include a "style.css" file in your template directory containing all of your custom styles, then the app will always load these styles regardless of whether a template page exists; you can use this file to override existing default styles too!</p>
<p>The full list of template files you can create is in the below table. Again, I recommend taking a look at some of the pre-made ones in the templates folder that you can copy and modify as you wish.</p>
<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<tr>
			<th>File:</th>
			<th>Relevant Stubs:</th>
			<th>Purpose:</th>
		</tr>
		<tr>
			<td>template.html</td>
			<td>
				<ul class="list-unstyled">
					<li>[%COMIC%]</li>
					<li>[%COMIC_BANNER%]</li>
					<li>[%COMIC_NAV%]</li>
					<li>[%PAGE_CHAPTER_NAME%]</li>
					<li>[%PAGE_COMMENTS%]</li>
					<li>[%PAGE_NAME%]</li>
					<li>[%PAGE_NOTES%]</li>
					<li>[%PAGE_PUBLISHED_DATE%]</li>
					<li>[%PAGE_SELECT%]</li>
					<li>[%PAGE_TAGS%]</li>
					<li>[%PAGE_TRANSCRIPT%]</li>
				</ul>
			</td>
			<td><b>This file is required.</b> This file represents the default comic "view" that readers see when they read the comic and normally doubles as the home page too.</td>
		</tr>
		<tr>
			<td>404.html</td>
			<td>N/A</td>
			<td>Page not found! This file represents what the reader sees if they unfortunately find a page that no longer exists e.g. via a dead hyperlink. While they should hopefully never see this page, you have the option to customise it if you want! Maybe you might want to provide links to active sections of your webcomic.</td>
		</tr>
		<tr>
			<td>about.html</td>
			<td>
				<ul class="list-unstyled">
					<li>[%ABOUT_TITLE%]</li>
					<li>[%ABOUT_DETAILS%]</li>
				</ul>
			</td>
			<td>If you fill the about section in, this page represents the about page. Does what it says on the tin, basically.</td>
		</tr>
		<tr>
			<td>archive.html</td>
			<td>
				<ul class="list-unstyled">
					<li>[%ARCHIVE_TITLE%]</li>
					<li>[%ARCHIVE_LIST%]</li>
				</ul>
			</td>
			<td>Represents the page that shows a complete list of comic pages on your webcomic, organised by chapter (if you use chapters).</td>
		</tr>
		<tr>
			<td>cast_list.html</td>
			<td>
				<ul class="list-unstyled">
					<li>[%CAST_TITLE%]</li>
					<li>[%CAST_LIST%]</li>
				</ul>
			</td>
			<td>Represents the cast listing page where all your characters get listed and links to their profiles are provided.</td>
		</tr>
		<tr>
			<td>profile.html</td>
			<td>
				<ul class="list-unstyled">
					<li>[%PROFILE_CHARACTER_NAME%]</li>
					<li>[%PROFILE_DETAILS%]</li>
				</ul>
			</td>
			<td>Represents the page that is loaded for an individual character's profile.</td>
		</tr>
		<tr>
			<td>search.html</td>
			<td>
				<ul class="list-unstyled">
					<li>[%TAG_TITLE%]</li>
					<li>[%TAG_LIST%]</li>
				</ul>
			</td>
			<td>Represents the page that shows search results when using the search bar.</td>
		</tr>
		<tr>
			<td>tags.html</td>
			<td>
				<ul class="list-unstyled">
					<li>[%TAG_TITLE%]</li>
					<li>[%TAG_LIST%]</li>
				</ul>
			</td>
			<td>
				The tags file shares two duties:
				<ul>
					<li>It represents the page that shows relevant comic pages that have been tagged with a specific tag e.g. clicking the tag "France" on a comic page will then load this page.</li>
					<li>It also represents the page that shows relevant comic pages that feature specific characters e.g. clicking the character tag "Joe Bloggs" on a comic page will then load this page.</li>
				</ul>
			</td>
		</tr>
		<tr>
			<th colspan='3'>Misc Template Files:</th>
		</tr>
		<tr>
			<td>index.html</td>
			<td colspan='2'>Contains the details about your template - the first line is the template name, the second is the description. Everything else gets ignored.</td>
		</tr>
		<tr>
			<td>preview.png</td>
			<td colspan='2'>An image that represents your template - it is required to be 200px x 200px in size otherwise it will not display!</td>
		</tr>
		<tr>
			<td>style.css</td>
			<td colspan='2'>A CSS file that contains style rules that dictate how your webcomic looks (colour, font, etc.).</td>
		</tr>
	</table>
</div>
<h4 id="template-design">Designing Your Template</h4>
<p>While this app has been built to allow complete flexibility over the HTML and CSS used, the following guides are good principles to remember when designing your webcomic:</p>
<ul>
	<li><a rel="nofollow" title="Redesigning Webcomics" href="http://rachelnabors.com/2011/01/redesigning-webcomics-design-your-site-for-readers/">Redesigning Webcomics: design your site for readers</a> (by Rachel Nabors)</li>
	<li><a rel="nofollow" title="Do's and Don'ts of Webcomic Website Design" href="http://webcomicalliance.com/business/dos-and-donts-of-webcomic-website-design/">Do's and Don'ts of Webcomic Website Design</a> (by Webcomic Alliance)</li>
	<li><a rel="nofollow" title="Mobile-Friendly Webcomics" href="https://makewebcomics.com/article/mobile-friendly-webcomics/">Mobile-Friendly Webcomics</a> (by MakeWebcomics.com)</li>
</ul>
<p>The last one in particular is noteworthy as most web traffic these days is mobile-based. All of the templates bundled with this app have been created to be flexible on mobile devices so by all means pinch the code for your own templates!</p>

<hr />

<h3 id="pages">06. Pages Management</h3>
<p>"Pages" refers to the individual comic episodes of your comic. While your comic pages will consist of image files, in terms of this app the term "page" also applies to the website page that displays that image, along with all the information presented with the image.</p>
<p class="text-center"><img title="Page management options" alt="Page management options" class="bordered" src="/assets/user_guide/06_pages_management.png" /></p>
<h4 id="about">Edit 'about' page</h4>
<p>This panel allows you to generate an "about" page for your webcomic. You can enter a title for the page and the "about the comic" section can be as long as you like (within reason!).</p>
<p>Leaving this section alone will mean that the "about" link will not appear on the comic's site navigation bar.</p>
<h4 id="add-new-comic">Add new comic</h4>
<p>This form will allow you to create a new page for your comic. The form is fairly self-explanatory!</p>
<p>I recommend utilising the transcript box to present the script of the comic page - this will heavily help search engines pick up on the contents of the image file as, at the time of writing, they are not sophisticated enough to read text from an image file.</p>
<p>Once you have saved the form, the page will reload and you will then be given the option to upload the image file for the page. You cannot upload a comic file before saving the page it will be attached to! The idea behind this is you might want to plan out several pages in advance before creating the image files.</p>
<p class="text-center"><img title="Comic file upload box" alt="Comic file upload box" class="bordered" src="/assets/user_guide/06_file_upload_box.png" /></p>
<p>Whether a page is published depends on two things:</p>
<ul>
	<li>The published date is equal to or earlier than the current date and time.</li>
	<li>There is an image file attached to the page.</li>
</ul>
<p>You can schedule a page to be published at a later date and it will not be shown on the webcomic until the date arrives. Please note that this will depend on what timezone you selected when installing the app!</p>
<h4 id="manage-pages">Manage existing comic pages</h4>
<p>From this panel you can reorder, edit and delete pages for your webcomic.</p>
<p>By default, comics will be assigned to "no chapter assigned" - you may not wish to utilise the chapters functionality and this is absolutely fine.</p>
<p>If you do utilise chapters (and assign pages to them using the add/edit comic form), comic pages will be separated into pages per chapter under this management panel (e.g. if you have two chapters, there will be two pages of comics, one per chapter).</p>
<p>On this panel...</p>
<ul>
	<li>The <b>up arrow (<span class="glyphicon glyphicon-arrow-up">)</b> moves a comic page up (later) in the order of the archive.</li>
	<li>The <b>down arrow (<span class="glyphicon glyphicon-arrow-down">)</b> moves a comic page down (earlier) in the order of the archive.</li>
	<li>The <b>pencil icon (<span class="glyphicon glyphicon-pencil"></span>)</b> will open the comic page editing panel.</li>
	<li>The <b>dustbin icon (<span class="glyphicon glyphicon-trash"></span>)</b> will delete a comic page from the archive (you will be prompted for confirmation). Deleting a comic page will also remove the image file from the server too, so make sure you have backup copies before deleting!</li>
</ul>

<hr />

<h3 id="chapters">07. Chapter Management</h3>
<p>As mentioned in the previous section, you can break your webcomic up into "chapters". While you can define what your terminology for chapters is under <a title="04. Webcomic Appearance" href="#appearance">settings</a>, this app uses the term chapters to refer to a group of comic pages or episodes.</p>
<p>Chapters are completely optional; if you wish to do a more traditional "newspaper" style comic strip you can ignore chapters altogether.</p>
<p>If you do have chapters, you can use the chapter select navigation option on your webcomic to allow your readers to jump around the story easier.</p>
<p>Please note that if you do have chapters, any comic pages not assigned a chapter will be grouped together as "not assigned to a chapter", which will show after all the other chapters in terms of the order of the archive.</p>
<p class="text-center"><img title="Chapter management options" alt="Chapter management options" class="bordered" src="/assets/user_guide/07_chapter_management.png" /></p>
<h4 id="add-chapter">Add a new comic chapter</h4>
<p>You can create a new chapter by entering a chapter title and description here (the latter is optional). Once created, the chapter will appear in the "select a chapter" drop-down menu when creating or editing a comic page.</p>
<p class="text-center"><img title="Chapter selection drop-down menu" alt="Chapter selection drop-down menu" class="bordered" src="/assets/user_guide/07_chapter_select.png" /></p>
<h4 id="add-subchapter">Add a new comic subchapter</h4>
<p>Subchapters are identical to chapters, except you assign a subchapter to a regular "parent" chapter. Using this you can create chapters like "Chapter 1, Part 1", etc.</p>
<p>This form is identical to the chapter creation panel, except for the addition of a drop-down menu to select the parent chapter from.</p>
<p>Like chapters, subchapters will appear in the "select a chapter" drop-down menu on the comic page creation and editing panels.</p>
<h4 id="manage-chapters">Manage comic chapters</h4>
<p>This panel is the equivalent of the page management panel, except for chapters! This means the icons have identical functionality:</p>
<ul>
	<li>The <b>up arrow (<span class="glyphicon glyphicon-arrow-up">)</b> moves a chapter (and its assigned pages) up (later) in the order of the archive. Moving a subchapter up will move it and its assigned pages later in the main chapter.</li>
	<li>The <b>down arrow (<span class="glyphicon glyphicon-arrow-down">)</b> moves a chapter (and its assigned pages) down (earlier) in the order of the archive. Moving a subchapter down will move it and its assigned pages earlier in the main chapter.</li>
	<li>The <b>pencil icon (<span class="glyphicon glyphicon-pencil"></span>)</b> will open the chapter editing panel.</li>
	<li>The <b>dustbin icon (<span class="glyphicon glyphicon-trash"></span>)</b> will delete a chapter from the archive (you will be prompted for confirmation). Deleting a chapter will <b>not</b> remove the comic pages associated with that chapter; it will simply designate the pages as no longer belonging to a chapter. Deleting a subchapter will relabel the pages as being part of the parent chapter.</li>
</ul>

<hr />

<h3 id="tags">08. Characters and Tags</h3>
<p>You can attach labels to your comic pages in order to identify recurring elements; locations, different artists/authors, pretty much anything! Characters are a special kind of tag in that they can aslo generate a profile page for you to add a character biography or profile to.</p>
<p>Tagging your pages will generate "tag" pages which collect pages together. For example, it you tagged a bunch of pages with the location "Paris", each page will feature a tag link; clicking this link will bring up a navigable collection of the pages that feature Paris!</p>
<p>This also aids search engines to determine themes that appear within your webcomic, and are also used by the native search functionality built in this app in order to suggest comic pages that match certain terms (e.g. in the previous example, searching your webcomic for "paris" should return all the pages tagged with "Paris"!).</p>
<p class="text-center"><img title="Tag management options" alt="Tag management options" class="bordered" src="/assets/user_guide/08_tags_management.png" /></p>
<h4 id="add-character">Add a new character</h4>
<p>Use this panel to add a new character to your webcomic; enter a name, a short description and a biography.</p>
<p>Once saved, you will be allowed to add a profile image to the character if you so wish to do so.</p>
<p>This panel also has a tickbox for "display on profile page?" - leaving this blank will exclude the character from the profiles page. Use this if you want to add biographies for characters that have not appeared in the comic yet.</p>
<p>Adding characters to your webcomic will cause them all to be listed when creating or editing comic pages; ticking the box next to a character on a comic page will tag that page as featuring the relevant character.</p>
<p class="text-center"><img title="Character selection drop-down" alt="Character selection drop-down" class="bordered" src="/assets/user_guide/08_character_selection.png" /></p>
<h4 id="manage-characters">Manage comic characters</h4>
<p>This is the character management panel equivalent to the pages and chapters managment panels! If you've read the sections above, the icons are much the same:</p>
<ul>
	<li>The <b>up arrow (<span class="glyphicon glyphicon-arrow-up">)</b> moves a character up the order of the characters displayed on the profiles listing page.</li>
	<li>The <b>down arrow (<span class="glyphicon glyphicon-arrow-down">)</b> moves a character down the order of the characters displayed on the profile listing page.</li>
	<li>The <b>pencil icon (<span class="glyphicon glyphicon-pencil"></span>)</b> will open the character editing panel.</li>
	<li>The <b>dustbin icon (<span class="glyphicon glyphicon-trash"></span>)</b> will delete a character (you will be prompted for confirmation). Deleting a character will remove their character tag from all comic pages it has been assigned to.</li>
</ul>
<h4 id="add-tag">Add a new tag</h4>
<p>Simpler than characters, tags are words or phrases that act as labels. As such this panel is a single text box for your new tag!</p>
<p>Please note that you can actually create tags while on the comic page creation/editing panel; on the bottom of this panel is a text box you can add new tags via (by clicking the "<b>+ Add tag</b>" button next to the text box). While typing tags into the text box the app will attempt to suggest existing tags that match what you are typing.</p>
<p class="text-center"><img title="The tag box on the page editing panel" alt="The tag box on the page editing panel" class="bordered" src="/assets/user_guide/08_tagging_a_page.png" /></p>
<p>It is not possible to create duplicate tags; for example, if you already have the tag "Paris" and type "Paris" into the tag box, the page will be tagged with the existing tag. Tags are not case-sensitive; "paris" and "Paris" will be considered to be the same tag.</p>
<h4 id="manage-tags">Manage comic tags</h4>
<p>This panel allows you to manage your tags, and lists how many pages are tagged per tag.</p>
<p>Like other management panels on the app, there are action icons next to each tag:</p>
<ul>
	<li>The <b>pencil icon (<span class="glyphicon glyphicon-pencil"></span>)</b> will open the tag editing panel.</li>
	<li>The <b>head or profile icon (<span class="glyphicon glyphicon-user"></span>)</b> will allow you to convert a tag to a character tag, giving you the option of assigning a profile or biography to the tag (you will be prompted for confirmation first). The idea behind this is that you may have recurring lesser or tertiary characters you might want to tag comics with but not have a profile for; if these characters ever become "main" characters this makes it easier to upgrade their status! Please note that this is not reversible and you cannot convert characters into tags; you would have to delete the character and then re-tag all the pages!</li>
	<li>The <b>dustbin icon (<span class="glyphicon glyphicon-trash"></span>)</b> will delete a tag (you will be prompted for confirmation). Deleting a tag will remove the tag from all comic pages it has been assigned to.</li>
</ul>

<hr />

<h3 id="redirects">09. Redirects</h3>
<p>Redirects are an important part of search engine optimisation; if you randomly move or rename a page it is important for search engines to know where the page has gone to!</p>
<p><?php echo $this->config->item('app_name','webcomic'); ?> handles redirects automatically every time you change the name or title for a page, character or tag.</p>
<p>Please note that redirects will also be removed if you create new items that match the redirect path. For example, renaming a page from "Episode 1" to "Episode 2" would create a redirect from the old title to the new one as the web address will have changed from "episode-1" to "episode-2". If, however, I then add a new page called "Episode 1" the app will remove the redirection rule as a new page has adopted the web address of "episode-1".</p>
<p class="text-center"><img title="Redirect management options" alt="Redirect management options" class="bordered" src="/assets/user_guide/09_redirects_management.png" /></p>
<h4 id="add-redirect">Add a new redirect</h4>
<p>You can manually add redirects if you wish to do so. It is just a case of selecting what type of redirect you want (character, page, tag) and then carefully entering the relevant slugs into the old and new address sections (for clarification of what a "slug" is, please see <a title="Glossary of Terms" href="glossary">the glossary</a>!).</p>
<p>Please note that the slug / web address / URL you want to redirect to must exist; saving the redirect will fail if the app cannot find a matching URL slug for whatever redirect you are attempting to create.</p>
<h4 id="manage-redirects">Manage redirects</h4>
<p>This panel allows you to see all the redirects the app has generated and any you have manually added (if any).</p>
<p>If you wish to remove a specific redirect, then simply click the <b>dustbin icon (<span class="glyphicon glyphicon-trash"></span>)</b> next to the redirect you wish to delete (you will be prompted for confirmation).</p>

<hr />

<h3 id="search">10. Webcomic Search</h3>
<p class="text-center"><img title="The search box" alt="The search box" class="bordered" src="/assets/user_guide/10_search_box.png" /></p>
<p>This app has a rudimentary search function built into it with intention of letting your readers try and find pages relevant to certain terms. However, this is dependent on several factors:</p>
<ul>
	<li>If a comic page features the search term in its title</li>
	<li>If a comic page has been tagged with tags and/or characters that match the search term</li>
	<li>If a comic page's transcript features the search term</li>
	<li>If the author notes accompanying a comic page features the search term</li>
</ul>
<p>I have only highlighted these factors here in order to stress how important adding tags, notes and transcripts is in terms of making your search bar effective!</p>

<hr />

<h3 id="sitemap">11. robots.txt, sitemap.xml and Other Mysterious Files</h3>
<p>While using this app you might notice two files that appear in the root directory: "robots.txt" and "sitemap.xml".</p>
<p class="text-center"><img title="Files in the root directory" alt="Files in the root directory" class="bordered" src="/assets/user_guide/11_files.png" /></p>
<p>Both of these files are automatically generated by the app every time you create or modify something:</p>
<ul>
	<li><b>robots.txt -</b> tells search engines where to find your sitemap file.</li>
	<li><b>sitemap.xml -</b> provides an entire map of your website, which helps search engines to index your pages easier.</li>
</ul>
<p>You can delete these files if you wish, but they will just come back the next time you change or update something! I mean, don't you want search engines to index your website?</p>
<p>In regards to other files in the root directory:</p>
<ul>
	<li><b>.htaccess - </b> is for directing apache webservers how to rewrite and handle certain requests. If you are running on NGINX, you can delete this or any others you find.</li>
	<li><b>composer.json - </b> I have left this file in for any tech-savvy users who want to use Composer to install extra libraries. If you did not understand that sentence, you can delete this.</li> 
	<li><b>contributing.md - </b> comes with the CodeIgniter framework, which this app is built in. You can probably delete this.</li>
	<li><b>license.txt</b> and <b>UNLICENSE - </b> the former comes with CodeIgniter and I have left it in to comply with their license terms. The "unlicense" is what this app was released under and was added by me. You can probably delete these unless you are looking to modify and release the app's files.</li>
	<li><b>timezone.php -</b> this is a file generated by the app which controls what timezone the comic operates under. DO NOT DELETE IT! You can, however, open this up in a text editor and change the timezone whenever you want!</li>
</ul>

<hr />

<h3 id="stubs">12. Template Stubs Reference</h3>
<p>As outlined in the <a title="Templating" href="#templates">templating</a> section above, there are a number of "stubs" you can utilise in your HTML templates which will load certain webcomic features when the page is loaded.</p>
<p>The table below details what each stub does, along with what <a title="Template Page Files" href="#template-page-files">template page files</a> each stub is available on.</p>
<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<tr>
			<th>Stub:</th>
			<th>Available on:</th>
			<th>Purpose:</th>
		</tr>
		<tr>
			<td>[%ABOUT_DETAILS%]</td>
			<td>
				<ul class="list-unstyled">
					<li>about.html</li>
				</ul>
			</td>
			<td>
				Will show everything that has been entered into the 
				<a title="editing the 'about' page" href="#about">"about" section on the about page</a>. This 
				will only display if you populate the about section with some content.
			</td>
		</tr>
		<tr>
			<td>[%ABOUT_TITLE%]</td>
			<td>
				<ul class="list-unstyled">
					<li>about.html</li>
				</ul>
			</td>
			<td>
				Will display the title entered on the 
				<a title="editing the 'about' page" href="#about">title section on the about page</a>. This 
				will only display if you populate the about title with some text.
			</td>
		</tr>
		<tr>
			<td>[%ADMIN_TOOLBAR%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				Displays the admin toolbar - please note that this can be placed pretty much anywhere on in the "body" 
				tag of your template and yet it will always stick to the top! Only displays if you are logged in. Recommended 
				to be placed on all your template pages somewhere.
			</td>
		</tr>
		<tr>
			<td>[%ARCHIVE_LIST%]</td>
			<td>
				<ul class="list-unstyled">
					<li>archive.html</li>
				</ul>
			</td>
			<td>
				Presents a list of all your comic pages and chapters, along with any chapter descriptions you have 
				entered. The order goes from oldest chapters/pages at the top to the newest at the bottom.
			</td>
		</tr>
		<tr>
			<td>[%ARCHIVE_TITLE%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				Displays the title you have assigned to the archive under <a href="#settings" title="the settings panel">settings</a>.
			</td>
		</tr>
		<tr>
			<td>[%CAST_LIST%]</td>
			<td>
				<ul class="list-unstyled">
					<li>cast_list.html</li>
				</ul>
			</td>
			<td>
				Presents a list of all your webcomic's cast as entered using <a title="characters and tags" href="#tags">the character editing panels</a>. 
				The characters will be shown in the order they have been set to under the character management panel.
			</td>
		</tr>
		<tr>
			<td>[%CAST_TITLE%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				Displays the title you have assigned to the cast page under <a href="#settings" title="the settings panel">settings</a>.
			</td>
		</tr>
		<tr>
			<td>[%CHAPTER_SELECT%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Presents a drop-down menu of all the chapters on your webcomic. If a reader selects a chapter, 
				the website will then load the first page in that chapter.
			</td>
		</tr>
		<tr>
			<td>[%COMIC%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Presents the actual comic page. This is usually an image file but for legacy purposes Flash files 
				are also supported.
			</td>
		</tr>
		<tr>
			<td>[%COMIC_BANNER%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				What this shows will depend on whether you have uploaded any image banners to be the title image 
				of your webcomic using the <a title="uploading banners" href="#banners">banners</a> panel under webcomic 
				appearance:
				<ul>
					<li>If no images have been uploaded, this stub will load the comic title in plain text as entered under webcomic <a href="#settings" title="the settings panel">settings</a>.</li>
					<li>If an image or multiple have been uploaded, this stub will randomly select one image to show. Obviously if you only have the one banner image it will only ever load that!</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>[%COMIC_NAV%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Presents the full comic navigation bar. By default it will include "First", "Previous", "Next" and "Last" buttons 
				but will show others depending on what buttons you have set to show under the <a title="navigation panel" href="#navigation">navigation 
				panel</a> (please note it will look at the settings for the "bottom" panel by default). I will also use the button image 
				template uploaded to the aforementioned panel too.
			</td>
		</tr>
		<tr>
			<td>[%COMIC_NAV_BOOKMARK_BUTTONS%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html*</li>
				</ul>
				<span class="small">*Except for on the home page</span>
			</td>
			<td>
				Shows the "bookmark" button which lets users bookmark their place in the comic; the page they have 
				bookmarked will load the next time they visit the website. Please note that while this shows on 
				comic pages, it will not show on the home page (the most recent comic) as that seems pretty 
				redundant!
			</td>
		</tr>
		<tr>
			<td>[%COMIC_NAV_BOTTOM%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				The same as [%COMIC_NAV%], but taking into account the options set for the "bottom" bar under 
				the <a title="navigation panel" href="#navigation">navigation panel</a>.
			</td>
		</tr>
		<tr>
			<td>[%COMIC_NAV_BUTTON_CHAPTER_JUMP_END%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the navigation button for jumping to the end of the current chapter (the last page of 
				the chapter).
			</td>
		</tr>
		<tr>
			<td>[%COMIC_NAV_BUTTON_CHAPTER_JUMP_START%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the navigation button for jumping to the beginning of the current chapter (the first page of 
				the chapter).
			</td>
		</tr>
		<tr>
			<td>[%COMIC_NAV_BUTTON_FIRST%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the navigation button for jumping to the first page in the comic archive.
			</td>
		</tr>
		<tr>
			<td>[%COMIC_NAV_BUTTON_LAST%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the navigation button for jumping to the last page in the comic archive.
			</td>
		</tr>
		<tr>
			<td>[%COMIC_NAV_BUTTON_NEXT%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the navigation button for jumping to the next page in the comic archive.
			</td>
		</tr>
		<tr>
			<td>[%COMIC_NAV_BUTTON_PREVIOUS%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the navigation button for jumping to the previous page in the comic archive.
			</td>
		</tr>
		<tr>
			<td>[%COMIC_NAV_BUTTON_RANDOM%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the navigation button for jumping to a random page in the comic archive.
			</td>
		</tr>
		<tr>
			<td>[%COMIC_NAV_TOP%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				The same as [%COMIC_NAV%], but taking into account the options set for the "top" bar under 
				the <a title="navigation panel" href="#navigation">navigation panel</a>.
			</td>
		</tr>
		<tr>
			<td>[%COMIC_SLOGAN%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				Displays the slogan you have assigned to your webcomic under <a href="#settings" title="the settings panel">settings</a>.
			</td>
		</tr>
		<tr>
			<td>[%COMIC_TITLE%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				Displays the title you have assigned to your webcomic under <a href="#settings" title="the settings panel">settings</a>. 
			</td>
		</tr>
		<tr>
			<td>[%COMIC_UPDATES%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				Displays what you have assigned to the "updates on" section of <a href="#settings" title="the settings panel">settings</a>.
			</td>
		</tr>
		<tr>
			<td>[%COPYRIGHT%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				Displays a copyright, for the holder and year set under <a href="#settings" title="the settings panel">settings</a>.
			</td>
		</tr>
		<tr>
			<td>[%FAVICON%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				Displays a favicon on the browser tab if you have uploaded one using <a title="the favicon panel" href="#favicon">the favicon panel</a>. 
				Please note this is intended to be used within the "head" tags of your HTML template.
			</td>
		</tr>
		<tr>
			<td>[%LINK_ABOUT%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
				<span class="small">Note: only displays if the "about" page has some content.</span>
			</td>
			<td>
				Presents a link to the "about" page (/about), presuming that the about page section has some details to show!
			</td>
		</tr>
		<tr>
			<td>[%LINK_ARCHIVE%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
				<span class="small">Note: only displays there are any comic pages on the webcomic.</span>
			</td>
			<td>
				Presents a link to the "archive" page (/archive). Will only display if there are any pages!
			</td>
		</tr>
		<tr>
			<td>[%LINK_PROFILES%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
				<span class="small">Note: only displays there are any characters on the webcomic.</span>
			</td>
			<td>
				Presents a link to the "cast" page (/character_profiles). Will only display if there are any characters!
			</td>
		</tr>
		<tr>
			<td>[%LINK_RSS_FEED%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				Presents a link to the RSS feed (/feed).
			</td>
		</tr>
		<tr>
			<td>[%META_TAGS%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
				<span class="small">Note: intended for use within the template "head" tags.</span>
			</td>
			<td>
				Loads app-specific meta tags; please ensure to include these within the "head" tags of your HTML 
				template!
			</td>
		</tr>
		<tr>
			<td>[%PAGE_CHAPTER_NAME%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the chapter name for the current page (i.e. which chapter the current page is a part of).
			</td>
		</tr>
		<tr>
			<td>[%PAGE_COMMENTS%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html*</li>
				</ul>
				<span class="small">*Relies on DISQUS comments being set up.</span>
			</td>
			<td>
				Loads DISQUS comments for the current page, presuming you have set up the DISQUS link under 
				<a href="#settings" title="the settings panel">settings</a>.
			</td>
		</tr>
		<tr>
			<td>[%PAGE_NAME%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the name of the current page.
			</td>
		</tr>
		<tr>
			<td>[%PAGE_NOTES%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows any author notes for the current page.
			</td>
		</tr>
		<tr>
			<td>[%PAGE_PUBLISHED_DATE%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the date the current page was published.
			</td>
		</tr>
		<tr>
			<td>[%PAGE_SELECT%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Presents a drop-down menu of all the pages on your webcomic. If a reader selects a page, 
				the website will then load that page.
			</td>
		</tr>
		<tr>
			<td>[%PAGE_TAGS%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the tags (both characters and regular tags) for the current page. These tags are hyperlinked 
				and will load the tags page for the relevent tag when clicked on.
			</td>
		</tr>
		<tr>
			<td>[%PAGE_TRANSCRIPT%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
				</ul>
			</td>
			<td>
				Shows the transcript for the current page.
			</td>
		</tr>
		<tr>
			<td>[%PROFILE_CHARACTER_NAME%]</td>
			<td>
				<ul class="list-unstyled">
					<li>profile.html</li>
				</ul>
			</td>
			<td>
				Shows the name for the current character when viewing a character profile.
			</td>
		</tr>
		<tr>
			<td>[%PROFILE_DETAILS%]</td>
			<td>
				<ul class="list-unstyled">
					<li>profile.html</li>
				</ul>
			</td>
			<td>
				Shows the details for the current character when viewing a character profile.
			</td>
		</tr>
		<tr>
			<td>[%SEARCH_BAR%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				Presents the search bar for readers to be able to search your webcomic.
			</td>
		</tr>
		<tr>
			<td>[%SITE_DEFAULT_ASSETS%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
				<span class="small">Note: intended for use within the template "head" tags. Recommended for inclusion!</span>
			</td>
			<td>
				Loads app-specific assets; please ensure to include these within the "head" tags of your HTML 
				template, otherwise you may find parts of your webcomic not working correctly!
			</td>
		</tr>
		<tr>
			<td>[%SITE_NAME%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
				<span class="small">Note: intended for use within the template "title" tags.</span>
			</td>
			<td>
				Displays the generic catch-all title of the current page. 
				Designed to be shown within the "title" tag of your HTML template.
			</td>
		</tr>
		<tr>
			<td>[%SITE_NAME_WITH_COMIC_TITLE%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
				<span class="small">Note: intended for use within the template "title" tags.</span>
			</td>
			<td>
				Shows the current page name and the webcomic name, separated with a pipe "|" character; this is intended 
				to be used within the "title" tag of your HTML template for comic pages specifically.
			</td>
		</tr>
		<tr>
			<td>[%SITE_NAV%]</td>
			<td>
				<ul class="list-unstyled">
					<li>template.html</li>
					<li>404.html</li>
					<li>about.html</li>
					<li>archive.html</li>
					<li>cast_list.html</li>
					<li>profile.html</li>
					<li>search.html</li>
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				Presents the webcomic site navigation bar with a series of links i.e. "about", "archive", etc. 
				What is shown on the navigation bar depends how much you have filled out on your webcomic e.g. the "about" 
				page link will not show if you have not filled that section in!
			</td>
		</tr>
		<tr>
			<td>[%TAG_LIST%]</td>
			<td>
				<ul class="list-unstyled">
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				For use on tag, character appearance and search results pages, this will present a list of hyperlinked 
				thumbnails for pages which are relevant to the currently selected tag or search result.
			</td>
		</tr>
		<tr>
			<td>[%TAG_TITLE%]</td>
			<td>
				<ul class="list-unstyled">
					<li>tags.html</li>
				</ul>
			</td>
			<td>
				For use on tag, character appearance and search results pages, this will show the name of the currently 
				selected tag or the search term that was entered.
			</td>
		</tr>
	</table>
</div>

<hr />

<h3 id="glossary">Glossary of Terms</h3>
<p>This user manual uses several terms in specific ways; please refer to the glossary below for strict definitions in reference to this guide.</p>
<h4>"Page" or "Comic Page"</h4>
<p>"Pages" refers to the individual comic episodes of your comic. While your comic pages will consist of image files, in terms of this app the term "page" also applies to the website page that displays that image, along with all the information presented with the image.</p>
<h4>"Archive"</h4>
<p>The entire continuity of pages as a whole. If you are telling a sequential story, the ordering of the archive means the order in which pages appear.</p>
<h4>"Chapter"</h4>
<p>A collection of comic pages, usually part of a story arc. This app treats chapters as groups of pages that appear in a certain order within the archive.</p>
<h4>"Subchapter"</h4>
<p>The same as a chapter, but a subchapter exists within a chapter.</p>
<h4>"Tags" and "Tagging"</h4>
<p>Labels you attach to pages in order to help identify what appears in that page. A tag could be a location, a character, an artist, a time...pretty much anything, really!</p>
<p>Tagging is the act of attaching tags (or labels) to a page.</p>
<p>Please note that attaching characters to a page is a special kind of tagging in itself! Refer to the <a title="08.Characters and Tags" href="#tags">characters and tags section</a> for more details.</p>
<h4>"Profiles"</h4>
<p>Used in reference to characters, this refers to the description or biography given to a character.</p>
<h4>"Slugs"</h4>
<p>Slugs are not grey squishy things that eat your plants; at least, not in the context of this app! A "slug" is the term given to the web-friendly address a comic page is given.</p>
<p>For example, if I had a page called "Episode 1: George Lucas Mucks it all up!", the slug would be "episode-1-george-lucas-mucks-it-all-up" (note the lack of punctuation, spaces and capitalisation).</p>
<h4>"Stubs"</h4>
<p>Used in reference to <a title="05. Templating" href="#templates">templating</a>, a "stub" is a code tag that represents where a certain feature will appear.</p>
<p>For example, if I use the code stub <b>[SITE_NAME]</b> within a template, that is where I expect the app to put the webcomic site name (the name of the comic).</p>

<hr />

<h3 id="faqs">Frequently Asked Questions</h3>
<p>Or, in the very least, "questions I expect I'm going to get a lot about <?php echo $this->config->item('app_name','webcomic'); ?>".</p>
<h4 id="why-oh-why">Why Did You Build This?</h4>
<p>Long story short, I've used many webcomic platforms to host various webcomics I've worked on. From art services like deviantArt, to webcomic hosting services like the Duck webcomics (formerly Drunk Duck) and the now-defunct ComicDish, to attempting to use various WordPress plugins.</p>
<p>It was while attempting to wrangle the latter (I think I was trialling ComicPress and ComicEasel) that I became frustrated with the lack of customisation. I was trying to structure the webcomic one way but the plugin was limited to doing it a very specific way.</p>
<p>Originally I was going to bash together some custom code for my own purposes. That was some point in 2016 and, two years later of on/off development, there is now a full app.</p>
<p>The goals I've had for this app are the following:</p>
<ul>
	<li><b>Search engine friendliness baked-in:</b> a lot of wecomic solutions that you install yourself use horrible URLs like http://example.com/?p=117 rather than human-readable ones. They also don't account for redirects and don't encourage users to write transcripts.</li>
	<li><b>Comic tagging:</b> one of the coolest features of using WordPress for webcomics is the ability to label and categorise pages by characters, places, etc. A lot of standalone solutions do not offer tags at all.</li>
	<li><b>Flexible templates:</b> ComicDish and Drunk Duck used raw HTML templates where you could add tag "stubs" to represent where certain things will go e.g. the page, navigation bars, comments, etc. I was very impressed by this system so I have pinched the idea and have attempted to build my own version of their systems! This lets the user manipulate very basic HTML and add whatever code or styles they may wish.</li>
	<li><b>Chapters and subchapters:</b> a crucial feature that some CMS systems seem to tout as unique and remarkable; really this should be part of the basic requirements for a webcomic.</li>
</ul>
<p>I hope (and think) I have achieved these goals!</p>
<h4 id="credits">Did You Build This From Scratch?</h4>
<p>Nope! <?php echo $this->config->item('app_name','webcomic'); ?> is built using the CodeIgniter MVC framework (the choice framework for cowboy coders!). I have also used various plugins - I have attempted to note these in the config file (located at /application/config/webcomic.php) where possible, but to name a few things this app uses:</p>
<ul>
	<li><a title="jQuery" href="https://jquery.com/">jQuery (ver. 2)</a></li>
	<li><a title="Bootstrap" href="https://getbootstrap.com/">Bootstrap (ver. 3)</a></li>
	<li><a title="CKEditor" href="https://ckeditor.com/ckeditor-4/download/">CKEditor (ver. 4)</a></li>
	<li><a title="Ion Auth for CI" href="http://benedmunds.com/ion_auth/">Ion Auth by Ben Edmunds (for user logins)</a></li>
	<li><a title="ci-sitemap" href="http://roumen.it/projects/ci-sitemap">ci-sitemap by Roumen Damianoff</a></li>
	<li><a title="ci-installer" href="http://github.com/mikecrittenden/ci-installer/">ci-installer by Mike Crittenden</a></li>
	<li><a title="PHPMailer" href="https://github.com/PHPMailer/PHPMailer/tree/5.2-stable">PHPMailer (Stable ver. 5.2)</a></li>
</ul>
<h4 id="can-i-can-i-please-please-please">Can I Modify This App?</h4>
<p>I believe the question is actually "may I", as I am not sure as to your abilities to modify the app!</p>
<p>Pedantry aside, may you modify this app...well, yeah! I am releasing this app via GitHub because I am hoping that the community at large might like to add features as they see fit!</p>
<p>There is a wishlist section just below this but in all honesty I am not looking to add more features beyond maintenance and bug fixing from this point on.</p>
<p>On that note, here's the legalese bit...</p>
<h4 id="license">User License</h4>
<p><?php echo $this->config->item('app_name','webcomic'); ?> is released under <a href="http://unlicense.org/">the Unlicense:</a></p>
<blockquote>
	<p>This is free and unencumbered software released into the public domain.</p>
	<p>Anyone is free to copy, modify, publish, use, compile, sell, or distribute this software, either in source code form or as a compiled binary, for any purpose, commercial or non-commercial, and by any means.</p>
	<p>In jurisdictions that recognize copyright laws, the author or authors of this software dedicate any and all copyright interest in the software to the public domain. We make this dedication for the benefit of the public at large and to the detriment of our heirs and successors. We intend this dedication to be an overt act of relinquishment in perpetuity of all present and future rights to this software under copyright law.</p>
	<p>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
	<p>I dedicate any and all copyright interest in this software to the public domain. I make this dedication for the benefit of the public at large and to the detriment of my heirs and successors. I intend this dedication to be an overt act of relinquishment in perpetuity of all present and future rights to this software under copyright law.</p>
	<footer>For more information, please refer to &lt;http://unlicense.org/&gt;</footer>
</blockquote>
<p>A copy of this unlicense is available in a file marked "unlicense" in the root folder, as recommended by the unlicense providers.</p>
<h4 id="wishlist">The Wishlist</h4>
<p>Having done a little market research on webcomic Content Management Systems (CMS), there are certain recurring features that appear to be requested; I would like to comment on why some of these features do not exist on this app at the time of writing.</p>
<h5><b>Full blogging functionality outside of the webcomic or a dedicated news section</b></h5>
<p>I find this request curious as it rather negates the purpose of using a CMS built for webcomics. Really, if you want a blog there are quite a few real options:</p>
<ul>
	<li>Install <a title="WordPress.org" href="https://wordpress.org/">WordPress</a> and use the <a title="ComicPress.org" href="http://comicpress.org/">ComicPress</a> or <a title="ComicEasel" href="https://en-gb.wordpress.org/plugins/comic-easel/">ComicEasel</a> plugins</li>
	<li>Use <?php echo $this->config->item('app_name','webcomic'); ?> and simply install WordPress to a subdirectory e.g. /blog - <a title="wpbeginner.com's guide to installing WordPress to a subdirectory" href="http://www.wpbeginner.com/wp-tutorials/how-to-install-wordpress-in-a-subdirectory-step-by-step/">this is a perfectly valid thing to do with WordPress as long as you install it correctly</a>!</li>
	<li>Use <a title="tumblr.com" href="https://www.tumblr.com/">Tumblr</a> and just link to it from the webcomic - this seems to be a popular alternative to installing your own blog. Heck, if I am honest, a lot of webcomic artists use Tumblr to host their comics outright!</li>
</ul>
<p>As such, I do not ever plan to add full blogging functionality to the app outside of the existing "author notes" section that appears on the page editing panel. It seems redundant to add such functionality to a CMS designed to manage webcomics.</p>
<h5><b>Sharing options and social media</b></h5>
<p>As great as it sounds to encourage people to share pages from your webcomic, filling your page with share buttons <a title="The hidden cost of social share buttons" href="https://thenextweb.com/insider/2015/12/23/the-hidden-cost-of-social-share-buttons/">adds overhead in terms of loading pages and issues of security</a>.</p>
<p>It appears that this is a hotly debated topic; designers and consultants argue "why make things more difficult for a visitor" but then I reckon that if a reader really engages with your work and wants to share it they will go to the effort of copy/pasting the URL into their social media of choice.</p>
<p>Regardless, if you really want to add social media then it is perfectly fine to add share buttons and widgets to your <a title="05. Templating" href="#templates">template</a>. In regards to building it into the app, share buttons are changing all the time and I do not really want to open that can of worms by trying to keep up! I removed share buttons from my various blogs because they kept breaking and changing styles every other month.</p>
<p>If this is a really big issue for you, I recommend you try the <a title="Grawlix CMS" href="http://www.getgrawlix.com/downloads">Grawlix CMS</a> as it is a feature they have built in.</p>
<h5><b>A built-in commenting system</b></h5>
<p>I suspect this will be a controversial issue.</p>
<p>While I am not 100% against possibly adding a baked-in comments system to the app in a later version (I get the feeling I'm making a rod for my own back here!), this release relies on <a title="DISQUS" href="https://disqus.com/">Disqus</a> integration. This in itself can be a controversial choice as DISQUS places adverts in your comments if your traffic reaches over a certain amount unless you pay a subscription fee.</p>
<p>However, I chose DISQUS for two reasons:</p>
<ul>
	<li>It is very, very easy to integrate and I am a very, very lazy developer.</li>
	<li>It allows your readers to leave comments using their existing social media accounts.</li>
</ul>
<p>That latter reason I consider very important. Webcomics that require you to sign up for an account specific to their website potentially place barriers in the way of engagement; nobody wants to have to remember <i>another</i> login, right?</p>
<p>This app does have very limited user management and potential for expansion; I am also open to integrating with alternatives to DISQUS if there are any!</p>
<h5><b>Automatic transcript generation - pulling text from images</b></h5>
<p>This was actually suggested by a web developer colleague and sounds like a great idea!</p>
<p>Unfortunately, online Optical Character Recognition (OCR) is quite limited at the moment without having to <a title="OCR in PHP" href="https://www.sitepoint.com/ocr-in-php-read-text-from-images-with-tesseract/">add extra technicality to the app</a>. There is no easy option (like a javascript library) I can currently add to the app that would do the trick as most solutions involve installing PHP library packages on servers and things outside the scope of a standalone app!</p>
<p>Believe me, this is a feature I want myself! If you have any ideas, please get in touch.</p>
<h5><b>Multi-image comics or multiple images in a comic page</b></h5>
<p>This is another much-requested feature I see surrounding webcomic CMS's, and I understand why it is not a common feature; it is just bloody difficult to code!</p>
<p>I guess what people are after is something like the <a title="TF2 Comics" href="http://www.teamfortress.com/comics.php">Team Fortress 2 comics</a> where the next panel is revealed with a key press, which sounds great but I would not know where to start coding it. I do have two ideas:</p>
<ul>
	<li>Allow a user to upload multiple images in a specific sequence and then use a javascript gallery plugin to arrange the panels into a "page".</li>
	<li>Let the user upload one big image and then get them to use <a title="W3Schools on tag mapping" href="https://www.w3schools.com/tags/tag_map.asp">image tag mapping</a> to pick out the individual panels.</li>
</ul>
<p>Again, sounds plausible but is a real pain to code! I may revisit this idea one day in the future, assuming someone does not already find a solution in the meantime.</p>
<h5><b>Quicker page loading or caching</b></h5>
<p>While building the app I found <a title="ComicNgn" href="http://comixngn.js.org/">ComixNgn</a>, which purportedly optimises comics to load within a single page rather than loading a fresh page every time. This admittedly sounds like a great idea, especially for mobile devices!</p>
<p>However, looking at how ComixNgn does the loading I was worried about integrating it as it appears to just update elements of one page "on the fly". My main concern was how this would affect a search engine's reading of a webcomic loading like this as I consider the search engine optimisation to be imperative to a comic's discovery.</p>
<p>I may revisit this one in the future if I can find an adequate solution. I may just build a native caching option into the app.</p>
<h5><b>Language options (and why is the default UK English?)</b></h5>
<p>To the former I say what a good idea, if only I had the know-how and time!</p>
<p>To the latter, I say that I am British born-and-bred.</p>
<p>If you'd like to adapt the language options for <?php echo $this->config->item('app_name','webcomic'); ?>, please get in touch regarding translations or, preferably, clone the repo on GitHub and add them yourself!</p>
<h5><b>Easier theming</b></h5>
<p>What the ideal webcomic CMS would do is provide a graphical user interface to let you drag-and-drop elements on to the page to "build" your website. If you really want this, I can reluctantly point you in the direction of services like Wix (ergh).</p>
<p>I am a fairly average developer and I have attempted to keep the templating as basic as possible by allowing stubs in regular HTML. In fact I nicked this concept from a website called ComicDish as they used stubs too. I do not particularly want to start coding complicated javascript GUIs for something that can be achieved with the current templating system.</p>
<p>I genuinely believe it is a benefit for people to have a basic understanding of and play with HTML and CSS - if you want a unique website, this is the only real way to get it.</p>
<h5><b>Hiding the transcript</b></h5>
<p>This is one I debated for a long time. Comics like <a title="FreakAngels" href="http://www.freakangels.com/">Warren Ellis' FreakAngels</a> hide the transcript under a "page transcript" link you have to click to reveal it. I was going to do this with the app but decided against it for the following reasons:</p>
<ul>
	<li>Hiding the transcript may mean search engines cannot easily read it, meaning that the contents of the page will not be properly read by them.</li>
	<li>Part of the point of having a transcript is to make the website easier for the visually impaired to read via screen readers. Hiding the transcript behind a button rather negates the aid of helping the visually impaired!</li>
	<li>If you want to hide the transcript by default, this app loads jQuery as standard so it is <a title="StackOverflow post on toggling visibility of HTML elements" href="https://stackoverflow.com/questions/21584623/using-jquery-to-toggle-div-visibility">fairly easy to add code to the templates to handle the toggling of transcript visibility</a>.</li>
</ul>
<h5><b>Set any URL or address to the home page</b></h5>
<p>A genuine request I saw on another webcomic CMS, and I will only say this: your home page should be your most recent comic, period. That's an opinion, sure, but if your comic isn't the main selling point then what's the point?</p>
<p>A work-around for this if you really must have a different home page would be to install this app to a subdirectory and then have your home page as the main index. There, happy?</p>
<h5><b>WordPress import/export functionality</b></h5>
<p>While I am keen to encourage adoption of this platform, I am not keen on having to create a WordPress webcomic in order to build the tools to do so! (I built this app to get away from WordPress after all!)</p>
<p>If anyone would like to give <?php echo $this->config->item('app_name','webcomic'); ?> a try, has an existing WordPress comic and is willing to give me access to their database and files as a case study, I can look at building some migration tools so please do get in touch.</p>
<h4 id="contact">How Do I Contact You?</h4>
<p>The best way to reach out to me is via my website which, at the time of writing, is at <a title="PAYNEful" href="http://www.payneful.co.uk/">my website PAYNEful.co.uk</a> where I have a dedicated <a title="My contact form" href="http://www.payneful.co.uk/site/contact">contact form</a>.</p>
<p>That website also links to my Twitter and GitHub accounts, which are just as good ways of reaching out to me (if not better). I'm usually tooling around the web under the moniker of "RussianGestapo" but please don't let that put you off.</p>

<hr />

<p>That about concludes this user guide. Have fun using <?php echo $this->config->item('app_name','webcomic'); ?>! I plan to. Maybe now I can get back to actually writing and drawing comics...</p>
<p><b><?php echo $this->config->item('app_name','webcomic'); ?> was built and documented by Sean Patrick "RussianGestapo" Payne.</b></p>
