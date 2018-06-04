<?php if(isset($nav)){ ?>
	<?php if($nav['chapter_jump']['start'] && !empty($nav['chapter_jump']['start'])){ ?>
		<a title="First <?php echo $site['site_page_term']; ?> in <?php echo $site['site_chapter_term']; ?>" class="nav-link" href="/page/<?php echo $nav['chapter_jump']['start']->slug; ?>">
			<img 
				class="comic-nav-button-chapterfirst comic-nav-button" 
				alt="First <?php echo $site['site_page_term']; ?> in <?php echo $site['site_chapter_term']; ?>" 
				title="First <?php echo $site['site_page_term']; ?> in <?php echo $site['site_chapter_term']; ?>" 
				src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAABkAQMAAAD5SO1IAAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAABlJREFUeNrtwYEAAAAAw6D5Ux/gClUBAMAbCigAAeeGOykAAAAASUVORK5CYII=" 
			/>
		</a>
	<?php } ?>
<?php } ?>