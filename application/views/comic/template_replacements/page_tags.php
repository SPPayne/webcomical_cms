<?php if(isset($tags)){ ?>
	<?php if($tags){ ?>
		<b>Tagged:</b>
		<?php $last_tag = end($tags); ?>
		<?php foreach($tags as $label => $tag){ ?>
			<?php if($tag['type'] == "tag"){ ?>
				<a href="/tags/<?php echo $tag['slug']; ?>"><?php echo $label; ?></a><?php if($tag['slug'] != $last_tag['slug']){ echo ", "; } ?>
			<?php } else { ?>
				<a href="/character_profiles/<?php echo $tag['slug']; ?>"><?php echo $label; ?></a><?php if($tag['slug'] != $last_tag['slug']){ echo ", "; } ?>
			<?php } ?>
		<?php } ?>
	<?php } ?>
<?php } ?>
