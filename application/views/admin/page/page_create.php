<h1>Add a New Comic Page</h1>
<p>Add a new page to your webcomic!</p>
<div id="update_response" class="hidden"></div>
<form id="upload_page" role="form" method="POST" data-toggle="validator">
	<?php if($chapters){ //Show if chapters ?>
		<div class="form-group">
			<label for="chapter_masterid">Chapter:</label>
			<select class="form-control" name="comic_chapter">
				<option value="">Select a chapter...</option>
				<?php foreach($chapters as $chapter){ ?>
					<?php if(isset($chapter->subchapters)){ ?>
						<?php foreach($chapter->subchapters as $subchapter){ ?>
							<option value="<?php echo $subchapter->chapterid; ?>">
								- <?php echo $subchapter->name; ?>
							</option>
						<?php } ?>
					<?php } ?>
					<option value="<?php echo $chapter->chapterid; ?>">
						<?php echo $chapter->name; ?>
					</option>
				<?php } ?>
			</select>
			<div class="help-block">Select a chapter to assign this page to</div>
		</div>
	<?php } ?>
	<?php $ckeditors = $datepickers = array(); //For collection ?>
	<?php foreach($fields as $fieldname => $values){ ?>
		<?php if($values['type'] == "ckeditor"){ //CKeditor fields ?>
			<div class="form-group">
				<?php $ckeditors[] = "comic_" . $fieldname; //Add to CKEditor array ?>
				<label for="comic_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
				<textarea name="comic_<?php echo $fieldname; ?>" id="comic_<?php echo $fieldname; ?>"></textarea>
				<div class="help-block"><?php echo $values['guide']; ?></div>
			</div>
		<?php } elseif($values['type'] == "date"){ //Date fields ?>
			<div class="form-group">
				<?php $datepickers[] = "comic_" . $fieldname; //Add to datepickers array ?>
				<label for="comic_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
				<div class="input-group date form_date" data-link-field="comic_<?php echo $fieldname; ?>" data-date="<?php echo date('Y-m-d h:i'); ?>" data-date-format="yyyy-mm-dd hh:ii" id="comic_<?php echo $fieldname; ?>">
					<input 
						name="comic_<?php echo $fieldname; ?>" 
						class="form-control" 
						<?php if($values['required'] == TRUE){ ?>
							required 
						<?php } ?>
						size="16" 
						type="text" 
						value="<?php echo date('Y-m-d h:i'); ?>" 
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
					value="" 
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
	<div id="active_tags"></div>
	<hr />
	<div class="form-group">
		<input id="submit_update" type="submit" class="btn btn-default center-block" value="Create" />
	</div>
</form>
<!-- Success dialogue -->
<div id="success" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Page created successfully...</h3>
			</div>
			<div class="modal-body">
				<p class="text-center">Now redirecting to page management screen!</p>
				<p class="text-center"><img src="/assets/icons/loading<?php if($settings['site_webby'] == "Yes"){ ?>-webby<?php } ?>.gif" /></p>
			</div>
		</div>
	</div>
</div>
<?php if(!empty($ckeditors) || !empty($datepickers)){ //Instantiations ?>
	<script type="text/javascript">
		
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
		
		<?php $this->load->view('js/admin/page/page_tags.js'); //Load tags .js file ?>
		
	</script>
<?php } ?>
