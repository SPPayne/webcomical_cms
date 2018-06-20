<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<?php if(isset($meta) && !empty($meta)){ ?>
	<!-- Social Media meta tags -->
	<?php if(isset($meta['title'])){ ?><meta property="og:title" content="<?php echo $meta['title']; ?>" /><?php } ?>
	<?php if(isset($meta['description'])){ ?><meta property="og:description" content="<?php echo $meta['description']; ?>" /><?php } ?>
	<?php if(isset($meta['image'])){ ?><meta property="og:image" content="<?php echo $meta['image']; ?>" /><?php } ?>
	<?php if(isset($meta['url'])){ ?><meta property="og:url" content="<?php echo $meta['url']; ?>" /><?php } ?>
	<meta name="twitter:card" content="summary_large_image" />
<?php } ?>