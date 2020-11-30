<?php if(isset($nav)){ ?>
	<?php if($nav['rand_page'] && !empty($nav['rand_page'])){ ?>
		<a title="Random <?php echo $site['site_page_term']; ?>" class="nav-link" href="<?php echo base_url(); ?>page/<?php echo $nav['rand_page']->slug; ?><?php if($nav['preview']){ ?>/preview<?php } ?>">
			<img 
				class="comic-nav-button-random comic-nav-button" 
				alt="Random <?php echo $site['site_page_term']; ?>" 
				title="Random <?php echo $site['site_page_term']; ?>" 
				src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAABkAQMAAAD5SO1IAAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAABlJREFUeNrtwYEAAAAAw6D5Ux/gClUBAMAbCigAAeeGOykAAAAASUVORK5CYII=" 
			/>
		</a>
	<?php } ?>
<?php } ?>