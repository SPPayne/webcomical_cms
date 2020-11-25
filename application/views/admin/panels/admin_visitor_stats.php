<h1>Visitor Statistics</h1>
<p>This page provides some very basic stats as to the most viewed pages and most popular search terms.</p>
<p>For enhanced statistics, consider signing up for a package like <a rel="nofollow" href="https://analytics.google.com">Google Analytics</a> and applying their tracking code to your template.</p>
<p>Stats will not take into account any page views from users which are logged in.</p>
<hr />
<h2><?php echo count($recently_viewed); ?> Most Recently Viewed Pages</h2>
<?php if(!$recently_viewed){ ?>
	<p>No stats for this yet! Come back later...</p>
<?php } else { ?>
	<div class="table-responsive">
		<table id="recently-viewed" class="table table-striped table-bordered">
			<tr>
				<th>URL</th>
				<th>Type</th>
				<th>Last Viewed</th>
			</tr>
			<?php foreach($recently_viewed as $page){ ?>
				<tr>
					<td><a target="_blank" href="<?php echo base_url($page->url); ?>"><?php echo $page->url; ?> <span class="glyphicon glyphicon-new-window"></span></a></td>
					<td><?php echo ucfirst($page->page_type); ?></td>
					<td><?php echo $page->last_viewed; ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
<?php } ?>
<hr />
<h2>Top <?php echo count($page_views); ?> Most Viewed Pages</h2>
<?php if(!$page_views){ ?>
	<p>No stats for this yet! Come back later...</p>
<?php } else { ?>
	<div class="table-responsive">
		<table id="most-viewed" class="table table-striped table-bordered">
			<tr>
				<th>URL</th>
				<th>Type</th>
				<th>Amount of Views</th>
			</tr>
			<?php foreach($page_views as $page){ ?>
				<tr>
					<td><a target="_blank" href="<?php echo base_url($page->url); ?>"><?php echo $page->url; ?> <span class="glyphicon glyphicon-new-window"></span></a></td>
					<td><?php echo ucfirst($page->page_type); ?></td>
					<td><?php echo $page->views; ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
<?php } ?>
<hr />
<h2>Top <?php echo count($search_terms); ?> Most Searched Terms</h2>
<?php if(!$search_terms){ ?>
	<p>No stats for this yet! Come back later...</p>
<?php } else { ?>
	<div class="table-responsive">
		<table id="search-terms" class="table table-striped table-bordered">
			<tr>
				<th>Search Terms</th>
				<th>Amount of Times Searched</th>
			</tr>
			<?php foreach($search_terms as $page){ ?>
				<tr>
					<td><?php echo $page->url; ?></td>
					<td><?php echo $page->views; ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
<?php } ?>
