//Global vars to capture deletion path and context
var deletion_url = "";
var delete_context = false;

$(document).ready(function(){
		
	//Submit file upload
	$('.btn-file :file').on('fileselect', function(event, numFiles, label){
		
		//Show loading gif
		$('#uploading_file_popup').modal('show');
		
		//Setup vars
		var refresh 	= 1;
		var formData 	= new FormData();
		var page 		= $('input[name=userfile]');
		page 			= page[0].files[0]; //Get from object
		formData.append('userfile',page); //Append to formdata
		
		$.ajax({
			type			: 'POST',
			url				: base_url+"admin/upload_banner/",
			data			: formData,
			contentType		: false,
			processData		: false,
			success			: function(response){ handle_response(response,refresh); },
			error			: function(response){ hide_upload_modal(); handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
	
	//Refresh the contents of the banners table
	function refresh_banners(){
	
		//Load banners table
		$("#all_banners").load(base_url+"admin/webcomic_banners_table",function(response,status,xhr){
			
			//Run on success
			if(status != "error"){
			
				//To trigger toggle buttons
				//Ref: http://stackoverflow.com/questions/32586384/bootstrap-toggle-doesnt-work-after-ajax-load
				$("[data-toggle='toggle']").bootstrapToggle('destroy');
				$("[data-toggle='toggle']").bootstrapToggle();
				
			}
		
		});
		
	}
	
	//Load table onload
	refresh_banners();
	
	//Turn banners off and on
	$(document.body).on("change",'.banner-toggle',function(){
		
		//Set table refresh flag
		var refresh = 0;
		
		//AJAX request
		$.ajax({
			type        : "POST",
			url         : base_url+'admin/banner_toggle/'+$(this).attr('id'),
			success		: function(response){ handle_response(response,refresh); },
			error		: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
	
	//Delete a page
	$(document.body).on("click",'.delete-button',function(event){
		
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
		
		//Set table refresh
		var refresh = 1;
		
		//AJAX request
		$.ajax({
			context		: delete_context,
			type        : "POST",
			url         : deletion_url,
			success		: function(response){ handle_response(response,refresh); },
			error		: function(response){ handle_error('Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
	
	//Handle AJAX response
	function handle_response(response,refresh){
		
		//DEBUG
		//console.log(response);
		
		//Hide loading gif
		hide_upload_modal();
		
		//Add response to DOM
		$('#update_response').html(response);
		
		//Show response
		$('#update_response').removeClass('hidden');
		
		//Refresh table
		if(refresh){
			refresh_banners();
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
	
	//Suppress upload modal - combats hanging on the "fade" effect
	function hide_upload_modal(){
		setTimeout(
			function(){
				$('#uploading_file_popup').modal('hide')
			},500
		);
	}

});
