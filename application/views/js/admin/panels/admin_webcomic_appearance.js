$(document).ready(function(){
	
	//Click a theme
	$('body').on('click','.theme',function(){
		
		//Get current ID
		var theme = $(this).attr('id');
		
		//DEBUG
		//alert(theme);
		
		//AJAX request
		$.ajax({
			type        : 'POST',
			url         : '/admin/update_theme/'+theme,
			success		: function(response){ handle_response(response,theme); },
			error		: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
	
	//Handle AJAX response
	function handle_response(response,theme){
		
		//DEBUG
		//console.log(response);
		//alert(theme);
		
		//Add response to DOM
		$('#update_response').html(response);
		
		//Show response
		$('#update_response').removeClass('hidden');
		
		//If not error...
		if(response.indexOf("error") == -1){
			
			//Update class
			$('.templates div').removeClass('bg-primary').addClass('theme');
			$('#'+theme).removeClass('theme');
			$('#'+theme).addClass('bg-primary');
			
			//Update folder
			if(theme == "default"){
				$('#current-default').removeClass('hidden');
				$('#current-selected').addClass('hidden');
			} else {
				$('#current-default').addClass('hidden');
				$('#current-selected').removeClass('hidden');
				$('#current-path').html(theme);
			}
			
			//Hide success message after five seconds
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
	
});
