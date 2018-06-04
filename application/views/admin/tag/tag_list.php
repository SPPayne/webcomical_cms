<h1>Manage Tags</h1>
<p>Manage or delete tags below. <a href="/admin/create_tag/">Click here to create a new one!</a></p>
<?php if(!$tags){ ?>
	<p>No tags have been created yet. However, you can <a href="/admin/create_tag/">click here to add your first tag!</a></p>
<?php } else { ?>
	<div id="update_response" class="hidden"></div>
	<div class="table-responsive">
		<table id="tags-table" class="table table-striped table-bordered">
			<tr>
				<th>Tag</th>
				<th>Tag Slug</th>
				<th>No. of Pages Tagged</th>
				<th>Date Created</th>
				<th>Actions</th>
			</tr>
			<?php foreach($tags as $tag){ ?>
				<tr>
					<td>
						<a href="/tags/<?php echo $tag->slug; ?>" target="_blank">
							<?php echo $tag->label; ?> <span class="glyphicon glyphicon-new-window"></span>
						</a>
					</td>
					<td><?php echo $tag->slug; ?></td>
					<td><?php echo $tag->usage; ?></td>
					<td><?php echo date($settings['site_date_format'].' h:i A',strtotime($tag->added)); ?></td>
					<td class="text-center">
						<a title="Edit tag" href="/admin/create_tag/<?php echo $tag->tagid; ?>"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
						<a title="Convert to character" class="convert-button" href="/admin/convert_tag_to_character/<?php echo $tag->tagid; ?>"><span class="glyphicon glyphicon-user"></span></a>&nbsp;&nbsp;
						<a title="Delete tag" class="delete-button" href="/admin/delete_tag/<?php echo $tag->tagid; ?>"><span class="glyphicon glyphicon-trash"></span></a>
					</td>
				</tr>
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
				<h3>Are you sure you want to delete this tag?</h3>
			</div>
			<div class="modal-body">
				<p>Deleting this tag will completely remove it from the system!</p>
				<p>Are you sure you want to proceed?</p>
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm_deletion" class="btn btn-default">Yes!</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Conversion confirm dialogue -->
<div id="conversion" class="modal fade" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3>Are you sure you want to convert this tag into a character?</h3>
			</div>
			<div class="modal-body">
				<p>Converting this tag will turn it into a full character that you can attach profile information to. You will <b>not</b> be able to convert it back into a tag!</p>
				<p>Are you sure you want to proceed?</p>
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm_conversion" class="btn btn-default">Yes!</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
