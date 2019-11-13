<h1>Webcomic Banners</h1>
<p>Webcomic banners are the header image that shows as the title of the comic.</p>
<p>You can upload or delete webcomic banners using this panel, or mark which banners you do not want showing on the website.</p>
<p>If there are multiple banners set to show, the site will randomise which banner is shown every time the website loads.</p>
<p>If no banners are available, the website will show the comic's title in plain text.</p>
<p>Max file size: <?php echo ($upload_rules['banners']['max_size']/1000); ?>MB. Max dimensions: <?php echo $upload_rules['banners']['max_width']; ?>px x <?php echo $upload_rules['banners']['max_height']; ?>px. File types allowed: .<?php echo implode(' .',explode('|',$upload_rules['banners']['allowed_types'])); ?></p>
<label>Upload banner:</label>
<?php
	//File upload button hacked into shape in separate file
	//Ref: http://www.abeautifulsite.net/whipping-file-inputs-into-shape-with-bootstrap-3/
	$this->load->view('/admin/shared/admin_file_upload');
?>
<hr />
<div id="update_response" class="hidden"></div>
<div id="all_banners"></div>

<!-- Deletion confirm dialogue -->
<div id="deletion" class="modal fade" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3>Are you sure you want to delete this banner?</h3>
			</div>
			<div class="modal-body">
				<p>Deleting this banner will completely remove it from the system!</p>
				<p>Are you sure you want to proceed?</p>
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm_deletion" class="btn btn-default">Yes!</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
