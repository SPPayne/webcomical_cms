<?php if(isset($page)){ ?>
	<?php if($page && isset($page->filename)){ ?>
		<div class="center-block" id="the-comic-wrapper">
			<?php $filename = base_url() . 'assets/pages/' . $page->filename; ?>
			<?php if(pathinfo($filename,PATHINFO_EXTENSION) != "swf"){ ?>
				<img id="the-comic" class="center-block img-responsive" title="<?php echo $page->title_text; ?>" alt="<?php echo $page->name; ?>" src="<?php echo $filename; ?>" />
			<?php } else { //Handle antiquated Flash files because apparently sometimes people still use them...? ?>
				<?php
					//Grab the attributes with getimagesize() because PHP is fecking amazing
					list($width, $height, $type, $attr) = getimagesize('.' . $filename);
				?>
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" <?php echo $attr; ?> id="mymoviename"> 
					<param name="movie" value="<?php echo $filename; ?>" /> 
					<param name="quality" value="high" /> 
					<param name="bgcolor" value="#000000" />
					<param name="scale" value="exactfit" />
					<embed src="<?php echo $filename; ?>" quality="high" <?php echo $attr; ?> bgcolor="#000000" name="mymoviename" align="" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed> 
				</object>
			<?php } ?>
		</div>
	<?php } else { ?>
		<p>Page appears to be missing... :'(</p>
	<?php } ?>
<?php } ?>