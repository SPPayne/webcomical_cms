<?php if(isset($character)){ ?>
	<?php if($character->filename){ ?>
		<p class="profile-img-wrap"><img class="profile-img pull-right" title="<?php echo $character->name; ?>" alt="<?php echo $character->name; ?>" src="/assets/characters/<?php echo $character->filename; ?>" /></p>
	<?php } ?>
	<?php echo $character->notes; ?>
	<p><a href="/character_appearances/<?php echo $character->slug; ?>">View all of this character's appearances in the comic</a></p>
<?php } ?>
