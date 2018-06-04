	<?php if(!stristr($this->uri->uri_string(),'login')){ //Not on login... ?>
			</div><!-- End main column -->
		</div><!-- End row -->
	<?php } ?>
	<?php if(isset($js)){ ?>
		<script type="text/javascript">
			<?php echo $js; ?>
		</script>
	<?php } ?>
</body>
</html>
