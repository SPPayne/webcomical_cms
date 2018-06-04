<?php if(isset($title)){ echo $title; } ?>
<?php if(isset($title) && isset($site['site_name'])){ ?> | <?php } ?>
<?php if(isset($site['site_name'])){ echo $site['site_name']; } ?>