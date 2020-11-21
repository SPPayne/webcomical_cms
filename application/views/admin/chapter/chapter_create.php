<h1>Add a New <?php echo ucfirst($type); ?></h1>
<p>Add a new <?php echo $type; ?> to your webcomic!</p>
<div id="update_response" class="hidden"></div>
<form id="upload_chapter" role="form" method="POST" data-toggle="validator">
	<?php if($type == "subchapter"){ ?>
		<div class="form-group">
			<label for="chapter_masterid">Main Chapter:</label>
			<select class="form-control" name="chapter_masterid">
				<option value="">Select a chapter...</option>
				<?php foreach($chapters as $chapter){ //Shouldn't need to check this as page redirects if no values... ?>
					<option value="<?php echo $chapter->chapterid; ?>"><?php echo $chapter->name; ?></option>
				<?php } ?>
			</select>
		</div>
	<?php } ?>
	<?php $ckeditors = array(); //For collection ?>
	<?php foreach($fields as $fieldname => $values){ ?>
		<?php if($values['type'] == "ckeditor"){ //CKeditor fields ?>
			<div class="form-group">
				<?php $ckeditors[] = "chapter_" . $fieldname; //Add to CKEditor array ?>
				<label for="chapter_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
				<textarea name="chapter_<?php echo $fieldname; ?>" id="chapter_<?php echo $fieldname; ?>"></textarea>
				<div class="help-block"><?php echo $values['guide']; ?></div>
			</div>
		<?php } else { //Regular input fields ?>
			<div class="form-group has-feedback">
				<label for="chapter_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
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
					id="chapter_<?php echo $fieldname; ?>" 
					name="chapter_<?php echo $fieldname; ?>" 
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
		<input type="hidden" name="chapter_type" value="<?php echo $type; ?>" />
	<?php } ?>
	<div class="form-group">
		<input id="submit_update" type="submit" class="btn btn-default center-block" value="Create" />
	</div>
</form>
<?php if(!empty($ckeditors)){ //Instantiations ?>
	<script type="text/javascript">
		<?php if(!empty($ckeditors)){ ?>
			//Replace textareas with CKEditor
			<?php foreach($ckeditors as $ckeditor){ ?>
				CKEDITOR.replace('<?php echo $ckeditor; ?>');
				CKEDITOR.add
			<?php } ?>
		<?php } ?>
	</script>
<?php } ?>
<!-- Success dialogue -->
<div id="success" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Chapter created successfully...</h3>
			</div>
			<div class="modal-body">
				<p class="text-center">Now redirecting to chapter management screen!</p>
				<p class="text-center"><img src="<?php echo base_url(); ?>assets/icons/loading<?php if($settings['site_webby'] == "Yes"){ ?>-webby<?php } ?>.gif" /></p>
			</div>
		</div>
	</div>
</div>
