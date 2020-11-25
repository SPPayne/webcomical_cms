<?php if(!$banners){ ?>
	<p><b>No banners have been generated yet.</b> However, you can add one using the file upload box above!</p>
<?php } else { ?>
	<div class="table-responsive">
		<table id="banners-table" class="table table-striped table-bordered">
			<tr>
				<th>Banner URL</th>
				<th>Preview</th>
				<th>Show on Website?</th>
				<th>Actions</th>
			</tr>
			<?php foreach($banners as $banner){ ?>
				<tr>
					<td class="vertical-align">
						<a href="<?php echo base_url(); ?>assets/banners/<?php echo $banner->filename; ?>" target="_blank">
							<?php echo $banner->filename; ?> <span class="glyphicon glyphicon-new-window"></span>
						</a>
					</td>
					<td class="text-center vertical-align">
						<img class="img-responsive" height="100" src="<?php echo base_url(); ?>assets/banners/<?php echo $banner->filename; ?>" />
					</td>
					<td class="text-center vertical-align">
						<input class="banner-toggle" id="<?php echo $banner->id; ?>" type="checkbox" data-on="Yes" data-off="No" <?php if($banner->banner_active == "Y"){ ?>checked<?php } ?> data-toggle="toggle" />
					</td>
					<td class="text-center vertical-align">
						<a title="Delete banner" class="delete-button" href="<?php echo base_url(); ?>admin/delete_banner/<?php echo $banner->id; ?>"><span class="glyphicon glyphicon-trash"></span></a>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
<?php } ?>
