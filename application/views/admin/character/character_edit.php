<h1>Edit Character "<?php echo $character->name; ?>"</h1>
<p>Edit this character below!</p>
<p>Max file size: 10MB. Max dimensions: 1000px x 1000px. File types allowed: .jpg .png .gif</p>
<label>Upload profile image:</label>
<?php
	//File upload button hacked into shape in separate file
	//Ref: http://www.abeautifulsite.net/whipping-file-inputs-into-shape-with-bootstrap-3/
	$this->load->view('/admin/shared/admin_file_upload');
?>
<hr />
<div id="update_response" class="hidden"></div>
<?php if($character->filename){ ?>
	<p><a href="/assets/characters/<?php echo $character->filename; ?>" target="_blank">Preview profile image</a></p>
<?php } ?>
<form id="upload_character" role="form" method="POST" data-toggle="validator">
	<?php $ckeditors = array(); //For collection ?>
	<?php foreach($fields as $fieldname => $values){ ?>
		<?php $value = $values['db_field']; //PHP7 is not a big fan of using array vals to point to objects so redeclare here ?>
		<?php if($values['type'] == "ckeditor"){ //CKeditor fields ?>
			<div class="form-group">
				<?php $ckeditors[] = "character_" . $fieldname; //Add to CKEditor array ?>
				<label for="character_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
				<textarea name="character_<?php echo $fieldname; ?>" id="character_<?php echo $fieldname; ?>">
					<?php echo $character->$value; ?>
				</textarea>
				<div class="help-block"><?php echo $values['guide']; ?></div>
			</div>
		<?php } elseif($values['type'] == "checkbox"){ //Checkboxes ?>
			<div class="checkbox">
				<label for="character_<?php echo $fieldname; ?>">
					<input
						type="checkbox" 
						id="character_<?php echo $fieldname; ?>" 
						name="character_<?php echo $fieldname; ?>" 
						value="Y" 
						<?php if($character->$value == "Y"){ ?>checked<?php } ?> 
					/> <?php echo $values['label']; ?>
				</label>
				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				<div class="help-block with-errors"><?php echo $values['guide']; ?></div>
			</div>
		<?php } else { //Regular input fields ?>
			<div class="form-group has-feedback">
				<label for="character_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
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
					id="character_<?php echo $fieldname; ?>" 
					name="character_<?php echo $fieldname; ?>" 
					value="<?php echo $character->$value; ?>" 
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
	<div class="form-group">
		<input id="submit_update" type="submit" class="btn btn-default center-block" value="Update" />
	</div>
</form>
<script type="text/javascript">

	<?php if(!empty($ckeditors)){ //Instantiations ?>
	
		<?php if(!empty($ckeditors)){ ?>
			//Replace textareas with CKEditor
			<?php foreach($ckeditors as $ckeditor){ ?>
				CKEDITOR.replace('<?php echo $ckeditor; ?>');
				CKEDITOR.add
			<?php } ?>
		<?php } ?>
		
	<?php } ?>
	
	//Set chapterid
	var characterid = <?php echo $character->characterid; ?>;
	
</script>
<!-- Success dialogue -->
<div id="success" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Character created successfully...</h3>
			</div>
			<div class="modal-body">
				<p class="text-center">Now redirecting to character management screen!</p>
				<p class="text-center"><img src="/assets/icons/loading<?php if($settings['site_webby'] == "Yes"){ ?>-webby<?php } ?>.gif" /></p>
			</div>
		</div>
	</div>
</div>
