<?php if(isset($cast)){ ?>
	<?php if(!$cast){ ?>
		<p>No cast profile pages are currently available.</p>
	<?php } else { ?>
		<?php //print_r($cast); //DEBUG ?>
		<?php if($site['site_character_excerpt'] == "Yes"){ ?>
			<?php foreach($cast as $character){ ?>
				<hr />
				<?php if($character->filename){ ?>
					<a title="<?php echo $character->name; ?>" href="<?php echo base_url(); ?>character_profiles/<?php echo $character->slug; ?>">
						<div class="character-thumbnail" style="background-image:url('<?php echo base_url(); ?>assets/characters/<?php echo $character->filename; ?>')" ></div>
					</a>
				<?php } ?>
				<h2><?php echo $character->name; ?></h2>
				<?php echo $character->excerpt; ?>
				<p><a title="<?php echo $character->name; ?>" href="<?php echo base_url(); ?>character_profiles/<?php echo $character->slug; ?>">Find out more about <?php echo $character->name; ?></a>
				<div class="clearfix">&nbsp;</div>
			<?php } ?>
		<?php } else { //Show generic list of names ?>
			<p>Click one of the names below to see the character's full profile.</p>
			<ul>
				<?php foreach($cast as $character){ ?>
					<li>
						<a title="<?php echo $character->name; ?>" href="<?php echo base_url(); ?>character_profiles/<?php echo $character->slug; ?>"><?php echo $character->name; ?></a>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	<?php } ?>
<?php } ?>