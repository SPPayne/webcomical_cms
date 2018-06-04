<?php if(!$about){ ?>
	<p>Nothing to see here!</p>
<?php } else { ?>
	<h1><?php $this->load->view('comic/template_replacements/about_title'); ?></h1>
	<?php $this->load->view('comic/template_replacements/about_details'); ?>
<?php } ?>
