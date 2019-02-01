<?php echo '<?xml version="1.0" encoding="UTF-8"?>';//Echo otherwise it is interpreted as PHP! ?>
<?php $cnt = 0; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title><?php echo $site['site_name']; ?></title>
		<link><?php echo base_url() . 'feed'; ?></link>
		<description>New <?php echo $site['site_page_term']; ?>s for the webcomic <?php echo $site['site_name']; ?>. Updates: <?php echo strtolower($site['site_updates_on']); ?></description>
		<copyright>Copyright (C) <?php echo $site['site_copyright']; ?> <?php echo $site['site_copyright_year']; ?>-<?php echo date('Y'); ?></copyright>
		<atom:link href="<?php echo base_url(); ?>feed" rel="self" type="application/rss+xml" />
		<?php if($pages){ ?>
			<?php foreach($pages as $chapter){ ?>
				<?php if(!empty($chapter->pages) || !empty($chapter->subchapters)){ //Only show if pages or subchapters ?>
					<?php if(!empty($chapter->pages)){ ?>
						<?php foreach($chapter->pages as $page){ ?>
							<item>
								<title><![CDATA[<?php echo $page->name; ?>]]></title>
								<description>
									<![CDATA[
										<?php if($site['site_rss_format'] != "Image Only" && !empty($page->excerpt)){ echo $page->excerpt; } ?>
										<?php if($site['site_rss_format'] != "Excerpt Only"){ ?><img src='<?php echo base_url() . 'assets/pages/' . $page->filename; ?>' /><?php } ?>
									]]>
								</description>
								<link><?php echo base_url() . 'page/' . $page->slug; ?></link>
								<guid><?php echo base_url() . 'page/' . $page->slug; ?></guid>
								<pubDate><?php echo date("D, d M Y H:i:s O", strtotime($page->published)); ?></pubDate>
							</item>
						<?php $cnt++; if($cnt == $site['site_rss_itemno']){ break(2); } } ?>
					<?php } ?>
					<?php if(!empty($chapter->subchapters)){ //Only show if subchapters ?>
						<?php foreach($chapter->subchapters as $subchapter){ ?>
							<?php if(!empty($subchapter->pages)){ //Only show if pages ?>
								<?php foreach($subchapter->pages as $page){ ?>
									<item>
										<title><![CDATA[<?php echo $page->name; ?>]]></title>
										<description>
											<![CDATA[
												<?php if($site['site_rss_format'] != "Image Only" && !empty($page->excerpt)){ echo $page->excerpt; } ?>
												<?php if($site['site_rss_format'] != "Excerpt Only"){ ?><img src='<?php echo base_url() . 'assets/pages/' . $page->filename; ?>' /><?php } ?>
											]]>
										</description>
										<link><?php echo base_url() . 'page/' . $page->slug; ?></link>
										<guid><?php echo base_url() . 'page/' . $page->slug; ?></guid>
										<pubDate><?php echo date("D, d M Y H:i:s O", strtotime($page->published)); ?></pubDate>
									</item>
								<?php $cnt++; if($cnt == $site['site_rss_itemno']){ break(2); } } ?>
							<?php } else { continue; } ?>
						<?php } ?>
					<?php } else { continue; } ?>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</channel>
</rss>