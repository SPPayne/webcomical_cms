<?php if(isset($nav)){ ?>
	<?php //print_r($nav); //DEBUG ?>
	<?php if($nav){ ?>
		<?php if(!isset($nav_place)){ $nav_place = "bottom"; } ?>
		<?php if($nav['chapter_select'] && !empty($nav['chapter_select'])){ //Chapter select (configurable) ?>
			<div class="form-group">
				<label for="chapter_select_<?php echo $nav_place; ?>"><?php echo $site['site_chapter_term']; ?> Select:</label>
				<select class="form-control chapter_select" id="chapter_select_<?php echo $nav_place; ?>">
					<?php foreach($nav['chapter_select'] as $chapter => $urls){ ?>
						<?php if(isset($urls['subs']) && !empty($urls['subs'])){ ?>
							<?php foreach($urls['subs'] as $subchapter => $suburls){ ?>
								<option <?php if($page->chapterid == $suburls->chapterid){ ?>selected="selected"<?php } ?> value="<?php echo $suburls->slug; ?>"> - <?php echo $subchapter; ?></option>
							<?php } ?>
						<?php } ?>
						<?php if(isset($urls['main']) && !empty($urls['main'])){ ?>
							<option <?php if($page->chapterid == $urls['main']->chapterid){ ?>selected="selected"<?php } ?> value="<?php echo $urls['main']->slug; ?>"><?php echo $chapter; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
		<?php } ?>
	<?php } ?>
<?php } ?>
