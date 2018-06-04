$(document).ready(function(){
	
	//Setup before functions
	//Ref: http://stackoverflow.com/questions/4220126/run-javascript-function-when-user-finishes-typing-instead-of-on-key-up
	var typingTimer;
	var autosuggestTimer;
	var doneTypingInterval = 1000;
	var $input = $('#comic_tag');
	
	//On keyup, start the countdown (and remove any autosuggestion box that exists)
	$input.on('keyup',function(){
		$('#tag_autosuggest').remove();
		clearTimeout(typingTimer);
		clearTimeout(autosuggestTimer);
		if($('#comic_tag').val()){
			typingTimer = setTimeout(doneTyping,doneTypingInterval);
		}
	});
	
	//Searching existing tags
	function doneTyping(){
		
		//Set tag
		var tag = $('#comic_tag').val();
		
		//Value?
		if(tag.length == 0){
			return;
		}
		
		//Run search function (if there's enough letters to search on!)
		if(tag.length > 2){
			search_tags(tag);
		}
		return;
		
	}
	
	//Runs search AJAX call
	function search_tags(tag){
		$.ajax({
			type			: "POST",
			url				: "/admin/search_tags",
			data			: { tag: tag },
			success			: function(response){ auto_suggest_tags(response); },
			error			: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
	}
	
	//Auto suggest box
	function auto_suggest_tags(output){
		
		//DEBUG		
		//console.log(output);
		
		//Append search suggestions (if any)
		if(output != ""){
			$('#comic_tag_search').after(output);
		}
		
		//Hide autosuggest after five seconds
		autosuggestTimer = setTimeout(hide_autosuggest,5000);
		
		//End
		return;
		
	}
	
	//Hide autosuggest
	function hide_autosuggest(){
		$('#tag_autosuggest').remove();
	}
	
	//Click suggestions box = populate field
	$('body').on("click",".tag_suggestion",function(){
		clearTimeout(hide_autosuggest);
		$('#comic_tag').val($(this).text());
		$('#tag_autosuggest').remove();
	});
	
	//Add a new tag
	$('#add-tag-btn').click(function(){
		
		//Hide autosuggest
		$('#tag_autosuggest').remove();
		
		//Capture the tag
		var tag = $('#comic_tag').val();
		
		//DEBUG
		//console.log(tag);
		
		//Add to the comic page
		$.ajax({
			type			: "POST",
			url				: "/admin/is_tag_new",
			data			: { tags_tag: tag },
			success			: function(response){ added_tag(response,tag); },
			error			: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
	
	//Add tag to the page selections
	function added_tag(response,tag){

		//Success...
		if(response.indexOf("error") == -1){
			
			//Empty text field
			$('#comic_tag').val('');
			
			//...add to the page tags section...	
			$('#active_tags').append('<span class="active_tag" id="tag-'+response+'" >'+tag+' <span class="glyphicon glyphicon-remove delete-tag"></span><input type="hidden" name="comic_tags[]" value="'+response+'" /></span>');
		
		//Error... 
		} else {
			
			//Add response to DOM
			$('#update_response').html(response);
			
			//Show response
			$('#update_response').removeClass('hidden');
			
			//Remove after 5 secs...
			setTimeout(
				function(){
					$('#update_response').addClass('hidden');
				},5000
			);

		}
		
	}
	
	//Remove a tag
	$('body').on("click",".delete-tag",function(){
		$(this).closest('.active_tag').remove();
	});
	
	//Handle AJAX error
	function handle_error(error){
		
		$('#general_modal h3').html('ERROR!');
		$('#general_modal .modal-body').html('<p>'+error+'</p>');
		$('#general_modal').modal('show');
		
	}
	
});
