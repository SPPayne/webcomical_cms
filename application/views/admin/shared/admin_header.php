<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Page title -->
	<title><?php if(isset($title)){ echo $title; ?> | <?php } echo $this->config->item('app_name','webcomic'); ?> Admin Panel</title>
	
	<!-- Meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<!-- Latest jQuery -->
	<script type="text/javascript" src="<?php echo $assets['jquery']; ?>"></script>
	
	<!-- Bootstrap -->
	<link href="<?php echo $assets['bootstrap_css']; ?>" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo $assets['bootstrap_js']; ?>"></script>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<!-- Form validation -->
	<script type="text/javascript" src="<?php echo $assets['form_validation']; ?>"></script>
	
	<?php if(isset($datepicker) && $datepicker == TRUE){ //Load datepicker ?>
		<!-- Bootstrap Datepicker -->
		<link href="<?php echo $assets['datepicker_css']; ?>" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo $assets['datepicker_js']; ?>"></script>
	<?php } ?>
	
	<?php if(isset($ckeditor) && $ckeditor == TRUE){ //Load GUI editor ?>
		<!-- CKEditor -->
		<script type="text/javascript" src="<?php echo $assets['ckeditor']; ?>"></script>
	<?php } ?>
	
	<?php if(!empty($assets['js'])){ ?>
		<!-- Misc js -->
		<?php foreach($assets['js'] as $js){ ?>
			<script type="text/javascript" src="<?php echo $js; ?>"></script>
		<?php } ?>
	<?php } ?>
	
	<?php if(!empty($assets['css'])){ ?>
		<!-- Misc css -->
		<?php foreach($assets['css'] as $css){ ?>
			<link href="<?php echo $css; ?>" rel="stylesheet" />
		<?php } ?>
	<?php } ?>
	
	<!-- Admin Styles -->
	<link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" />
	
	<?php if(isset($settings)){ ?>
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/icons/favicon<?php if($settings['site_webby'] == "Yes"){ ?>_webby<?php } ?>.ico" type="image/x-icon" />
	<?php } ?>
	
</head>
<body>
	<noscript class="center-block text-center">
		<h1 class="text-danger">JavaScript has been disabled!</h1>
		<p>Apologies, but this application requires JavaScript in order to work properly.</p>
		<p>Please re-enable JavaScript on your browser and refresh the page.</p>
		<style type="text/css">
			#sidebar,#main{
				display:none;
			}
		</style>
	</noscript>
	<?php if(!stristr($this->uri->uri_string(),'auth') && !isset($install)){ //Not on login or install... ?>
		<?php $this->load->view('admin/shared/admin_modal'); //General purpose modal ?>
		<div class="row row-offcanvas row-offcanvas-left <?php if($user->admin_sidebar == "CLOSED"){ ?>active<?php } ?>">
			<?php $this->load->view('admin/shared/admin_sidebar'); ?>
			<div class="column col-sm-10 col-xs-11" id="main">
	<?php } ?>
