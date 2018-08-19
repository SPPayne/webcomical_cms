<?php if(isset($nav)){ ?>
	<?php if($nav['prev_page'] && !empty($nav['prev_page'])){ //Previous page ?>
		<a title="Previous <?php echo $site['site_page_term']; ?>" class="nav-link prev_page" href="/page/<?php echo $nav['prev_page']->slug; ?><?php if($nav['preview']){ ?>/preview<?php } ?>">
			<img 
				class="comic-nav-button-prev comic-nav-button" 
				alt="Previous <?php echo $site['site_page_term']; ?>" 
				title="Previous <?php echo $site['site_page_term']; ?>" 
				src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAABkAQMAAAD5SO1IAAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAABlJREFUeNrtwYEAAAAAw6D5Ux/gClUBAMAbCigAAeeGOykAAAAASUVORK5CYII=" 
			/>
		</a>
	<?php } ?>
<?php } ?>