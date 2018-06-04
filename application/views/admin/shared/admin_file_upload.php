<script type="text/javascript">
	$(document).ready( function(){
		
		$(document).on('change', '.btn-file :file', function(){
			
			var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
			
		});
		
		$('.btn-file :file').on('fileselect', function(event, numFiles, label){

			var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;

			if( input.length ) {
				input.val(log);
			} else {
				if(log)alert(log);
			}
		
		});
		
	});
</script>
<form id="upload_file" enctype="multipart/form-data">
	<div class="form-group">
		<div class="input-group">
			<span class="input-group-btn">
				<span class="btn btn-primary btn-file">
					Browse&hellip; <input type="file" name="userfile" id="userfile" />
				</span>
			</span>
			<input type="text" class="form-control" readonly />
		</div>
	</div>
</form>
<!-- Uploading dialogue -->
<div id="uploading_file_popup" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Uploading file...</h3>
			</div>
			<div class="modal-body">
				<p class="text-center">Please wait...</p>
				<p class="text-center"><img src="/assets/icons/loading<?php if($settings['site_webby'] == "Yes"){ ?>-webby<?php } ?>.gif" /></p>
			</div>
		</div>
	</div>
</div>
