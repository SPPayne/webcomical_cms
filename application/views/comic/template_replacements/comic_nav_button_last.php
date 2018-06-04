<?php if(isset($nav)){ ?>
	<?php if($nav['last_page'] && !empty($nav['last_page'])){ //Last page ?>
		<a title="Last <?php echo $site['site_page_term']; ?>" class="nav-link" href="/page/<?php echo $nav['last_page']->slug; ?>">
			<img 
				class="comic-nav-button-last comic-nav-button" 
				alt="Last <?php echo $site['site_page_term']; ?>" 
				title="Last <?php echo $site['site_page_term']; ?>" 
				src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAABkAQMAAAD5SO1IAAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAABlJREFUeNrtwYEAAAAAw6D5Ux/gClUBAMAbCigAAeeGOykAAAAASUVORK5CYII=" 
			/>
		</a>
	<?php } ?>
<?php } ?>