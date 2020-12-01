$(document).ready(function(){
	
	/***** BOOKMARKS *****/
	
	//Bookmark the page
	$('[id^=bookmark_save]').click(function(){
		
		var id = $(this).attr('id');
		
		//AJAX request
		$.ajax({
			context		: $(this),
			type        : 'POST',
			url         : base_url + 'save_bookmark',
			data        : { bookmark: $(location).attr('href') },
			success		: function(response){ save_bookmark_response(response,id); },
			error		: function(response){ alert('ERROR: Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
	
	//Handle AJAX response
	function save_bookmark_response(response,id){
		
		//DEBUG
		//console.log(response);
		//console.log(id);
		
		if(response.indexOf("error") == -1){
			$('#response_'+id+' h3').html('Bookmark Saved!');
		} else {
			$('#response_'+id+' h3').html('Error saving bookmark... :(');
		}
		
		//Load confirmation modal
		$('.bookmark-response').html(response);
		$('#response_'+id).modal('show');
		setTimeout(
			function(){
				$('#response_'+id).modal('hide');
				$('.bookmark-response').html('');
			},6000
		);
		
	}
	
	//Load a bookmark
	$('[id^=bookmark_load]').click(function(){
		
		//AJAX request
		$.ajax({
			context		: $(this),
			type        : 'POST',
			url         : base_url + 'load_bookmark',
			success		: function(response){ load_bookmark_response(response); },
			error		: function(response){ alert('ERROR: Server could not complete the request. Please check that the website is available and try again.'); }
		});
		
	});
	
	//Handle AJAX response
	function load_bookmark_response(response){
		
		if(response.indexOf("error") == -1){
			window.location.href = response;
		} else {
			alert('Could not load bookmark! :(');
		}
		return;
		
	}
	
	/***** NAVIGATION *****/
	
	//Chapter or page select
	$('.chapter_select, .page_select').on("change",function(){
		window.location.href = base_url + "page/" + $(this).val();
	});
	
	//Navigate on key presses - simulates a click on next/prev buttons
	$("body").keydown(function(event){
	
		var page = false;
	
		//Left
		if(event.keyCode == 37){
			page = $('#navbar_top .prev_page').attr('href');
		}
		
		//Right
		if(event.keyCode == 39){
			page = $('#navbar_top .next_page').attr('href');
		}
		
		if(page){
			window.location.href = page;
		}
		
	});
	
	/***** MOBILE-SPECIFIC NAV *****/
	
	//Detect mobile
	//Ref: http://detectmobilebrowsers.com/
	(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);
	if(jQuery.browser.mobile == true){
	
		//Swipe left and right for mobile nav
		$('html').swipe({
			
			allowPageScroll:"auto",
			
			//Generic swipe handler for all directions
			swipe:function(event, direction, distance, duration, fingerCount, fingerData){
				
				var page = false;
				
				//Detect pathname
				var pathname = window.location.pathname;
				
				//DEBUG
				//alert(pathname);
				
				//Comic page
				if(pathname == "/" || pathname.indexOf("/page/") >= 0){
				
					//To the left = next page
					if(direction == "left"){
						page = $('#navbar_top .next_page').attr('href');
					}
					
					//To the right = prev page
					if(direction == "right"){
						page = $('#navbar_top .prev_page').attr('href');
					}
					
					if(page){
						window.location.href = page;
					}
					
				}
				
				//Tag pages
				if(pathname.indexOf("/tags/") >= 0 || pathname.indexOf("/character_appearances/") >= 0 || pathname.indexOf("/search/") >= 0){
					
					//To the left = next page
					if(direction == "left"){
						page = $('#tag_next a').attr('href');
					}
					
					//To the right = prev page
					if(direction == "right"){
						page = $('#tag_prev a').attr('href');
					}
					
					if(page){
						window.location.href = page;
					}
					
				}
				
			},
			
			excludedElements: "input"
			
		});

		//Append swipe html
		function show_swipe_prompt(){
			var prompts = "<div class='left-swipe'>Swipe right for previous<br /><span class='glyphicon glyphicon-hand-right'></span></div><div class='right-swipe'>Swipe left for next<br /><span class='glyphicon glyphicon-hand-left'></span></div>";
			$('body').prepend(prompts);
			setTimeout(
				function(){
					$('.left-swipe, .right-swipe').fadeOut('slow');
				},3000
			);
		}
		
		//Detect pathname
		var pathname = window.location.pathname;
		
		//Show prompt on comic pages
		if((pathname == "/" || pathname.indexOf("/page/") >= 0) && ($('#navbar_top .next_page').length > 0 || $('#navbar_top .prev_page').length > 0)){
			show_swipe_prompt();
		}
		
		//Show prompt on tag pages
		if((pathname.indexOf("/tags/") >= 0 || pathname.indexOf("/character_appearances/") >= 0 || pathname.indexOf("/search/") >= 0) && ($('#tag_next a').length > 0 || $('#tag_prev a').length > 0)){
			show_swipe_prompt();
		}	
		
	}
	
});
