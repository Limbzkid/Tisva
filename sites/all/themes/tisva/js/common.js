$(function(){

  var  topTxt = $('.top_links li:last-child a').text()
   
	if(topTxt=="Illuminology"){
  
		$('.top_links li a').attr('target' , '_blank');
		}

	/*added on 21 april 2014 -start*/
	  if($(document).height() <= $(window).height()){
		
		if($('.product_wrapper').length>0){
			var pageHeight = $(document).height() - ($('.header').outerHeight() + $('.footer').outerHeight());
		}
		else{
			var pageHeight = $(document).height() - ($('.header').outerHeight() + $('.footer').outerHeight());
		}
		$('.content').css('min-height', pageHeight);
	}    
	/*added on 21 april 2014 -end */
		   
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
		
		$('.header_right').css('width', '540px');
		
	}
	else{
	$('.pro_info_rhs .prod_thumb .prod_img').mouseenter(function(){
			$(this).next('.prod_data').fadeIn();
		})
		$('.pro_info_rhs .prod_thumb .prod_data').mouseleave(function(){
			$(this).fadeOut();
		})
	}
	//updated on 10th April 2014 - start
	$('.header_links li.products, .header_links li.spaces').mouseenter(function(){  
		$(this).find('ul').stop(false,false).slideDown();
		$(this).children('a').addClass('active');
		$('.search_form').stop(true).slideUp();
		$('.search').removeClass('active_slide');

	});
	
	$('.header_links li.products, .header_links li.spaces').mouseleave(function(){
		$(this).find('ul').stop(false,false).slideUp();
		$(this).find('a').removeClass('active');
		$('.search_form').stop(true).slideUp();
		$('.search').removeClass('active_slide');
	})	
	//updated on 10th April 2014 - end
	
	//added on 10th April 2014 - start
	$('.header_links .search a').click(function(){  
		$(this).next('.search_form').stop(true).slideToggle();
		$(this).parent().toggleClass('active_slide');
	})	
	//added on 10th April 2014 - start
	//
	$('.drag').click(function(){
	//var getHeight= parseInt($('.feedback-head').outerHeight()+$('.feedback-head').offset().top);
	//var windowHeight = $(window).height();
	winWidth=$(window).width();

			if($(this).parents('.feedback-head').hasClass('open')){	
				if(winWidth<=360){
					
					$('.feedback-head').animate({'right':-260},function(){
					$('.feedback-head').removeAttr('style');
				});	
				}else{

					$('.feedback-head').animate({'right':-317},function(){
					$('.feedback-head').removeAttr('style');
				});
				}
				
				$(this).parents('.feedback-head').removeClass('open');
				return false;
			}else{
				$(this).parents('.feedback-head').addClass('open');
				if(winWidth<=640){
				$('.feedback-head').animate({'right':-3},function(){
					$('html,body').animate({'scrollTop':0});
				});	
				}
				
				$('.feedback-head').animate({'right':-3});
			}
		
	

});

$('.close_feedback').click(function(){
	if(winWidth<=360){
		$('.feedback-head').removeAttr('style');
	}else{
		$('.feedback-head').animate({'right':-317}).removeClass('open');	
	}
	
});

$('.fadeout .close_lnk').click(function(){
	$('.feedback-main').fadeout();
});
	
	
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
function myFocus(element) {
	if (element.value == element.defaultValue) {
		element.value = '';
	}
}

function myBlur(element) {
	if (element.value == '') {
		element.value = element.defaultValue;
	}
}