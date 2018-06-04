<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-md-offset-4">
			<h1 class="text-center"><?php echo lang('reset_password_heading');?></h1>
			<div class="account-wall">
				<div id="infoMessage"><?php echo $message;?></div>
				<?php echo form_open('auth/reset_password/' . $code, 'class="form-signin"');?>
					<div class="form-group">
						<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label>
						<?php echo form_input($new_password, '', 'placeholder="Enter new password here" class="form-control" required autofocus');?>
					</div>
					<div class="form-group">
						<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
						<?php echo form_input($new_password_confirm, '', 'placeholder="Enter new password again here" class="form-control" required autofocus');?>
					</div>
					<?php echo form_input($user_id);?>
					<?php echo form_hidden($csrf); ?>
					<p><?php echo form_submit('submit', lang('reset_password_submit_btn'), 'class="btn btn-lg btn-primary btn-block"');?></p>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>
