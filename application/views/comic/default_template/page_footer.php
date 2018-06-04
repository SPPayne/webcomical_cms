<div class="center-block text-center">
	
	<div class="text-left">
		
		<div id="the-comic-notes">
		
			<h2>Notes</h2>
			
			<p><?php $this->load->view('comic/template_replacements/page_published_date'); //Use template ?></p>
		
			<!-- Page notes -->
			<?php $this->load->view('comic/template_replacements/page_notes'); //Use template ?>
			
		</div>
		
		<div id="the-comic-tags">
		
			<!-- Page tags -->
			<p><?php $this->load->view('comic/template_replacements/page_tags'); //Use template ?></p>
			
		</div>

	</div>
	
	<?php if(isset($site['site_comments']) && !empty($site['site_comments'])){ ?>
		<div id="the-comic-comments">
		
			<h2>Comments</h2>

			<!-- Page comments -->
			<?php $this->load->view('comic/template_replacements/page_comments'); //Use template ?>
	
		</div>
	<?php } ?>
	
	<div class="text-left">
	
		<div id="the-comic-transcript">
		
			<h2>Transcript</h2>
		
			<!-- Page transcript -->
			<?php $this->load->view('comic/template_replacements/page_transcript'); //Use template ?>
			
		</div>
	
	</div>
	
</div>
