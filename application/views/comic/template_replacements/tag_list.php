<?php if(isset($tag) || isset($pages)){ ?>
	<?php if(isset($tag->characterid)){ ?>
		<p><a href="/character_profiles/<?php echo $tag->slug; ?>">View <?php echo $tag->name; ?>'s full profile</a></p>
	<?php } ?>
	<?php if(!$pages){ ?>
		<p>No <?php echo strtolower($site['site_page_term']); ?>s found!</p>
	<?php } else { ?>
		<?php if($pagination){ ?>
			<?php echo $pagination; ?>
		<?php } ?>
		<?php $cnt = 1; ?>
		<div class="row">
			<?php foreach($pages as $page){ ?>
				<div class="col-xs-12 col-sm-3">
					<a class="tag-link" title="<?php echo $page->name; ?>" href="/page/<?php echo $page->slug; ?>">
						<?php if(pathinfo($page->filename,PATHINFO_EXTENSION) != "swf"){ ?>
							<div class="tag-thumbnail">
								<div class="tag-thumbnail-img" style="background-size: 100%; background-image:url('/assets/pages/<?php echo $page->filename; ?>')"></div>
							</div>
						<?php } else { ?>
							<div class="tag-thumbnail" style="background-image:url('/assets/icons/flash.png')" >
								<p class="center block">Adobe Flash File</p>
							</div>
						<?php } ?>
					</a>
					<p><a href="/page/<?php echo $page->slug; ?>"><?php echo $page->name; ?></a> - <?php echo date($site['site_date_format'],strtotime($page->published)); ?></p>
				</div>
				<?php if($cnt % 4 == 0 || $cnt == 0){ ?>
					</div>
					<div class="row">
				<?php } ?>
				<?php $cnt++; ?>
			<?php } ?>
		</div>
		<?php if($pagination){ ?>
			<?php echo $pagination; ?>
		<?php } ?>
	<?php } ?>
<?php } ?>
