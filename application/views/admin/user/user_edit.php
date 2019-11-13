<?php if($user_edit == FALSE){ //No current user ?>
	<h1>Manage Users</h1>
	<?php if(isset($users)){ ?>
		<div class="form-group">
			<label for="userlist">Select a user from the list to edit their settings.</label>
			<select name="userlist" id="userlist" class="form-control">
				<option value="">Select...</option>
				<?php foreach($users as $user){ //Output users ?>
					<?php $name = $user->username . " (" . $user->first_name . " " . $user->last_name . ")"; //Form name?>
					<option value="<?php echo $user->id; ?>"><?php echo $name; ?></option>
				<?php } ?>
			</select>
		</div>
	<?php } else { //No users, which shouldn't happen?!? ?>
		<p class="text-danger">Uh-oh, something's wrong! There's nothing to show here...</p>
	<?php } ?>
<?php } else { //Current user selected ?>

	<!-- Deletion confirm dialogue -->
	<div id="deletion" class="modal fade" role="dialog" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3>Are you sure you want to delete this user?</h3>
				</div>
				<div class="modal-body">
					<p>Deleting this user will completely remove them from the system!</p>
					<p>Are you sure you want to proceed?</p>
				</div>
				<div class="modal-footer">
					<button type="button" id="confirm_deletion" class="btn btn-default">Yes!</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Page html -->
	<h1>Manage User <?php echo '"' . $user_edit->username . '" (' . $user_edit->first_name . ' ' . $user_edit->last_name . ')'; ?></h1>
	<div id="update_response" class="hidden"></div>
	<form id="update_user" role="form" method="POST" data-toggle="validator">
		<?php foreach($fields as $fieldname => $uservalues){ ?>
			<?php $uservalue = $uservalues['ion_field']; //PHP7 is not a big fan of using array vals to point to objects so redeclare here ?>
			<div class="form-group has-feedback">
				<label for="usr_<?php echo $fieldname; ?>"><?php echo $uservalues['label']; ?>:</label>
				<?php
					//Field value
					if($uservalues['ion_field'] != FALSE){
						$value = $user_edit->$uservalue;
					} else { 
						$value = $this->input->post($uservalues['ion_field']);
					}
				?>
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
					value="<?php if(isset($value)){ echo $value; } ?>" 
					data-error="Not a valid <?php echo strtolower($fieldname); ?>!" 
					autocomplete="off" 
					<?php if($uservalues['required'] == TRUE){ ?>
						required 
					<?php } ?>
				/>
				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				<div class="help-block with-errors"><?php echo $uservalues['guide']; ?></div>
			</div>
		<?php } ?>
		<?php if($user_edit->id != $current_userid){ //Cannot delete your own account... ?>
			<div class="checkbox">
				<label><input type="checkbox" id="delete_user" name="delete_user" value="Delete">Delete this user's account</label>
			</div>
		<?php } ?>
		<div class="form-group">
			<input id="submit_update" type="submit" class="btn btn-default center-block" value="Update" />
		</div>
	</form>
	
	<!-- Page javascript -->
	<script type="text/javascript">
		var userid = <?php echo $user_edit->id; ?>;
	</script>
	
<?php } ?>
