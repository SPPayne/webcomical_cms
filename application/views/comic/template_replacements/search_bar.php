<form id="search-box" role="search" method="POST" action="/search">
	<div class="input-group">
		<input type="text" name="comic_search" class="form-control" placeholder="Search" <?php if($this->input->post('comic_search')){ ?>value="<?php echo $this->input->post('comic_search'); ?>"<?php } ?> />
		<div class="input-group-btn">
			<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
		</div>
	</div>
</form>
