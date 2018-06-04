<h1>Webcomic Appearance</h1>
<p>Select a comic template here. You can create custom templates in the <code>/assets/templates</code> folder.</p>
<div id="update_response" class="hidden"></div>
<?php if($current_template){ ?>
	<p>
		<b>Current template:</b> 
		<span id="current-default" <?php if(strtolower($current_template) != "default"){ ?>class="hidden"<?php } ?>><?php echo $this->config->item('app_name','webcomic'); ?> Default (<span class="text-danger">no template selected!</span>)</span>
		<span id="current-selected" <?php if(strtolower($current_template) == "default"){ ?>class="hidden"<?php } ?>><code>/assets/templates/<span id="current-path"><?php echo $current_template; ?></span></code></span>
	</p>
	<hr />
<?php } ?>
<?php if($themes){ ?>
	<?php if(isset($themes['invalid'])){ ?>
		<div class="round-box bg-danger text-danger">
			<p><strong>Broken Templates:</strong></p>
			<ul>
				<?php foreach($themes['invalid'] as $folder => $template){ ?>
					<li><b><?php echo $folder; ?>:</b> <?php echo $template; ?></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
	<?php if(isset($themes['valid'])){ ?>
		<p><strong>Templates:</strong></p>
		<div class="row templates">
			<?php $cnt = 1; foreach($themes['valid'] as $folder => $template){ ?>
				<div id="<?php echo $folder; ?>" class="col-xs-12 col-md-3 text-center round-box <?php if($folder == $current_template){ ?>bg-primary<?php } else { ?>theme<?php } ?>">
					<p><b><?php echo $template['name']; ?></b></p>
					<p><img style="border:1px solid #000; width:100px;" src="<?php echo $template['preview']; ?>" /></p>
					<p><?php echo $template['description']; ?></p>
				</div>
				<?php if($cnt % 3 == 0){ ?>
					</div>
					<div class="row templates">
				<?php } ?>
			<?php $cnt++; } ?>
		</div>
	<?php } else { ?>
		<p class="text-danger">No valid templates found.</p>
	<?php } ?>
<?php } else { ?>
	<p class="text-danger">No templates found.</p>
<?php } ?>
