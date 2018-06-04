//Global vars to capture deletion path and context
var deletion_url = "";
var delete_context = false;

//Global vars to capture conversion path and context
var conversion_url = "";
var convert_context = false;

$(document).ready(function(){
	
	//Delete a tag
	$('#tags-table').on("click",'.delete-button',function(event){
		
		//Prevent anchor click
		event.preventDefault();
		
		//Assign deletion URL to href
		deletion_url = $(this).attr('href');
		
		//Assign context
		delete_context = this;
		
		//Show the deletion modal
		$('#deletion').modal('show');
		
	});
	
	//Show deletion modal
	$('#confirm_deletion').click(function(){
		
		//Show the deletion modal
		$('#deletion').modal('hide');
		
		//AJAX request
		$.ajax({
			context		: delete_context,
			type        : "POST",
			url         : deletion_url,
			success		: function(response){ handle_response(response,delete_context); },
			error		: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
	
	//Convert a tag
	$('#tags-table').on("click",'.convert-button',function(event){
		
		//Prevent anchor click
		event.preventDefault();
		
		//Assign conversion URL to href
		conversion_url = $(this).attr('href');
		
		//Assign context
		convert_context = this;
		
		//Show the deletion modal
		$('#conversion').modal('show');
		
	});
	
	//Show deletion modal
	$('#confirm_conversion').click(function(){
		
		//Show the deletion modal
		$('#conversion').modal('hide');
		
		//AJAX request
		$.ajax({
			context		: convert_context,
			type        : "POST",
			url         : conversion_url,
			success		: function(response){ handle_response(response,convert_context); },
			error		: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
	
	//Handle AJAX response
	function handle_response(response,context){
		
		//DEBUG
		//console.log(response);
		
		//Add response to DOM
		$('#update_response').html(response);
	
		//Show response
		$('#update_response').removeClass('hidden');
		
		//Hide it
		setTimeout(
			function(){
				$('#update_response').addClass('hidden');
			},5000
		);

		//No error, remove table row
		if(response.indexOf("error") == -1){
			
			//Fetch the row
			var row = $(context).parent().parent();
			
			//Remove the row
			$(row).remove();
			
		}
		
	}
	
	//Handle AJAX error
	function handle_error(error){
		
		$('#general_modal h3').html('ERROR!');
		$('#general_modal .modal-body').html('<p>'+error+'</p>');
		$('#general_modal').modal('show');
		
	}
	
});
