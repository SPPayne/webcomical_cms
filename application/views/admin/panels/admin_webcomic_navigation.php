<h1>Webcomic Navigation</h1>
<hr />
<h2>Navigation Bar Options</h2>
<p>Here you can configure what additional navigation you want to present to the reader and which bars you want these options to appear on. "Top" and "bottom" refer to above and below the comic image.</p>
<p>This page assumes that you are using two navigation bars! The default bar is "bottom".</p>
<div id="update_response" class="hidden"></div>
<form id="update_nav" role="form" method="POST">
	<div class="table-responsive">
		<table id="banners-table" class="table table-striped table-bordered">
			<tr>
				<th>Option</th>
				<th>Show on which nav bar?</th>
			</tr>
			<?php foreach($navigation['options'] as $option => $values){ ?>
				<tr>
					<td class="vertical-align">
						<?php echo $values['label']; ?>
					</td>
					<td class="text-center vertical-align">
						<?php foreach($navigation['placements'] as $placement){ ?>
							<label class="radio-inline">
								<input 
									type="radio" 
									name="nav_<?php echo $option; ?>" 
									value="<?php echo $placement; ?>" 
									<?php if($placement == $nav_settings['nav_'.$option]){ ?>
										checked="checked"
									<?php } ?>
								/>
								<?php echo ucfirst($placement); ?>
							</label>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
	<div class="form-group">
		<input id="submit_update" type="submit" class="btn btn-default center-block" value="Update" />
	</div>
	<hr />
	<h2>Navigation Button Appearance</h2>
	<p>Max file size: <?php echo ($upload_rules['navigation_buttons']['max_size']/1000); ?>MB. Expected dimensions: <?php echo $upload_rules['navigation_buttons']['max_width']; ?>px x <?php echo $upload_rules['navigation_buttons']['max_height']; ?>px. File types allowed: .<?php echo implode(' .',explode('|',$upload_rules['navigation_buttons']['allowed_types'])); ?></p>
	<label>Upload a "sprite sheet" of buttons:</label>
	<?php
		//File upload button hacked into shape in separate file
		//Ref: http://www.abeautifulsite.net/whipping-file-inputs-into-shape-with-bootstrap-3/
		$this->load->view('/admin/shared/admin_file_upload');
	?>
	<?php if($nav_buttons){ ?>
		<p><a target="_blank" href="<?php echo base_url(); ?>assets/custom/navigation_buttons.png">View current custom buttons</a></p>
	<?php } ?>
	<p>The navigation buttons are responsive based on device size. Buttons are generated from one single "sprite sheet". You can cutomise them using the template below - just right-click and "save as".</p>
	<p>Once customised, upload your sprite sheet using the upload button above. Your sprite sheet <em>must</em> match the dimensions of the template image below (although you can make the buttons smaller, use transparency, etc.!).</p>
	<p class="text-center"><img src="<?php echo base_url(); ?>assets/icons/buttons_template.png" alt="Buttons template image" title="This is the buttons template! Please do create your own sheet of buttons, this one is hideous." /></p>
</form>