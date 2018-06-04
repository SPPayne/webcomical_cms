<?php if(isset($nav)){ ?>
	<?php if(!isset($nav_place)){ $nav_place = "bottom"; } ?>
	<?php if($this->uri->segment(2) && $nav['last_page']){ //Not on homepage (that would be pointless!) ?>
		<div id="response_bookmark_save_<?php echo $nav_place; ?>" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="text-center"></h3>
					</div>
					<div class="modal-body">
						<p class="bookmark-response"></p>
					</div>
				</div>
			</div>
		</div>
		<button class="btn btn-default btn-block" id="bookmark_save_<?php echo $nav_place; ?>">Save my place! Bookmark this page!</button>
	<?php } ?>
	<?php if($this->session->userdata('bookmark')){ //Existing bookmark ?>
		<button class="btn btn-default btn-block" id="bookmark_load_<?php echo $nav_place; ?>">Load my last bookmark!</button>
	<?php } ?>
<?php } ?>