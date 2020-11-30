<?php if(isset($nav)){ ?>
	<?php if($nav['chapter_jump']['end'] && !empty($nav['chapter_jump']['end'])){ ?>
		<a title="Last <?php echo $site['site_page_term']; ?> in <?php echo $site['site_chapter_term']; ?>" href="<?php echo base_url(); ?>page/<?php echo $nav['chapter_jump']['end']->slug; ?><?php if($nav['preview']){ ?>/preview<?php } ?>">
			<img 
				class="comic-nav-button-chapterlast comic-nav-button" 
				alt="Last <?php echo $site['site_page_term']; ?> in <?php echo $site['site_chapter_term']; ?>" 
				title="Last <?php echo $site['site_page_term']; ?> in <?php echo $site['site_chapter_term']; ?>" 
				src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAABkAQMAAAD5SO1IAAAAA1BMVEX///+nxBvIAAAAAXRSTlMAQObYZgAAABlJREFUeNrtwYEAAAAAw6D5Ux/gClUBAMAbCigAAeeGOykAAAAASUVORK5CYII=" 
			/>
		</a>
	<?php } ?>
<?php } ?>