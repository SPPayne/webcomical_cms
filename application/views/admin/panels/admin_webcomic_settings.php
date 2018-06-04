<h1>Your Webcomic Settings</h1>
<p>Modify default webcomic settings here!</p>
<div id="update_response" class="hidden"></div>
<form id="update_comic" role="form" method="POST">
	<div class="row">
		<?php $cnt = 0; ?>
		<?php foreach($fields as $fieldname => $values){ ?>
			<?php if($cnt % 2 == 0){ ?>
				</div>
				<div class="row">
			<?php } ?>
			<?php
				switch($values['type']){ 
					default:
					?>
						<div class="col-xs-12 col-md-6 form-group has-feedback">
							<label for="ste_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label>
							<input
								data-minlength="<?php echo $values['minlength']; ?>" 
								<?php if(isset($values['pattern'])){ ?>
									pattern="<?php echo $values['pattern']; ?>"
								<?php } ?> 
								<?php if(isset($values['maxlength'])){ ?>
									maxlength="<?php echo $values['maxlength']; ?>"
								<?php } ?> 
								type="<?php echo $values['type']; ?>" 
								class="form-control" 
								id="ste_<?php echo $fieldname; ?>" 
								name="ste_<?php echo $fieldname; ?>" 
								value="<?php if(isset($settings[$values['db_field']])){ echo $settings[$values['db_field']]; } ?>" 
								data-error="Not a valid '<?php echo strtolower(str_ireplace('_',' ',$fieldname)); ?>' value!" 
								autocomplete="off" 
								<?php if($values['required'] == TRUE){ ?>
									required 
								<?php } ?>
								<?php if($values['readonly'] == TRUE){ ?>
									readonly disabled
								<?php } ?>
							/>
							<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							<div class="help-block with-errors"><?php echo $values['guide']; ?></div>
						</div>
					<?php 
						break;
						case "dropdown":
					?>
						<div class="col-xs-12 col-md-6 form-group has-feedback">
							<label for="ste_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label><br />
							<select
								type="<?php echo $values['type']; ?>" 
								class="form-control" 
								id="ste_<?php echo $fieldname; ?>" 
								name="ste_<?php echo $fieldname; ?>" 
								<?php if($values['required'] == TRUE){ ?>
									required 
								<?php } ?>
								<?php if($values['readonly'] == TRUE){ ?>
									readonly disabled
								<?php } ?> 
							>
								<?php if(isset($values['options']) && !empty($values['options'])){ ?>
									<?php foreach($values['options'] as $option){ ?>
										<option value="<?php echo $option; ?>" <?php if(isset($settings[$values['db_field']]) && $settings[$values['db_field']] == $option){ ?>selected="selected"<?php } ?>>
											<?php echo $option; ?>
										</option>
									<?php } ?>
								<?php } ?>
							</select>
							<div class="help-block"><?php echo $values['guide']; ?></div>
						</div>
					<?php
						break;
						case "checkbox":
					?>
						<div class="col-xs-12 col-md-6 form-group has-feedback">	
							<label for="ste_<?php echo $fieldname; ?>"><?php echo $values['label']; ?>:</label><br />
							<input
								type="checkbox" 
								<?php if(isset($settings[$values['db_field']]) && $settings[$values['db_field']] == "Yes"){ ?>checked<?php } ?> 
								data-toggle="toggle"
							/>
							<input
								type="hidden" 
								id="ste_<?php echo $fieldname; ?>" 
								name="ste_<?php echo $fieldname; ?>" 
								value="<?php if(isset($settings[$values['db_field']])){ echo $settings[$values['db_field']]; } ?>" 
								<?php if($values['required'] == TRUE){ ?>
									required 
								<?php } ?>
								<?php if($values['readonly'] == TRUE){ ?>
									readonly disabled 
								<?php } ?>
							/>
							<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							<div class="help-block with-errors"><?php echo $values['guide']; ?></div>
						</div>
					<?php
					break;
				}
			?>
		<?php $cnt++; } ?>
	</div>
	<div class="form-group">
		<input id="submit_update" type="submit" class="btn btn-default center-block" value="Update" />
	</div>
</form>
