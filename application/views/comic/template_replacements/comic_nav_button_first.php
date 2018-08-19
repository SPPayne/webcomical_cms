<?php if(isset($nav)){ ?>
	<?php if($nav['first_page'] && !empty($nav['first_page'])){?>
		<a title="First <?php echo $site['site_page_term']; ?>" class="nav-link" href="/page/<?php echo $nav['first_page']->slug; ?><?php if($nav['preview']){ ?>/preview<?php } ?>">
			<img 
				class="comic-nav-button-first comic-nav-button" 
				alt="First <?php echo $site['site_page_term']; ?>" 
				title="First <?php echo $site['site_page_term']; ?>" 
				src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAABkAQMAAAD5SO1IAAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAABlJREFUeNrtwYEAAAAAw6D5Ux/gClUBAMAbCigAAeeGOykAAAAASUVORK5CYII=" 
			/>
		</a>
	<?php } ?>
<?php } ?>