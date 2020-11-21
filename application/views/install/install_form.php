<script type="text/javascript">
	$(document).ready(function(){
			
		//Submit form
		$('#install_form').validator().on('submit');
		
	});
</script>
<?php if(isset($errors)){ ?>
	<?php echo $errors; ?>
<?php } ?>
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-md-offset-4">
			<div class="account-wall">
				<img style="max-width:50%" class="center-block img-responsive" alt="Webby the Clown Spider" title="It's Webby the terrifying and slightly annoying webcomic mascot! He's the website mascot so unsettling that he even gives Clippy nightmares!" src="./assets/icons/webcomical.png" />
				<h1 class="text-center">Install WebComical</h1>
				<form class="form-signin" id="install_form" role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div class="form-group has-feedback">
						<label for="url">Website URL</label>
						<input maxlength="100" pattern="(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})" data-error="Not a valid URL!" type="text" id="url" class="form-control" name="url" value="<?php if($this->input->post('url')){ echo $this->input->post('url'); } ?>" placeholder="e.g. http://www.mywebcomic.com" required />
						<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors">This needs to be the full web address of the webcomic including "http://" (or "https://")</div>
					</div>
					<?php
						//Ref: https://stackoverflow.com/questions/31309536/how-to-set-time-zone-in-codeigniter
						$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
						if(!$this->input->post('timezone')){
							$_POST['timezone'] = "UTC"; //"Hack" to set default
						}
					?>
					<div class="form-group has-feedback">
						<label for="timezone">Timezone</label>
						<select class="form-control" id="timezone" name="timezone" required>
							<?php foreach($timezones as $timezone){ ?>
								<option value="<?php echo $timezone; ?>" <?php if($this->input->post('timezone') && $this->input->post('timezone') == $timezone){ ?>selected="selected"<?php } ?>>
									<?php echo $timezone; ?>
								</option>
							<?php } ?>
						</select>
						<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors">Set your preferred timezone for this webcomic - this is for publishing purposes</div>
					</div>
					<div class="form-group has-feedback">
						<label for="hostname">Hostname</label>
						<input maxlength="100" pattern="^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$" data-error="Not a valid hostname!" type="text" id="hostname" class="form-control" name="hostname" value="<?php if($this->input->post('hostname')){ echo $this->input->post('hostname'); } ?>" placeholder="e.g. localhost" required />
						<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors">This will either be "localhost" or an ip address</div>
					</div>
					<div class="form-group has-feedback">
						<label for="username">Database Username</label>
						<input maxlength="32" type="text" id="username" class="form-control" name="username" value="<?php if($this->input->post('username')){ echo $this->input->post('username'); } ?>" placeholder="Your MySQL username" required />
						<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors">The username you use to connect to the database</div>
					</div>
					<div class="form-group has-feedback">
						<label for="password">Database Password</label>
						<input maxlength="100" type="password" id="password" class="form-control" name="password" value="<?php if($this->input->post('password')){ echo $this->input->post('password'); } ?>" placeholder="Your MySQL password" />
						<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors">The password you use to connect to the database</div>
					</div>
					<div class="form-group">
						<label for="database">Database Name</label>
						<input maxlength="50" pattern="^[A-z0-9_]{1,}$" data-error="Letters, numbers and underscores only" type="text" id="database" class="form-control" name="database" value="<?php if($this->input->post('database')){ echo $this->input->post('database'); } ?>" placeholder="The database you want to install to" required />
						<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors">The name you want to give the database you wish to install your webcomic into (can be an existing database name!)</div>
					</div>
					<hr />
					<strong>The following values are to create a user account you can log into the admin panel with.</strong>
					<hr />
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
								value="<?php if($this->input->post("usr_" . $fieldname)){ echo $this->input->post("usr_" . $fieldname); } ?>" 
								data-error="Not a valid <?php echo strtolower($fieldname); ?>!" 
								autocomplete="off" 
								required 
								placeholder="<?php echo $uservalues['placeholder']; ?>"
							/>
							<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							<div class="help-block with-errors"><?php echo $uservalues['guide']; ?></div>
						</div>
					<?php } ?>
					<div class="form-group has-feedback">
						<label for="usr_password_confirm">Confirm Password:</label>
						<input
							data-minlength="8" 
							maxlength="20"
							type="password" 
							class="form-control" 
							id="usr_password_confirm" 
							name="usr_password_confirm" 
							value="<?php if($this->input->post("usr_password_confirm")){ echo $this->input->post("usr_password_confirm"); } ?>" 
							autocomplete="off" 
							required 
							data-match="#usr_password"
							data-match-error="Passwords do not match!"
							placeholder="Re-type your password here"
						/>
						<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<div class="help-block with-errors">Confirm your selected password by re-typing it here</div>
					</div>
					<div class="form-group">
						<input class="btn btn-lg btn-primary btn-block" type="submit" value="Install" id="submit" />
					</div>
				</form>
			</div>
		</div>