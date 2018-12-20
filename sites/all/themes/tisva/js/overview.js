$(function(){
	$('.overview_right .pagination li a').live('click', function(){
		if(!$(this).parent().hasClass('active')){	
			var _this = $(this);
			var activeIndex = _this.parent().index();
			if($('.overview_right li').length>1)
			{
				_this.parent().addClass("active").siblings('').removeClass("active");
			}
			else
				$('.overview_right li').hide();
			//var lastIndex = _this.parents('.overview_right .pagination').find(".active").index();
			$('.overview_right .product_slide').eq(activeIndex).fadeIn(1500).siblings('.product_slide').fadeOut(500);
		}
	}).eq(0).click();
	
	
	var ulWidth = $('.overview_right .pagination').width();
	$($('.overview_right .pagination').css('margin-left', ulWidth/2 * (-1)))
	
	$('.view_more').click(function(){
		$('.overview_overlay').show();
		$(this).addClass('active');
	})
	
	$('.overview_overlay .close').click(function(){
		$('.overview_overlay').hide();
		$('.view_more').removeClass('active');
	})
	
	
	/*$('.prod_thumb .prod_img').mouseenter(function(){
	$(this).next('.prod_data').fadeIn();
	})
	$('.prod_thumb .prod_data').mouseleave(function(){
		$(this).fadeOut();
	})*/
})
