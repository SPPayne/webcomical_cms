$(document).ready(function(){
		
	//Submit file upload
	$('.btn-file :file').on('fileselect', function(event, numFiles, label){
		
		//Show loading gif
		$('#uploading_file_popup').modal('show');
		
		//Setup vars
		var formData = new FormData();
		var page = $('input[name=userfile]');
		page = page[0].files[0]; //Get from object
		formData.append('userfile',page); //Append to formdata
		
		$.ajax({
			type			: $('#upload_page').attr('method'),
			url				: base_url+"admin/upload_comic/"+pageid,
			data			: formData,
			contentType		: false,
			processData		: false,
			success			: function(response){ handle_response(response); },
			error			: function(response){ hide_upload_modal(); handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
		
	//Submit form
	$('#upload_page').validator().on('submit', function(e){
		
		//Validated?
		if(!e.isDefaultPrevented()){
		
			//Prevent form submit
			e.preventDefault();
			
			//Get CKeditor data and update text fields
			//Ref: http://stackoverflow.com/questions/3256510/how-to-ajax-submit-a-form-textarea-input-from-ckeditor
			for(instance in CKEDITOR.instances){
				CKEDITOR.instances[instance].updateElement();
			}
			
			//AJAX request
			$.ajax({
				type        : $('#upload_page').attr('method'),
				url         : base_url+'admin/update_comic/'+pageid,
				data        : $('#upload_page').serialize(),
				success		: function(response){ handle_response(response); },
				error		: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
			});
			
		}

	});
	
	//Handle AJAX response
	function handle_response(response){
		
		//DEBUG
		//console.log(response);
		
		//Hide loading gif
		hide_upload_modal();
		
		//Add response to DOM
		$('#update_response').html(response);
		
		//Show response
		$('#update_response').removeClass('hidden');
		
		//If not error, hide success message after five seconds
		if(response.indexOf("error") == -1){
			
			setTimeout(
				function(){
					$('#update_response').addClass('hidden');
				},5000
			);
			
		}
		
	}
	
	//Handle AJAX error
	function handle_error(error){
		
		$('#general_modal h3').html('ERROR!');
		$('#general_modal .modal-body').html('<p>'+error+'</p>');
		$('#general_modal').modal('show');
		
	}
	
	//Suppress upload modal - combats hanging on the "fade" effect
	function hide_upload_modal(){
		setTimeout(
			function(){
				$('#uploading_file_popup').modal('hide')
			},500
		);
	}
	
});
