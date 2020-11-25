<h1>Manage Redirects</h1>
<p>Manage or delete redirects below. Redirects are created whenever a web address changes for a comic page or a character page, so any bookmarks will automatically redirect to the new web address. Redirects are also very important for search engines trying to index your comic so they can figure out where a page has moved to!</p>
<?php if(!$redirects){ ?>
	<p>No redirects have been generated yet. However, you can <a href="<?php echo base_url(); ?>admin/create_redirect/">click here to manually add a redirect!</a></p>
<?php } else { ?>
	<p>You can also <a href="<?php echo base_url(); ?>admin/create_redirect/">manually add redirects</a> to your webcomic too.</p>
	<div id="update_response" class="hidden"></div>
	<div class="table-responsive">
		<table id="redirects-table" class="table table-striped table-bordered">
			<tr>
				<th>Original URL Slug</th>
				<th>New URL Slug</th>
				<th>Date Modified</th>
				<th>Actions</th>
			</tr>
			<?php foreach($redirects as $type => $redirects){ ?>
				<tr>
					<th colspan="4">
						<?php echo ucfirst($type); ?> Redirects
					</th>
				</tr>
				<?php foreach($redirects as $redirect){ ?>
					<tr>
						<td><?php echo $redirect->url; ?></td>
						<td><?php echo $redirect->redirect; ?></td>
						<td><?php echo date($settings['site_date_format'].' h:i A',strtotime($redirect->modified)); ?></td>
						<td class="text-center">
							<a title="Delete redirect" class="delete-button" href="<?php echo base_url(); ?>admin/delete_redirect/<?php echo $redirect->id; ?>"><span class="glyphicon glyphicon-trash"></span></a>
						</td>
					</tr>
				<?php } ?>
			<?php } ?>
		</table>
	</div>
<?php } ?>

<!-- Deletion confirm dialogue -->
<div id="deletion" class="modal fade" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3>Are you sure you want to delete this redirect?</h3>
			</div>
			<div class="modal-body">
				<p>Deleting this redirect will completely remove it from the system!</p>
				<p>Are you sure you want to proceed?</p>
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm_deletion" class="btn btn-default">Yes!</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
