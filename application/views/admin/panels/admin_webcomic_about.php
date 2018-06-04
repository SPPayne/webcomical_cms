<h1>About the Comic</h1>
<p>Most webcomics have an "about" page which describes the premise of the comic and/or provides a synopsis, usually targeted at new or potential readers.</p>
<p>Using this page you can set a title for the about page and use it for whatever you like!</p>
<p>Leaving the fields blank will mean that the "about" page will not be shown in the navigation bar for the website.</p>
<div id="update_response" class="hidden"></div>
<form id="about_update" role="form" method="POST" data-toggle="validator">
	<?php $ckeditors = array(); //For collection ?>
	<?php foreach($fields as $fieldname => $values){ ?>
		<?php if($values['type'] == "ckeditor"){ //CKeditor fields ?>
			<div class="form-group">
				<?php $ckeditors[] = "about_" . $fieldname; //Add to CKEditor array ?>
				<label for="about_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
				<textarea name="about_<?php echo $fieldname; ?>" id="about_<?php echo $fieldname; ?>">
					<?php if($about){ echo $about[$values['db_field']]; } ?>
				</textarea>
				<div class="help-block"><?php echo $values['guide']; ?></div>
			</div>
		<?php } else { //Regular input fields ?>
			<div class="form-group has-feedback">
				<label for="about_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
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
					id="about_<?php echo $fieldname; ?>" 
					name="about_<?php echo $fieldname; ?>" 
					value="<?php if($about){ echo $about[$values['db_field']]; } ?>" 
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
	
</script>
