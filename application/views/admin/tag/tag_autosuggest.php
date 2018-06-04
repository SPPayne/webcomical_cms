<?php if($matches){ ?>
	<div id="tag_autosuggest" class="autosuggest">
		<?php foreach($matches as $match){ ?>
			<span class="tag_suggestion"><?php echo $match->label; ?></span>
		<?php } ?>
	</div>
<?php } ?>
