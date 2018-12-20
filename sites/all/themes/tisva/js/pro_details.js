$(document).ready(function(){
	$('.info_features2').find('li').prepend('<span class="bullet"></span>');

	//to apply white color on the left
	var left = $('.page_wrapper').offset().left;
	$('.left_top_section').css({"padding-left": left, "margin-left": (left * -1)});
	
	
	//tabs for lamps
	
	$('.lamp_types .prod_img').click(function(){
		$(this).addClass('active').siblings().removeClass('active');
		var img_path = $(this).attr('rel');
		$(this).parents('.lamp_types').prev('img').attr('src', img_path);
	});
	
	$('.lamps_list > li .lamp_data').click(function(){
													
		var active_lamp = $(this).parent('li').index();
		$(this).parent('li').addClass('active').siblings().removeClass('active');
		$('.lamps_tabs .lamps_tab_container').eq(active_lamp).show().siblings().hide();
		var itemCode = $(this).parent().attr('rel');
		$('h1.detail_title').find('.item_code').html('Item code '+itemCode);
		 pagination();
		// alert($('.lamps_tab_container:visible').length)
		 $('.lamps_tab_container:visible').find('.lamp_types > ul .prod_img').eq(activeIndex).click();
		 var margin_left = 	$('.lamps_tab_container:visible').find('.lamp_types .pagination').width() / 2;	
		 $('.lamps_tab_container:visible').find('.lamp_types .pagination').css('margin-left',-margin_left);
		 
		//bottom tabs 
		/*$('.lamps_tab_container:visible').find('.bottom_tabs > ul li a').click(function(){
			$(this).parent().addClass('active').siblings().removeClass('active');
			$('.lamps_tab_container:visible').find('.bottom_tab_data .tab_info').eq($(this).parent().index()).show().siblings().hide();
		}).eq(activeIndex).click();*/
		slide_thumbnails();
	});
	
	var activeIndex=$(".lamps_list li.active").index();
	
	$('.lamps_list > li').eq(activeIndex).find('.lamp_data').click();
	
	
	
	$('.lamp_types .pagination li a').live('click', function(){
		var act_lamp_style = $(this).parent().index();											 
		$(this).parent().addClass('active').siblings().removeClass('active');
		$('.lamps_tab_container:visible').find('.slider_container').animate({'margin-left': act_lamp_style * parseInt($('.lamp_types > ul').find('.prod_img').outerWidth(true))* -1})
		
		
	}).eq(0).click()
	
	
	
})


//generate pagination bullets
function pagination(){
	
	var total_nav = $('.lamps_tab_container:visible').find('.lamp_types > ul').find('.prod_img').length;
	if(total_nav>3){
		$('.lamps_tab_container:visible').find(".lamp_types .pagination").html('');
			for(var i=0; i<=(total_nav-3); i++)
			{
				$('.lamps_tab_container:visible').find(".lamp_types .pagination").append('<li><a href="javascript:;">&nbsp;</a></li>');
		}	
		$('.lamps_tab_container:visible').find('.lamp_types .pagination li').eq(0).find('a').click()
	
	}

}

function slide_thumbnails(){
	var total_thumbs = $('.lamps_tab_container:visible').find('.lamp_types > ul').find('.prod_img').length;
	var container_width = total_thumbs * ( parseInt($('.lamp_types > ul').find('.prod_img').outerWidth(true)) )
	$('.lamps_tab_container:visible').find('.slider_container').css({'width': container_width})
}
