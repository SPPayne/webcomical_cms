<?php $assets = $this->config->item('assets','webcomic'); //Load assets ?>
	
<!-- Latest jQuery -->
<script type="text/javascript" src="<?php echo $assets['jquery']; ?>"></script>

<!-- Bootstrap -->
<link href="<?php echo $assets['bootstrap_css']; ?>" rel="stylesheet" />
<script src="<?php echo $assets['bootstrap_js']; ?>"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Mobile swiping -->
<script src="<?php echo $assets['mobile']; ?>"></script>

<!-- WebComical Oddities -->
<script src="<?php echo $assets['webcomical']; ?>"></script>

<!-- Default comic CSS -->
<link href="<?php echo base_url(); ?>assets/css/comic.css" rel="stylesheet" />

<?php if($site['site_theme'] != "default"){ ?>
	<!-- Theme custom CSS -->
	<link href="<?php echo base_url(); ?>assets/templates/<?php echo $site['site_theme']; ?>/style.css" rel="stylesheet" />
<?php } ?>

<!-- JS needs to know what the website URL is -->
<script type="text/javascript">
	var base_url = "<?php echo base_url(); ?>";
</script>