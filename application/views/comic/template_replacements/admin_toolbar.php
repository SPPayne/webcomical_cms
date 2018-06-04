<?php if($this->ion_auth->logged_in()){ ?>
	<?php $this->load->view('admin/shared/admin_toolbar'); ?>
<?php } ?>