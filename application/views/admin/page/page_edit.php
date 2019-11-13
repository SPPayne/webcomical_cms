<h1>Edit Page "<?php echo $page->name; ?>"</h1>
<p>Edit the page details below! Or <a href="/admin/manage_pages">click here to edit another page</a>.</p>
<?php if($nav && ($nav['first_page'] || $nav['prev_page'] || $nav['next_page'] || $nav['last_page'])){ ?>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<ul class="nav navbar-nav">
				<?php if($nav['first_page']){ ?>
					<li>
						<a href="/admin/create_page/<?php echo $nav['first_page']->comicid ?>">
							<span class="glyphicon glyphicon-fast-backward"></span> First page
						</a>
					</li>
				<?php } ?>
				<?php if($nav['prev_page']){ ?>
					<li>
						<a href="/admin/create_page/<?php echo $nav['prev_page']->comicid ?>">
							<span class="glyphicon glyphicon-step-backward"></span> Previous page
						</a>
					</li>
				<?php } ?>
				<?php if($nav['next_page']){ ?>
					<li>
						<a href="/admin/create_page/<?php echo $nav['next_page']->comicid ?>">
							Next page <span class="glyphicon glyphicon-step-forward"></span>
						</a>
					</li>
				<?php } ?>
				<?php if($nav['last_page']){ ?>
					<li>
						<a href="/admin/create_page/<?php echo $nav['last_page']->comicid ?>">
							Last page <span class="glyphicon glyphicon-fast-forward"></span>
						</a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</nav>
<?php } ?>
<p>Max file size: <?php echo ($upload_rules['pages']['max_size']/1000); ?>MB. Max dimensions: <?php echo $upload_rules['pages']['max_width']; ?>px x <?php echo $upload_rules['pages']['max_height']; ?>px. File types allowed: .<?php echo implode(' .',explode('|',$upload_rules['pages']['allowed_types'])); ?></p><label>Upload page:</label>
<?php
	//File upload button hacked into shape in separate file
	//Ref: http://www.abeautifulsite.net/whipping-file-inputs-into-shape-with-bootstrap-3/
	$this->load->view('/admin/shared/admin_file_upload');
?>
<?php if($page->filename){ ?>
	<p>
		<a href="/assets/pages/<?php echo $page->filename; ?>" target="_blank">Preview comic file <span class="glyphicon glyphicon-new-window"></span></a>
	</p>
	<p>
		<a href="/page/<?php echo $page->slug; ?>/preview" target="_blank">
			View page on the website <span class="glyphicon glyphicon-new-window"></span>
		</a>
	</p>
<?php } ?>
<hr />
<div id="update_response" class="hidden"></div>
<form id="upload_page" role="form" method="POST" data-toggle="validator">
	<?php if($chapters){ //Show if chapters ?>
		<div class="form-group">
			<label for="comic_chapter">Chapter:</label>
			<select class="form-control" name="comic_chapter">
				<option value="">Select a chapter...</option>
				<?php foreach($chapters as $chapter){ ?>
					<?php if(isset($chapter->subchapters)){ ?>
						<?php foreach($chapter->subchapters as $subchapter){ ?>
							<option value="<?php echo $subchapter->chapterid; ?>" <?php if($subchapter->chapterid == $page->chapterid){ ?>selected="selected"<?php } ?>>
								- <?php echo $subchapter->name; ?>
							</option>
						<?php } ?>
					<?php } ?>
					<option value="<?php echo $chapter->chapterid; ?>" <?php if($chapter->chapterid == $page->chapterid){ ?>selected="selected"<?php } ?>>
						<?php echo $chapter->name; ?>
					</option>
				<?php } ?>
			</select>
			<div class="help-block">Select a chapter to assign this page to</div>
		</div>
	<?php } ?>
	<?php $ckeditors = $datepickers = array(); //For collection ?>
	<?php foreach($fields as $fieldname => $values){ ?>
		<?php $value = $values['db_field']; //PHP7 is not a big fan of using array vals to point to objects so redeclare here ?>
		<?php if($values['type'] == "ckeditor"){ //CKeditor fields ?>
			<div class="form-group">
				<?php $ckeditors[] = "comic_" . $fieldname; //Add to CKEditor array ?>
				<label for="comic_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
				<textarea name="comic_<?php echo $fieldname; ?>" id="comic_<?php echo $fieldname; ?>">
					<?php echo $page->$value; ?>
				</textarea>
				<div class="help-block"><?php echo $values['guide']; ?></div>
			</div>
		<?php } elseif($values['type'] == "date"){ //Date fields ?>
			<div class="form-group">
				<?php $datepickers[] = "comic_" . $fieldname; //Add to datepickers array ?>
				<label for="comic_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
				<div class="input-group date form_date" data-link-field="comic_<?php echo $fieldname; ?>" data-date="<?php echo date('Y-m-d H:i'); ?>" data-date-format="yyyy-mm-dd hh:ii" id="comic_<?php echo $fieldname; ?>">
					<input 
						name="comic_<?php echo $fieldname; ?>" 
						class="form-control" 
						<?php if($values['required'] == TRUE){ ?>
							required 
						<?php } ?>
						size="16" 
						type="text" 
						value="<?php echo date('Y-m-d H:i',$page->$value); ?>" 
						readonly 
					/>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
				<div class="help-block with-errors"><?php echo $values['guide']; ?></div>
			</div>
		<?php } else { //Regular input fields ?>
			<div class="form-group has-feedback">
				<label for="comic_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
				<input
					<?php if(isset($values['minlength'])){ ?>
						data-minlength="<?php echo $values['minlength']; ?>" 
					<?php } ?>
					<?php if(isset($values['pattern'])){ ?>
						pattern="<?php echo $values['pattern']; ?>"
					<?php } ?> 
					<?php if(isset($values['maxlength'])){ ?>
						maxlength="<?php echo $values['maxlength']; ?>"
					<?php } ?> 
					type="<?php echo $values['type']; ?>" 
					class="form-control" 
					id="comic_<?php echo $fieldname; ?>" 
					name="comic_<?php echo $fieldname; ?>" 
					value="<?php echo $page->$value; ?>" 
					data-error="Not a valid <?php echo strtolower($fieldname); ?>!" 
					autocomplete="off" 
					<?php if($values['required'] == TRUE){ ?>
						required 
					<?php } ?>
				/>
				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				<div class="help-block with-errors"><?php echo $values['guide']; ?></div>
			</div>
		<?php } ?>
	<?php } ?>
	<?php if($characters){ //Add characters to page ?>
		<hr />
		<label>Which characters appear in this page?</label>
		<?php foreach($characters as $char){ ?>
			<div class="checkbox">
				<label for="character_<?php echo $char->characterid; ?>">
					<input
						type="checkbox" 
						id="character_<?php echo $char->characterid; ?>" 
						name="comic_characters[]" 
						value="<?php echo $char->characterid; ?>" 
						<?php if($characters_in_page && array_key_exists($char->characterid,$characters_in_page)){ ?>checked<?php } ?> 
					/> <?php echo $char->name; ?>
				</label>
			</div>
		<?php } ?>
	<?php } ?>
	<hr />
	<label>Page Tags:</label>
	<div class="form-group">
		<div id="comic_tag_search" class="input-group">
			<input data-minlength="2" pattern="[A-z0-9 !?'-\.:&quot;&amp;]{1,}" maxlength="255" type="text" class="form-control" id="comic_tag" value="" data-error="Not a valid tag!" placeholder="Enter tag here and click the add button on the right!" autocomplete="off" />
			<span class="input-group-btn">
				<button id="add-tag-btn" type="button" class="btn btn-primary">+ Add tag</button>
			</span>
		</div>
	</div>
	<div id="active_tags">
		<?php if($tags_in_page){ ?>
			<?php foreach($tags_in_page as $tag){ ?>
				<span class="active_tag" id="tag-<?php echo $tag['tagid']; ?>" >
					<?php echo $tag['label']; ?> <span class="glyphicon glyphicon-remove delete-tag"></span>
					<input type="hidden" name="comic_tags[]" value="<?php echo $tag['tagid']; ?>" />
				</span>
			<?php } ?>
		<?php } ?>
	</div>
	<hr />
	<div class="form-group">
		<input id="submit_update" type="submit" class="btn btn-default center-block" value="Update" />
	</div>
</form>
<script type="text/javascript">

	<?php if(!empty($ckeditors) || !empty($datepickers)){ //Instantiations ?>
		
		<?php if(!empty($ckeditors)){ ?>
			//Replace textareas with CKEditor
			<?php foreach($ckeditors as $ckeditor){ ?>
				CKEDITOR.replace('<?php echo $ckeditor; ?>');
				CKEDITOR.add
			<?php } ?>
		<?php } ?>
		
		<?php if(!empty($datepickers)){ ?>
			//Add datepicker/s
			<?php foreach($datepickers as $datepicker){ ?>
				    $('#<?php echo $datepicker; ?>').datetimepicker();
			<?php } ?>
		<?php } ?>
		
	<?php } ?>
	
	//Set chapterid
	var pageid = <?php echo $page->comicid; ?>;
	
	<?php $this->load->view('js/admin/page/page_tags.js'); //Load tags .js file ?>
	
</script>
