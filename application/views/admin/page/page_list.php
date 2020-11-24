<h1>Manage Pages</h1>
<?php if($pages != FALSE){ ?>
	<p>Manage all your comic pages below! Pages show in reverse order (latest at the top). <a href="<?php echo base_url(); ?>admin/create_page">Click here to add a new page</a>.</p>
	<div id="update_response" class="hidden"></div>
	<?php if($pagination){ ?>
		<?php echo $pagination; ?>
	<?php } ?>
	<div class="table-responsive">
		<table id="pages-table" class="table table-striped table-bordered">
			<tr>
				<th>Published</th>
				<th>Page Name</th>
				<th>File Name</th>
				<th>Actions</th>
			</tr>
			<?php foreach($pages as $chapter){ ?>
				<tr>
					<th colspan="4">
						<?php if($chapter->chapterid > 0){ ?>[Chapter End] <?php } ?><?php echo $chapter->name; ?>
						<?php if($chapter->chapterid > 0){ ?>
							<div class="pull-right">
								<a href="<?php echo base_url(); ?>admin/create_chapter/<?php echo $chapter->type; ?>/<?php echo $chapter->chapterid; ?>">[Edit]</a>
							</div>
						<?php } ?>
					</th>
				</tr>
				<?php if(!empty($chapter->subchapters)){ //Only show if subchapters ?>
					<?php foreach($chapter->subchapters as $subchapter){ ?>
						<?php if(!empty($subchapter->pages)){ //Only show if pages ?>
							<?php foreach($subchapter->pages as $page){ ?>
								<tr>
									<td <?php if(strtotime($page->published) > time()){ ?>class="danger"<?php } ?>><?php echo date($settings['site_date_format'].' h:i A',strtotime($page->published)); ?></td>
									<td>
										<?php if($page->filename == NULL){ ?>
											<?php echo $page->name; ?>
										<?php } else { ?>
											<a href="<?php echo base_url(); ?>page/<?php echo $page->slug; ?>/preview" target="_blank">
												<?php echo $page->name; ?> <span class="glyphicon glyphicon-new-window"></span>
											</a>
										<?php } ?>
									</td>
									<?php if($page->filename == NULL){ ?>
										<td class="danger">No file found, page will not be shown in comic archive.</td>
									<?php } else { ?>
										<td><a href="<?php echo base_url(); ?>assets/pages/<?php echo $page->filename; ?>" target="_blank"><?php echo $page->filename; ?></a></td>
									<?php } ?>
									<td class="text-center">
										<a title="Move page up" class="pagemove-up" href="<?php echo base_url(); ?>admin/move_comic/<?php echo $page->comicid; ?>/up"><span class="glyphicon glyphicon-arrow-up"></span></a>&nbsp;&nbsp;
										<a title="Move page down" class="pagemove-down" href="<?php echo base_url(); ?>admin/move_comic/<?php echo $page->comicid; ?>/down"><span class="glyphicon glyphicon-arrow-down"></span></a>&nbsp;&nbsp;
										<a title="Edit page" href="<?php echo base_url(); ?>admin/create_page/<?php echo $page->comicid; ?>"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
										<a title="Delete page" class="delete-button" href="<?php echo base_url(); ?>admin/delete_comic/<?php echo $page->comicid; ?>"><span class="glyphicon glyphicon-trash"></span></a>
									</td>
								</tr>
							<?php } ?>
						<?php } else { ?>
							<tr>
								<td colspan="4" class="danger">No pages assigned, subchapter will be ignored.</td>
							</tr>
						<?php } ?>
						<tr>
							<th colspan="5">
								<?php if($subchapter->chapterid > 0){ ?>[Subchapter Start] <?php } ?><?php echo $subchapter->name; ?>
								<?php if($subchapter->chapterid > 0){ ?>
									<div class="pull-right">
										<a href="<?php echo base_url(); ?>admin/create_chapter/<?php echo $subchapter->type; ?>/<?php echo $subchapter->chapterid; ?>">[Edit]</a>
									</div>
								<?php } ?>
							</th>
						</tr>
					<?php } ?>
				<?php } ?>
				<?php if(!empty($chapter->pages)){ //Only show if pages ?>
					<?php foreach($chapter->pages as $page){ ?>
						<tr>
							<td <?php if(strtotime($page->published) > time()){ ?>class="danger"<?php } ?>><?php echo date($settings['site_date_format'].' h:i A',strtotime($page->published)); ?></td>
							<td>
								<?php if($page->filename == NULL){ ?>
									<?php echo $page->name; ?>
								<?php } else { ?>
									<a href="<?php echo base_url(); ?>page/<?php echo $page->slug; ?>/preview" target="_blank">
										<?php echo $page->name; ?> <span class="glyphicon glyphicon-new-window"></span>
									</a>
								<?php } ?>
							</td>
							<?php if($page->filename == NULL){ ?>
								<td class="danger">No file found, page will not be shown in comic archive.</td>
							<?php } else { ?>
								<td><a href="<?php echo base_url(); ?>assets/pages/<?php echo $page->filename; ?>" target="_blank"><?php echo $page->filename; ?></a></td>
							<?php } ?>
							<td class="text-center">
								<a title="Move page up" class="pagemove-up" href="<?php echo base_url(); ?>admin/move_comic/<?php echo $page->comicid; ?>/up"><span class="glyphicon glyphicon-arrow-up"></span></a>&nbsp;&nbsp;
								<a title="Move page down" class="pagemove-down" href="<?php echo base_url(); ?>admin/move_comic/<?php echo $page->comicid; ?>/down"><span class="glyphicon glyphicon-arrow-down"></span></a>&nbsp;&nbsp;
								<a title="Edit page" href="<?php echo base_url(); ?>admin/create_page/<?php echo $page->comicid; ?>"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
								<a title="Delete page" class="delete-button" href="<?php echo base_url(); ?>admin/delete_comic/<?php echo $page->comicid; ?>"><span class="glyphicon glyphicon-trash"></span></a>
							</td>
						</tr>
					<?php } ?>
				<?php } else { ?>
					<?php if(empty($chapter->subchapters)){ //Only show "ignore chapter" if there aren't subchapters ?>
						<tr>
							<td colspan="4" class="danger">No pages assigned, chapter will be ignored.</td>
						</tr>
					<?php } ?>
				<?php } ?>
				<tr>
					<th colspan="4">
						<?php if($chapter->chapterid > 0){ ?>[Chapter Start] <?php } ?><?php echo $chapter->name; ?> 
						<?php if($chapter->chapterid > 0){ ?>
							<div class="pull-right">
								<a href="<?php echo base_url(); ?>admin/create_chapter/<?php echo $chapter->type; ?>/<?php echo $chapter->chapterid; ?>">[Edit]</a>
							</div>
						<?php } ?>
					</th>
				</tr>
			<?php } ?>
		</table>
	</div>
	<?php if($pagination){ ?>
		<?php echo $pagination; ?>
	<?php } ?>
<?php } else { ?>
	<p>There are no comic pages to edit! <a href="<?php echo base_url(); ?>admin/create_page">Click here to add your first page</a>.</p>
<?php } ?>

<!-- Deletion confirm dialogue -->
<div id="deletion" class="modal fade" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3>Are you sure you want to delete this page?</h3>
			</div>
			<div class="modal-body">
				<p>Deleting this page will completely remove it from the system!</p>
				<p>Are you sure you want to proceed?</p>
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm_deletion" class="btn btn-default">Yes!</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
