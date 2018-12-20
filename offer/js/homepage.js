function stopAnimation(){
	$('.slider *').stop()
}

function show_thumb(){
var activeSlide = $('.slider_container .pagination li.active').index();
	$('.slider_nav .thumb').removeClass("left").removeClass("right");
	if($('.pagination li.active').next().length){
		$('.slider_nav .thumb').eq(activeSlide).next().addClass('right');		
	}
	else{
		$('.slider_nav .thumb').eq(0).addClass('right');	
	}
	if($('.slider_container .pagination li.active').prev().length){
		$('.slider_nav .thumb').eq(activeSlide).prev().addClass('left').fadeIn();	
	}
	else{
		$('.slider_nav .thumb').eq($('.slider_container .pagination li').length-1).addClass('left');	
	}
}

$(function(){
if($(document).height()< $(window).height()){
	//alert(0)
	$('.wrapper').css('height', $(window).height())
}



if($(window).width() <= '1024'){
	$('.content').addClass('small_resolution');
}


	


var autoTimer;		   
$('.slider_rhs').fadeIn(2000);
/*$('.title_container .product_title').eq(0).fadeIn();*/
var total_nav = $('.title_container').find('p').length;
for(var i=0; i<total_nav; i++)
{
	$(".slider_container .pagination").append('<li><a href="javascript:;">&nbsp;</a></li>');
}		   

$('.lhs_nav li a').click(function(){
	var activeLight = $(this).parent().index();
	$('.slider_nav').hide();
	$(this).parent().addClass('active').siblings().removeClass('active');
	$('.product_container .product_info').eq(activeLight).fadeIn().siblings().hide();
	$('.product_container').animate({'width': '605px'}, 500);
	$('.rhs_overlay').fadeIn();
	$('.rhs').animate({'left': '825px'},500);
	
})

$('.product_container .close').click(function(){
	$('.rhs_overlay').fadeOut();
	$('.product_container').animate({'width': '0'}, 500);
	$('.rhs').animate({'left': '220px'},500, function(){
	$('.slider_nav').fadeIn();
	$('.lhs_nav li').removeClass('active')
	});
	
})

/*$('.prod_thumb .prod_img').mouseenter(function(){
	$(this).next('.prod_data').fadeIn();
})
$('.prod_thumb .prod_data').mouseleave(function(){
	$(this).fadeOut();
})
*/
	$('.slider_container .pagination li a').click(function(){
	var _this = $(this);
	var activeIndex = _this.parent().index();
	if(activeIndex==0){
		//if($('.info_title').find('.slider_rhs').length==0){
		if($('.slider_rhs .info_title').eq(0).find('.moreLink').length==0){	
		$('.slider_rhs .info_title').eq(0).append('<a href="http://www.lightsbytisva.com/offer/index.html" target="_blank" class="moreLink">Get more!</a>');
		$('.slider_rhs .info_title').eq(0).find('a').attr("onclick","ga('send', 'event', 'Calligo', 'Get More', 'Get More');")
		}
		$('.title_container .product_title').eq(0).addClass('bannerText');
		$('.bottom_links').hide();
		
			
	}
	else{
		$('.slider_rhs').find('.moreLink').remove();
		$('.title_container .product_title').eq(0).removeClass('bannerText');
		$('.bottom_links').fadeIn();		
	}
})


$('.slider_container .pagination li a').click(function(){
	
	if(!$(this).parent().hasClass('active')){	
		clearTimeout(autoTimer);
		stopAnimation();
		var _this = $(this);
		var activeIndex = _this.parent().index();
		var lastIndex = _this.parents('.slider_container .pagination').find(".active").index();
		$('.info_content').fadeOut(300);
		//$('.wrapper').removeClass('product1').removeClass('product2').removeClass('product3').removeClass('product4').removeClass('product5')
		//$(".wrapper").addClass('product'+(activeIndex + 1));
		 
		$('.product_wrapper .product'+(activeIndex + 1)).fadeIn(800).siblings().fadeOut(800);
		$('.title_container .product_title').eq(lastIndex).fadeOut(800); //1
		$('.slider_rhs .info_title').eq(lastIndex).fadeOut(800);
		$('.slider_rhs .info_title').eq(lastIndex).fadeOut(800);
		$('.img_container .img_wrapper').eq(lastIndex).animate({"opacity":"0"}, 800,function(){
			_this.parent().addClass("active").siblings().removeClass("active");
			$('.img_container .img_wrapper').eq(activeIndex).find('.off').show().siblings().hide(); // unused
			$('.bottom_links li a').removeClass('active');
			$('.title_container .product_title').eq(activeIndex).fadeIn(800); //1
			$('.img_container .img_wrapper').eq(activeIndex).animate({"opacity":"1"}, 800);
			$('.slider_rhs .info_title').eq(activeIndex).fadeIn(800);
			$('.slider_rhs .info_title').eq(activeIndex).fadeIn(800);
			show_thumb();
			
			if($('.slider_container .pagination li.active').next().length){
				autoTimer = setTimeout(function(){
							//$('.slider_container .pagination li.active').next().find('a').click();					
							},3000)
				}
				else{
					autoTimer = setTimeout(function(){
							//$('.slider_container .pagination li').eq(0).find('a').click();					
							},3000)
				}
				
		});
		
		
	}
}).eq(0).click()
		   
$(".slider_nav .next, .slider_nav .thumb.right").live('click', function () {
	//alert($('.slider_container .pagination li.active').next().length)
	stopAnimation();
	if($('.slider_container .pagination li.active').next().length){
		$('.slider_container .pagination li.active').next().find('a').click();	
	}
	else{
		$('.slider_container .pagination li').eq(0).find('a').click();		
	}
})

$(".slider_nav .prev, .slider_nav .thumb.left").live('click', function () {
	stopAnimation();																	
	if($('.slider_container .pagination li.active').prev().length){																	
		$('.slider_container .pagination li.active').prev().find('a').click();	
	}
	else{
		$('.slider_container .pagination li').eq($('.slider_container .pagination li').length - 1).find('a').click();	
	}
	
})


/*$(".slider_nav .next").mouseenter(function () {
	$(this).addClass("entered");
	var activeSlide = $('.slider_container .pagination li.active').index();
	if($('.pagination li.active').next().length){
		$('.slider_nav .thumb').eq(activeSlide).next().show().addClass('right');		
	}
	else{
		$('.slider_nav .thumb').eq(0).show().addClass('right');	
	}
			   
})*/

/*$(".slider_nav .prev").mouseenter(function () {
	$(this).addClass("entered");											
	var activeSlide = $('.slider_container .pagination li.active').index();	
	if($('.slider_container .pagination li.active').prev().length){
		$('.slider_nav .thumb').eq(activeSlide).prev().show().addClass('left');	
	}
	else{
		$('.slider_nav .thumb').eq($('.slider_container .pagination li').length-1).show().addClass('left');	
	}
})
*/
/*$('.slider_nav .thumb').mouseleave(function(){
	$(".slider_nav .next, .slider_nav .prev").removeClass("entered")
	$('.thumb').hide();
	$('.slider_nav .thumb').removeClass('left');
	$('.slider_nav .thumb').removeClass('right')
})*/
	


$('.bottom_links li > a').click(function(){
	clearTimeout(autoTimer);									 
	if(!$(this).hasClass('active')){									 
		$('.info_content .close').click();		
	}
	$(this).addClass('active').parent().siblings().find('a').removeClass('active');
	var type = $(this).attr('id');
	var activeSlide  = $('.slider_container .pagination li.active').index(); 
	if(type=="swith_on"){
			$('.img_container .img_wrapper').eq(0).find('.on').show().siblings().hide();
	}
	else{
		if($(this).parent().hasClass('info_link')){
			
			var title = $('.title_container .product_title').eq(activeSlide).html();
			
			if(type=="info"){
				var info_data = $('.info1_container .info_cont').eq(activeSlide).html();
			}
			else if(type=="spaces"){
				var info_data = $('.spaces_container .info_cont').eq(activeSlide).html();
			}
			else if(type=="features"){
				var info_data = $('.features_container .info_cont').eq(activeSlide).html();
			}
			else{
				var info_data = $('.colours_container .info_cont').eq(activeSlide).html();
			}
			$('.info_content .info_title').html(title);
			$('.slide_info').html(info_data);
			$(this).parent().find('.info_content').fadeIn('slow');	
			
			/*if($(this).parent().hasClass('clr_info_link')){
				
			}*/
			
			/*  <p class="info_title">Product <span>Pendant</span></p>
				  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </p>
				  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod.</p>*/
		}
	}
})

$('.info_content .close').click(function(){
	$('.info_link').find('.info_content').fadeOut('slow', function(){
		$('.bottom_links li a').removeClass('active');															   
	});
	
})

})