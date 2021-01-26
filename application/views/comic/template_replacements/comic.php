<?php if(isset($page)){ ?>
	<?php if($page && isset($page->filename)){ ?>
		<div class="center-block" id="the-comic-wrapper">
			<?php $filename = base_url() . 'assets/pages/' . $page->filename; ?>
			<img id="the-comic" class="center-block img-responsive" title="<?php echo $page->title_text; ?>" alt="<?php echo $page->name; ?>" src="<?php echo $filename; ?>" />
		</div>
	<?php } else { ?>
		<p>Page appears to be missing... :'(</p>
	<?php } ?>
<?php } ?>