<h1>Manage Comic Chapters</h1>
<p>Create, delete, update and reorganise both chapters and subchapters on this page.</p>
<p><a href="/admin/create_chapter/chapter">Click here to add a new chapter</a>, or <a href="/admin/create_chapter/subchapter">click here to add a new subchapter</a>!</p>
<?php if(!$chapters){ ?>
	<p>No chapters exist! <a href="/admin/create_chapter/chapter">Click here to create your first chapter!</a></p>
<?php } else { ?>
	<div id="update_response" class="hidden"></div>
	<div class="table-responsive">
		<table id="chapters-table" class="table table-striped table-bordered">
			<tr>
				<th>Chapter Name</th>
				<th>Actions</th>
				<th>Subchapters</th>
			</tr>
			<?php foreach($chapters as $chapter){ ?>
				<tr>
					<td><?php echo $chapter->name; ?></td>
					<td class="text-center">
						<a title="Move chapter up" class="chaptermove-up" href="/admin/move_chapter/<?php echo $chapter->chapterid; ?>/up"><span class="glyphicon glyphicon-arrow-up"></span></a>&nbsp;&nbsp;
						<a title="Move chapter down" class="chaptermove-down" href="/admin/move_chapter/<?php echo $chapter->chapterid; ?>/down"><span class="glyphicon glyphicon-arrow-down"></span></a>&nbsp;&nbsp;
						<a title="Edit chapter" href="/admin/create_chapter/<?php echo $chapter->type; ?>/<?php echo $chapter->chapterid; ?>"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
						<a title="Delete chapter" class="delete-button" href="/admin/delete_chapter/<?php echo $chapter->chapterid; ?>"><span class="glyphicon glyphicon-trash"></span></a>
					</td>
					<td>
						<?php if(!isset($chapter->subchapters)){ ?>
							No subchapters!
						<?php } else { ?>
							<div class="table-responsive">
								<table class="table table-striped table-bordered">
									<?php foreach($chapter->subchapters as $subchapter){ ?>
										<tr>
										<td><?php echo $subchapter->name; ?></td>
										<td class="text-center">
											<?php if(count($chapter->subchapters) > 1){ //Plz note that "up" and "down" are inverted for subchapters! ?>
												<a title="Move subchapter up" class="subchaptermove-up" href="/admin/move_chapter/<?php echo $subchapter->chapterid; ?>/up"><span class="glyphicon glyphicon-arrow-up"></span></a>&nbsp;&nbsp;
												<a title="Move subchapter down" class="subchaptermove-down" href="/admin/move_chapter/<?php echo $subchapter->chapterid; ?>/down"><span class="glyphicon glyphicon-arrow-down"></span></a>&nbsp;&nbsp;
											<?php }?>
											<a title="Edit subchapter" href="/admin/create_chapter/<?php echo $subchapter->type; ?>/<?php echo $subchapter->chapterid; ?>"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
											<a title="Delete subchapter" class="delete-button" href="/admin/delete_chapter/<?php echo $subchapter->chapterid; ?>"><span class="glyphicon glyphicon-trash"></span></a>
										</td>
									<?php } ?>
								</table>
							</div>
						<?php } ?>
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
				<h3>Are you sure you want to delete this chapter?</h3>
			</div>
			<div class="modal-body">
				<p>Deleting this chapter will completely remove it from the system!</p>
				<p>Are you sure you want to proceed?</p>
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm_deletion" class="btn btn-default">Yes!</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
