$(document).ready(function(){
		
	//Submit form
	$('#upload_chapter').validator().on('submit', function(e){
		
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
				type        : $('#upload_chapter').attr('method'),
				url         : '/admin/update_chapter',
				data        : $('#upload_chapter').serialize(),
				success		: function(response){ handle_response(response); },
				error		: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
			});
			
		}

	});
	
	//Handle AJAX response
	function handle_response(response){
		
		//DEBUG
		//console.log(response);return;
		
		//If not error, show success and redirect
		if(response.indexOf("error") == -1){
			
			$('#success').modal('show');
			setTimeout(
				function(){
					window.location.href = "/admin/manage_chapters";
				},3000
			);
			
		//Error
		} else {
			
			//Add response to DOM
			$('#update_response').html(response);
			
			//Show response
			$('#update_response').removeClass('hidden');
			
		}
		
	}
	
	//Handle AJAX error
	function handle_error(error){
		
		$('#general_modal h3').html('ERROR!');
		$('#general_modal .modal-body').html('<p>'+error+'</p>');
		$('#general_modal').modal('show');
		
	}
	
});
