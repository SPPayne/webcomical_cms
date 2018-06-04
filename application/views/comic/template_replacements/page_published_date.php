<?php if(isset($page)){ ?>
	<?php echo $site['site_page_term']; ?> published on <?php echo date($site['site_date_format'],$page->published); ?>.
<?php } ?>