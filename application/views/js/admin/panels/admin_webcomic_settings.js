$(document).ready(function(){
		
	//Submit form
	$('#update_comic').validator().on('submit', function(e){
		
		//Validated?
		if(!e.isDefaultPrevented()){
		
			//Prevent form submit
			e.preventDefault();
			
			//Run form submit
			run_ajax();
		
		}

	});
	
	//Run AJAX
	function run_ajax(){
		
		//AJAX request
		$.ajax({
			type        : $('#update_comic').attr('method'),
			url         : '/admin/update_settings/',
			data        : $('#update_comic').serialize(),
			success		: function(response){ handle_response(response); },
			error		: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	}
	
	//Handle AJAX response
	function handle_response(response){
		
		//DEBUG
		//console.log(response);
		
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
	
	//Update checkbox value
	$('input[type=checkbox]').on('change', function(){
		
		//Updates a hidden field
		if($(this).is(':checked')){
			$(this).closest('.form-group').find('input[type=hidden]').val('Yes');
		} else {
			$(this).closest('.form-group').find('input[type=hidden]').val('No');
		}
		
		//DEBUG
		//alert($(this).closest('.form-group').find('input[type=hidden]').val());
		
		return;
		
	});
	
	//Handle AJAX error
	function handle_error(error){
		
		$('#general_modal h3').html('ERROR!');
		$('#general_modal .modal-body').html('<p>'+error+'</p>');
		$('#general_modal').modal('show');
		
	}
	
});
