//Global vars to capture deletion path and context
var deletion_url = "";
var delete_context = false;

$(document).ready(function(){
		
	//Move page
	$('#chapters-table').on("click",'a[class^=chaptermove-],a[class^=subchaptermove-]',function(event){
		
		//Prevent anchor click
		event.preventDefault();
		
		//Get the href
		var url = $(this).attr('href');
		
		//AJAX request
		$.ajax({
			context		: this,
			type        : "POST",
			url         : url,
			success		: function(response){ move_chapter(response,this); },
			error		: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
	
	//Handle AJAX response
	function move_chapter(response,context){
		
		//DEBUG
		//console.log(response);
		//alert($(context).attr('class'));

		//Error, show error message
		if(response.indexOf("error") != -1){
			
			//Add response to DOM
			$('#update_response').html(response);
		
			//Show response
			$('#update_response').removeClass('hidden');
			
			//Hid it
			setTimeout(
				function(){
					$('#update_response').addClass('hidden');
				},5000
			);
		
		//Page has been moved!
		} else if(response.indexOf("moved") != -1){
			
			//Fetch the row
			var row = $(context).parent().parent();
			
			//Subchapter
			if($(context).attr('class').indexOf("subchapter") != -1){
			
				//Up
				if(response.indexOf("up") != -1){
					
					//Append to previous row
					$(row).prev('tr').before('<tr>'+row.html()+'</tr>');
					
				//Down
				} else {
				
					//Append to previous row
					$(row).next('tr').after('<tr>'+row.html()+'</tr>');
					
				}
			
			//Chapter
			} else {
				
				//Up
				if(response.indexOf("up") != -1){
					
					//Append to previous row
					$(row).prev('tr').before('<tr>'+row.html()+'</tr>');
					
				//Down
				} else {
					
					//Append to previous row
					$(row).next('tr').after('<tr>'+row.html()+'</tr>');
					
				}
				
			}
			
			//Remove the row
			$(row).remove();
			
		}
		
	}
	
	//Delete a chapter
	$('#chapters-table').on("click",'.delete-button',function(event){
		
		//Prevent anchor click
		event.preventDefault();
		
		//Assign deletion URL to href
		deletion_url = $(this).attr('href');
		
		//Assign context
		delete_context = this;
		
		//Show the deletion modal
		$('#deletion').modal('show');
		
	});
	
	//Show delete chapter modal
	$('#confirm_deletion').click(function(){
		
		//Show the deletion modal
		$('#deletion').modal('hide');
		
		//AJAX request
		$.ajax({
			context		: delete_context,
			type        : "POST",
			url         : deletion_url,
			success		: function(response){ delete_chapter(response,delete_context); },
			error		: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
	
	//Handle AJAX response
	function delete_chapter(response,context){
		
		//DEBUG
		//console.log(response);

		//Add response to DOM
		$('#update_response').html(response);
		
		//Show response
		$('#update_response').removeClass('hidden');

		//If not error, hide success message after five seconds
		if(response.indexOf("error") == -1){
			
			//Hide it
			setTimeout(
				function(){
					$('#update_response').addClass('hidden');
				},5000
			);
			
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
