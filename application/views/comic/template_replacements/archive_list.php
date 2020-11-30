<?php if(isset($archive)){ ?>
	<?php if(!$archive){ ?>
		<p>This comic does not appear to have anything in it yet. It must be a newborn baby comic!</p>
	<?php } else { ?>
		<?php
			//Set list type
			if($site['site_archive_list'] == "Numbered"){
				$open_tag 	= "<ol>";
				$close_tag 	= "</ol>";
			} else {
				$open_tag 	= "<ul>";
				$close_tag 	= "</ul>";
			}
		?>
		<?php foreach($archive as $chapter){ ?>
			<?php if(!empty($chapter->pages) || !empty($chapter->subchapters)){ //Only show if pages or subchapters ?>
				<hr />
				<?php if($chapter->name != "No chapter set"){ ?>
					<h2><?php echo $chapter->name; ?></h2>
				<?php } ?>
				<?php if($chapter->description){ echo $chapter->description; } ?>
				<?php if(!empty($chapter->pages)){ ?>
					<?php echo $open_tag; ?>
						<?php foreach($chapter->pages as $page){ ?>
							<li><a href="<?php echo base_url(); ?>page/<?php echo $page->slug; ?>"><?php echo $page->name; ?></a></li>
						<?php } ?>
					<?php echo $close_tag; ?>
				<?php } ?>
				<?php if(!empty($chapter->subchapters)){ //Only show if subchapters ?>
					<?php foreach($chapter->subchapters as $subchapter){ ?>
						<?php if(!empty($subchapter->pages)){ //Only show if pages ?>
							<h3><?php echo $subchapter->name; ?></h3>
							<?php if($subchapter->description){ echo $subchapter->description; } ?>
							<?php echo $open_tag; ?>
								<?php foreach($subchapter->pages as $page){ ?>
									<li><a href="<?php echo base_url(); ?>page/<?php echo $page->slug; ?>"><?php echo $page->name; ?></a></li>
								<?php } ?>
							<?php echo $close_tag; ?>
						<?php } else { continue; } ?>
					<?php } ?>
				<?php } else { continue; } ?>
			<?php } ?>
		<?php } ?>
	<?php } ?>
<?php } ?>