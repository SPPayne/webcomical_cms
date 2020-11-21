<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-md-offset-4">
			<div class="account-wall">
				<?php if($settings['site_webby'] == "Yes"){ ?>
					<img style="max-width:50%" class="center-block img-responsive" alt="Webby the Clown Spider" title="It's Webby the terrifying and slightly annoying webcomic mascot! You can turn him off if you want to!" src="<?php echo base_url(); ?>assets/icons/webcomical.png" />
					<h1 class="text-center">Login</h1>
				<?php } else { ?>
					<h1 class="text-center">Login to <img style="height:25px;" alt="<?php echo $this->config->item('app_name','webcomic'); ?>" title="<?php echo $this->config->item('app_name','webcomic'); ?>" src="<?php echo base_url(); ?>assets/icons/webcomical_txt.png" /> </h1>
				<?php } ?>
				<p><?php echo lang('login_subheading');?></p>
				<?php if($message){ ?>
					<?php if(stristr($message,'error')){ $message_tone = "danger"; } else { $message_tone = "success"; } ?>
					<div id="infoMessage" class="bg-<?php echo $message_tone; ?>"><?php echo $message;?></div>
				<?php } ?>
				<?php echo form_open("auth/login", 'class="form-signin"');?>
				<div class="form-group">
					<?php echo lang('login_identity_label', 'identity');?>
					<?php echo form_input($identity,'','placeholder="Enter username or email address" class="form-control" required autofocus');?>
				</div>
				<div class="form-group">
					<?php echo lang('login_password_label', 'password');?>
					<?php echo form_input($password,'','placeholder="Enter password" class="form-control" required');?>
				</div>
				<div class="checkbox">
					<label>
						<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?> Stay logged in when closing <?php echo $this->config->item('app_name','webcomic'); ?> (for <?php echo floor($this->config->item('user_expire','ion_auth')/3600); ?> hours)
					</label>
				</div>
				<div class="form-group">
					<?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-lg btn-primary btn-block"');?>
				</div>
				<?php echo form_close();?>
				<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
			</div>
		</div>
