<h1>Edit Tag</h1>
<p>You can edit this tag to something different - please note that the tag must not match an existing tag or character name. Changing the tag will create a new redirect rule under the redirects panel.</p>
<div id="create_response" class="hidden"></div>
<form id="create_tag" role="form" method="POST" data-toggle="validator">
	<?php foreach($fields as $fieldname => $values){ ?>
		<?php $value = $values['db_field']; //PHP7 is not a big fan of using array vals to point to objects so redeclare here ?>
		<div class="form-group has-feedback">
			<label for="tags_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
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
				id="tags_<?php echo $fieldname; ?>" 
				name="tags_<?php echo $fieldname; ?>" 
				value="<?php echo $tag->$value; ?>" 
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
	<div class="form-group">
		<input id="submit_update" type="submit" class="btn btn-default center-block" value="Update" />
	</div>
</form>
<!-- Success dialogue -->
<div id="success" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Tag updated successfully...</h3>
			</div>
			<div class="modal-body">
				<p class="text-center">Now redirecting to tag management screen!</p>
				<p class="text-center"><img src="<?php echo base_url(); ?>assets/icons/loading<?php if($settings['site_webby'] == "Yes"){ ?>-webby<?php } ?>.gif" /></p>
			</div>
		</div>
	</div>
</div>
<!-- Page javascript -->
<script type="text/javascript">
	var tagid = <?php echo $tag->tagid; ?>;
</script>
