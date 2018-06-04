<?php if(isset($nav)){ ?>
	<?php if($nav){ ?>
		<?php if(!isset($nav_place)){ $nav_place = "bottom"; } ?>
		<?php if($nav['page_select'] && !empty($nav['page_select'])){ //Page select (configurable) ?>
			<div class="form-group">
				<label for="page_select_<?php echo $nav_place; ?>"><?php echo $site['site_page_term']; ?> Select:</label>
				<select class="form-control page_select" id="page_select_<?php echo $nav_place; ?>">
					<?php foreach($nav['page_select'] as $chapter){ ?>
						<?php if(!empty($chapter->subchapters)){ //Only show if subchapters ?>
							<?php foreach($chapter->subchapters as $subchapter){ ?>
								<?php if(!empty($subchapter->pages)){ //Only show if pages ?>
									<?php foreach($subchapter->pages as $subpage){ ?>
										<option <?php if($page->comicid == $subpage->comicid){ ?>selected="selected"<?php } ?> value="<?php echo $subpage->slug; ?>"><?php echo $subpage->name; ?></option>
									<?php } ?>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						<?php if(!empty($chapter->pages)){ //Only show if pages ?>
							<?php foreach($chapter->pages as $mainpage){ ?>
								<option <?php if($page->comicid == $mainpage->comicid){ ?>selected="selected"<?php } ?> value="<?php echo $mainpage->slug; ?>"><?php echo $mainpage->name; ?></option>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
		<?php } ?>
	<?php } ?>
<?php } ?>