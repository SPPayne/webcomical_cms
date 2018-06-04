<?php if(isset($site['site_comments']) && !empty($site['site_comments'])){ ?>
	<div id="disqus_thread"></div>
	<script>
		var disqus_config = function(){
			this.page.url 			= '<?php echo base_url(uri_string()); ?>';
			this.page.identifier 	= '<?php echo $page->comicid; ?>';
		};
		(function(){
			var d = document, s = d.createElement('script');
			s.src = '//<?php echo $site['site_comments']; ?>.disqus.com/embed.js';
			s.setAttribute('data-timestamp', +new Date());
			(d.head || d.body).appendChild(s);
		})();
	</script>
<?php } ?>
