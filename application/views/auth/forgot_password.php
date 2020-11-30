<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-md-offset-4">
			<h1 class="text-center">Forgot Your Password?</h1>
			<div class="account-wall">
				<p>Please enter your username or email address so that; the app will then send you an email to reset your password.</p>
				<?php if($message){ ?>
					<?php if(stristr($message,'error')){ $message_tone = "danger"; } else { $message_tone = "success"; } ?>
					<div id="infoMessage" class="bg-<?php echo $message_tone; ?>"><?php echo $message;?></div>
				<?php } ?>
				<?php echo form_open("auth/forgot_password", 'class="form-signin"');?>
					<div class="form-group">
						<label for="identity">Username or Email Address</label>
						<?php echo form_input($identity, '', 'placeholder="Enter username or email" class="form-control" required autofocus');?>
					</div>
					<div class="form-group">
						<?php echo form_submit('submit', lang('forgot_password_submit_btn'), 'class="btn btn-lg btn-primary btn-block"');?>
					</div>
				<?php echo form_close();?>
				<p><a href="<?php echo base_url(); ?>auth">Back to login page</a></p>
			</div>
		</div>
	</div>
</div>
