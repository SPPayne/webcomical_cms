<?php if(!$banners){ ?>
	<?php if(isset($site['site_name'])){ ?><h1><a href="/"><b><?php echo $site['site_name']; ?></b></a></h1><?php } ?>
	<?php if(isset($site['site_slogan'])){ ?><p><?php echo $site['site_slogan']; ?></p><?php } ?>
<?php } else { ?>
	<?php $banner = $banners[array_rand($banners,1)]->filename; ?>
	<a href="/">
		<?php 
			if($this->router->fetch_class() == "comic" && $this->router->fetch_method() == "index"){
				$tag = "h1";
			} else {
				$tag = "h2";
			}
		?>
		<<?php echo $tag; ?>>
			<img class="center-block img-responsive" src="/assets/banners/<?php echo $banner; ?>" title="<?php if(isset($site['site_name'])){ echo $site['site_name']; } ?><?php if(isset($site['site_slogan'])){ echo " - " . $site['site_slogan']; } ?>">
		</<?php echo $tag; ?>>
	</a>
<?php } ?>
