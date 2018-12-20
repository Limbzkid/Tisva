$(function(){
	var topTxt = $('.top_links li a').text()
	if(topTxt=="Illuminology"){
		$(this).attr('target' , '_blank');
	}
	if($(document).height() <= $(window).height()){
		
		if($('.product_wrapper').length>0){
			var pageHeight = $(document).height() - ($('.header').outerHeight() + $('.footer').outerHeight());
		}
		else{
			var pageHeight = $(document).height() - ($('.header').outerHeight() + $('.footer').outerHeight());
		}
		$('.content').css('min-height', pageHeight);
	}   
		   
	var isiPad = navigator.userAgent.match(/iPad/i) != null;
	if(isiPad ==  true){
		//Only for Ipad
		orientationImageResize();
		$('.header_links li.products').click(function(){
			$(this).find('ul').show();
			$(this).find('a').addClass('active');
		})
		$('*').click(function(){
				$('.header_links li.products').find('ul').hide();	
				$(this).find('a').removeClass('active');
		})
		
	}
	else{
	/*$('.prod_thumb .prod_img').mouseenter(function(){
												  
			$(this).next('.prod_data').fadeIn();
		})
		$('.prod_thumb .prod_data').mouseleave(function(){
			$(this).fadeOut();
		})*/
	}
	
	$('.header_links li.products').hover(function(){
		$(this).find('ul').show();
		$(this).find('a').addClass('active');
	}, function(){
		$(this).find('ul').hide();
		$(this).find('a').removeClass('active');
	})	
	
})

window.onorientationchange = function () {
	orientationImageResize();
};
function orientationImageResize(){
	if (window.orientation == 90 || window.orientation == -90) {
		//landscape
		$('.portrait_overlay').hide();
	}else{
		//potrait
		$('.portrait_overlay').show();
	}
}

function clearText(field) {
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;

}