<?php if(isset($nav)){ ?>
	<?php if($nav){ ?>
		
		<?php if(!isset($nav_place)){ $nav_place = "bottom"; } ?>
		
		<?php 
			if(
				$nav['first_page'] || 
				in_array('chapter_jump',$nav_config[$nav_place]) || 
				$nav['prev_page'] || 
				in_array('random',$nav_config[$nav_place]) || 
				$nav['next_page'] || 
				in_array('chapter_jump',$nav_config[$nav_place]) || 
				$nav['last_page']
			){ //Pain in the arse but best way to test... 
		?>
		
			<nav id="navbar_<?php echo $nav_place; ?>" class="navbar navbar-default comic-navbar <?php if($nav_place == "top"){ ?>hidden-xs<?php } ?>">
				<div class="nav-justified comic-navbar-contents" id="navbar_<?php echo $nav_place; ?>_items">
					<ul class="nav navbar-nav">
						
						<?php if($nav['first_page']){ //First page ?>
							<li>
								<?php $this->load->view('comic/template_replacements/comic_nav_button_first'); ?>
							</li>
						<?php } ?>
						
						<?php if(in_array('chapter_jump',$nav_config[$nav_place])){ //Jump to chapter beginning (configurable) ?>
							<?php if($nav['chapter_jump']['start']){ ?>
								<li>
									<?php $this->load->view('comic/template_replacements/comic_nav_button_chapter_jump_start'); ?>
								</li>
							<?php } ?>
						<?php } ?>
						
						<?php if($nav['prev_page']){ //Previous page ?>
							<li>
								<?php $this->load->view('comic/template_replacements/comic_nav_button_previous'); ?>
							</li>
						<?php } ?>
						
						<?php if(in_array('random',$nav_config[$nav_place])){ //Random page link (configurable) ?>
							<?php if($nav['rand_page']){ ?>
								<li>
									<?php $this->load->view('comic/template_replacements/comic_nav_button_random'); ?>
								</li>
							<?php } ?>
						<?php } ?>
						
						<?php if($nav['next_page']){ //Next page ?>
							<li>
								<?php $this->load->view('comic/template_replacements/comic_nav_button_next'); ?>
							</li>
						<?php } ?>
						
						<?php if(in_array('chapter_jump',$nav_config[$nav_place])){ //Jump to chapter end (configurable) ?>
							<?php if($nav['chapter_jump']['end']){ ?>
								<li>
									<?php $this->load->view('comic/template_replacements/comic_nav_button_chapter_jump_end'); ?>
								</li>
							<?php } ?>
						<?php } ?>
						
						<?php if($nav['last_page']){ //Last page ?>
							<li>
								<?php $this->load->view('comic/template_replacements/comic_nav_button_last'); ?>
							</li>
						<?php } ?>

					</ul>
				</div>
			</nav>
		
		<?php } ?>
		
		<?php if(in_array('chapter_select',$nav_config[$nav_place])){ //Chapter select (configurable) ?>
			<?php if($nav['chapter_select'] && !empty($nav['chapter_select'])){ ?>
				<?php $this->load->view('comic/template_replacements/chapter_select'); ?>
			<?php } ?>
		<?php } ?>
		
		<?php if(in_array('page_select',$nav_config[$nav_place])){ //Page select (configurable) ?>
			<?php if($nav['page_select'] && !empty($nav['page_select'])){ ?>
				<?php $this->load->view('comic/template_replacements/page_select'); ?>
			<?php } ?>
		<?php } ?>
		
		<?php if(in_array('bookmark',$nav_config[$nav_place])){ //Bookmark (configurable) ?>
			<?php $this->load->view('comic/template_replacements/comic_nav_bookmark_buttons'); ?>
		<?php } ?>
		
	<?php } ?>
<?php } ?>