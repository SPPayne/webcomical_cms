<h1>Webcomic Favicon</h1>
<p>A "favicon" or "favourites icon" is a small image designed to represent your website - it normally shows on a tab in front of the page title and can help users identify bookmarks or tabs related to your webcomic.</p>
<p>Favicons can be saved in .ico or .png format and there are a number of "favicon generator" websites that can aid you in creating a favicon.</p>
<p>You can upload your favicon using the upload bar below.</p>
<p>Max file size: 1MB. Max dimensions: 32px x 32px (recommended size is 16px x 16px). File types allowed: .ico .png</p>
<label>Upload favicon:</label>
<?php
	//File upload button hacked into shape in separate file
	//Ref: http://www.abeautifulsite.net/whipping-file-inputs-into-shape-with-bootstrap-3/
	$this->load->view('/admin/shared/admin_file_upload');
?>
<?php if($favicon){ ?>
	<p><a target="_blank" href="<?php echo base_url() . $favicon; ?>">View current custom favicon</a></p>
<?php } ?>
<div id="update_response" class="hidden"></div>