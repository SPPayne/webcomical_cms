	<!-- Header business -->
	<div id="the-comic-banner" class="center-block text-center">
		<?php $this->load->view('comic/template_replacements/comic_banner'); //Use template ?>
		<?php if(isset($site['site_updates_on'])){ ?><p>Updates <?php echo strtolower($site['site_updates_on']); ?></p><?php } ?>
	</div>
