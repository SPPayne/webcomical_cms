<h1>Manage Characters</h1>
<p>Manage or delete characters below.</p>
<?php if(!$characters){ ?>
	<p>You haven't created any characters yet! <a href="/admin/create_character/">Click here to create your first character bio</a>.</p>
<?php } else { ?>
	<div id="update_response" class="hidden"></div>
	<div class="table-responsive">
		<table id="characters-table" class="table table-striped table-bordered">
			<tr>
				<th>Character Name</th>
				<th>Tag / Slug</th>
				<th>Display</th>
				<th>Profile Image</th>
				<th>Actions</th>
			</tr>
			<?php foreach($characters as $character){ ?>
				<tr>
					<td>
						<a href="/character_profiles/<?php echo $character->slug; ?>" target="_blank">
							<?php echo $character->name; ?> <span class="glyphicon glyphicon-new-window"></span>
						</a>
					</td>
					<td><?php echo $character->slug; ?></td>
					<?php if($character->profile_active == "Y"){ ?>
						<td class="bg-success">Showing in profile section.</td>
					<?php } else { ?>
						<td class="bg-danger">Set to not display in profile section.</td>
					<?php } ?>
					<?php if($character->filename == NULL){ ?>
						<td class="danger">No file found, no profile image will be shown.</td>
					<?php } else { ?>
						<td><a href="/assets/characters/<?php echo $character->filename; ?>" target="_blank"><?php echo $character->filename; ?></a></td>
					<?php } ?>
					<td class="text-center">
						<a title="Move character up" class="charactermove-up" href="/admin/move_character/<?php echo $character->characterid; ?>/up"><span class="glyphicon glyphicon-arrow-up"></span></a>&nbsp;&nbsp;
						<a title="Move character down" class="charactermove-down" href="/admin/move_character/<?php echo $character->characterid; ?>/down"><span class="glyphicon glyphicon-arrow-down"></span></a>&nbsp;&nbsp;
						<a title="Edit character" href="/admin/create_character/<?php echo $character->characterid; ?>"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
						<a title="Delete character" class="delete-button" href="/admin/delete_character/<?php echo $character->characterid; ?>"><span class="glyphicon glyphicon-trash"></span></a>
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
				<h3>Are you sure you want to delete this character?</h3>
			</div>
			<div class="modal-body">
				<p>Deleting this character will completely remove it from the system!</p>
				<p>Are you sure you want to proceed?</p>
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm_deletion" class="btn btn-default">Yes!</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
