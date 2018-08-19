<?php if(isset($nav)){ ?>
	<?php if($nav['next_page'] && !empty($nav['next_page'])){ //Next page ?>
		<a title="Next <?php echo $site['site_page_term']; ?>" class="nav-link next_page" href="/page/<?php echo $nav['next_page']->slug; ?><?php if($nav['preview']){ ?>/preview<?php } ?>">
			<img 
				class="comic-nav-button-next comic-nav-button" 
				alt="Next <?php echo $site['site_page_term']; ?>" 
				title="Next <?php echo $site['site_page_term']; ?>" 
				src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAABkAQMAAAD5SO1IAAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAABlJREFUeNrtwYEAAAAAw6D5Ux/gClUBAMAbCigAAeeGOykAAAAASUVORK5CYII=" 
			/>
		</a>
	<?php } ?>
<?php } ?>