$(document).ready(function(){

	//Redirect when selecting a user
	$('#userlist').change(function(){
		
		//Only if value
		if($(this).val() != ""){
			window.location.href = base_url+"admin/manage_users/" + $(this).val();
		}
		
	});
	
	//Submit form
	$('#update_user').validator().on('submit', function(e){
		
		//Validated?
		if(!e.isDefaultPrevented()){
			
			//Prevent form submit
			e.preventDefault();
			
			//Delete box ticked?
			if($('#delete_user').is(':checked')){
				$('#deletion').modal('show');
				return;
			}
			
			//Run form submit
			run_ajax();
		
		}

	});
	
	//Confirm deletion
	$('#confirm_deletion').click(function(){
		
		//Run form submit
		run_ajax();
		
	});
	
	//Run AJAX
	function run_ajax(){
		
		//AJAX request
		$.ajax({
			type        : $('#update_user').attr('method'),
			url         : base_url+'admin/update_user/'+userid,
			data        : $('#update_user').serialize(),
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
		
		//Run deletion modal hide in case it is showing
		$('#deletion').modal('hide');
		
		//Show response
		$('#update_response').removeClass('hidden');
		
		//Deletion = redirect to managment page
		if(response.indexOf("delete") != -1){
			
			window.location.href = base_url+"admin/manage_users/";
			
		}
		
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

});
