<h1>Create New User</h1>
<div id="update_response" class="hidden"></div>
<form id="update_user" role="form" method="POST" data-toggle="validator">
	<?php foreach($fields as $fieldname => $uservalues){ ?>
		<div class="form-group has-feedback">
			<label for="usr_<?php echo $fieldname; ?>"><?php echo $uservalues['label']; ?>:</label>
			<input
				data-minlength="<?php echo $uservalues['minlength']; ?>" 
				<?php if(isset($uservalues['pattern'])){ ?>
					pattern="<?php echo $uservalues['pattern']; ?>"
				<?php } ?> 
				<?php if(isset($uservalues['maxlength'])){ ?>
					maxlength="<?php echo $uservalues['maxlength']; ?>"
				<?php } ?> 
				type="<?php echo $uservalues['type']; ?>" 
				class="form-control" 
				id="usr_<?php echo $fieldname; ?>" 
				name="usr_<?php echo $fieldname; ?>" 
				value="" 
				data-error="Not a valid <?php echo strtolower($fieldname); ?>!" 
				autocomplete="off" 
				required 
			/>
			<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
			<div class="help-block with-errors"><?php echo $uservalues['guide']; ?></div>
		</div>
	<?php } ?>
	<div class="form-group">
		<input id="submit_update" type="submit" class="btn btn-default center-block" value="Create" />
	</div>
</form>
<!-- Success dialogue -->
<div id="success" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>User created successfully...</h3>
			</div>
			<div class="modal-body">
				<p class="text-center">Now redirecting to management screen!</p>
				<p class="text-center"><img src="<?php echo base_url(); ?>assets/icons/loading<?php if($settings['site_webby'] == "Yes"){ ?>-webby<?php } ?>.gif" /></p>
			</div>
		</div>
	</div>
</div>
