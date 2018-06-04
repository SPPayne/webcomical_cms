<?php if($page){ ?>
	<div id="page-container" class="center-block text-center">
		<div id="the-comic-title">
			<h1><?php $this->load->view('comic/template_replacements/page_name'); //Use template ?></h1>
			<?php if(isset($current_chapter)){ ?><p><strong>Current <?php echo $site['site_chapter_term']; ?> - </strong> <?php $this->load->view('comic/template_replacements/page_chapter_name'); //Use template ?></p><?php } ?>
		</div>
		<?php $this->load->view('comic/template_replacements/comic'); //Use template ?>
	</div>
<?php } ?>
