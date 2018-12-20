var $interval = 5000;
var $autoLoop;
$(function(){
	fullWidthSlider();
	$(window).resize(function(){
		//$(".next, .prev").unbind();
		 fullWidthSlider();
   })
})

function fullWidthSlider(){
	var full_width_slider=$(".homeSlider").width();
	//var imgWidth=$(".homeSlider li img").width();
	$(".homeSlider ul.homeSliderUL").css('width',$(".homeSlider li.slide").length * full_width_slider)
	$(".homeSlider ul.homeSliderUL li.slide, .homeSlider .sliderDiv").css('width',full_width_slider)
	clearTimeout($autoLoop);
	$autoLoop = setTimeout(function(){$(".homeSlider .next").click()},$interval);
	Banner_Swipe()
	/*if($(window).width()>800){
		 $(".homeSlider li img").css('left',-(imgWidth-full_width_slider)/2);
	}else{
		 $(".homeSlider li img").css({'width':'auto', 'left':0});
	}*/

	$(".next").click(function(){
		if(!$(".homeSlider ul.homeSliderUL").is(":animated")){
			clearTimeout($autoLoop);
			$(".homeSlider ul.homeSliderUL").animate({marginLeft:-full_width_slider},800, function(){
				$(".homeSlider li.slide:last").after($(".homeSlider li.slide:first"))
				$(".homeSlider ul.homeSliderUL").css({"margin-left":0})	
			})
			
			// for pagenation
			if($(".pagination ul li.sel").index()==$(".pagination ul li").length -1){
				 $(".pagination ul li:eq(0)").addClass('sel').siblings().removeClass('sel');
			}else{
				$(".pagination ul li.sel").next().addClass('sel').siblings().removeClass('sel');
			}
			$autoLoop = setTimeout(function(){$(".homeSlider .next").click()},$interval);
		}
	})
	
	$(".prev").click(function(){
		if(!$(".homeSlider ul.homeSliderUL").is(":animated")){
			clearTimeout($autoLoop);
			$(".homeSlider li.slide:first").before($(".homeSlider li.slide:last"))
			$(".homeSlider ul.homeSliderUL").css({"margin-left":-full_width_slider})			
			$(".homeSlider ul.homeSliderUL").animate({marginLeft:0},800)	
			// for pagenation
			if($(".pagination ul li.sel").index()==0){
				 $(".pagination ul li").eq($(".pagination ul li").length -1).addClass('sel').siblings().removeClass('sel');
			}else{
				$(".pagination ul li.sel").prev().addClass('sel').siblings().removeClass('sel');
			}
			$autoLoop = setTimeout(function(){$(".homeSlider .next").click()},$interval);
		}
	})
	
	pagenation();
	
	/*if($(window).width()<400){
		$(".homeSlider li img").css({'height':'150px'});
		$(".homeSlider li img").css({'left':-($(".homeSlider li img").width() - $(window).width())/2});
	}else if($(window).width()<800){
		$(".homeSlider li img").css({'height':'200px'});
		$(".homeSlider li img").css({'left':-($(".homeSlider li img").width() - $(window).width())/2});
	}else if($(window).width()<1000){
		$(".homeSlider li img").css({'height':'300px'});
		$(".homeSlider li img").css({'left':-($(".homeSlider li img").width() - $(window).width())/2});
	}
	else{
		$(".homeSlider li img").css({"height":"auto"});
	}*/
}


function pagenation(){
	
	var ulText="<ul>";
	$(".homeSlider ul.homeSliderUL li.slide").each(function(){
		ulText+="<li></li>";
		$(this).addClass('img-'+$(this).index());
	});
	ulText+="</ul>";
	if(!$(".pagination").hasClass('appendUl')) $(".pagination").append(ulText).addClass('appendUl')
	$(".pagination ul li:eq(0)").addClass('sel')
	
	$(".pagination li").click(function(){
		
		if($(".homeSlider ul.homeSliderUL").is(":animated")) return;
		var index=$(this).index();
		var selINdex=$(".pagination li.sel").index();
		
		if(index>selINdex){
			if(index==selINdex+1){
				 $(".next").click();
			}else{
				clearTimeout($autoLoop);
				var full_width_slider=$(".homeSlider li.slide").width() * (index-selINdex);
				$(".homeSlider ul.homeSliderUL").animate({marginLeft:-full_width_slider},1200, function(){
					for(var i=selINdex;i<index;i++){
						$(".homeSlider li.slide:last").after($(".homeSlider li.slide:first"))
						$(".homeSlider ul.homeSliderUL").css({"margin-left":0})
					}
				})
				$autoLoop = setTimeout(function(){$(".homeSlider .next").click()},$interval);
			}
			
		}else{
			if(index+1==selINdex){
				 $(".prev").click()
			}else{
				clearTimeout($autoLoop);
				var full_width_slider=$(".homeSlider li.slide").width() * (selINdex-index);
				//$(".homeSlider li:first").before($(".homeSlider li:last"))
				//$(".homeSlider li:first").before($(".homeSlider li:last"))
				for(var i=index;i<selINdex;i++){
					$(".homeSlider li.slide:first").before($(".homeSlider li.slide:last"))
				}
				$(".homeSlider ul.homeSliderUL").css({"margin-left":-full_width_slider})	
				
				$(".homeSlider ul.homeSliderUL").animate({marginLeft:0},800)	
				$autoLoop = setTimeout(function(){$(".homeSlider .next").click()},$interval);
				
			}
			
		}
		$(this).addClass('sel').siblings().removeClass('sel');
	})
}
function Banner_Swipe(){
	
	if($(".sliderDiv li").length)
	{	
		
		$(".sliderDiv ul").swipe({
			
		  swipeLeft:function(event, direction, distance, duration, fingerCount){
			  if(distance==0)
			  {
				 //  
			  }
			  else
			  {
			   $(".homeSlider .next").click();
			  }
		  },
		  swipeRight:function(event, direction, distance, duration, fingerCount){
			  if(distance==0)
			  {
				 // 
			  }
			  else
			  {
			  	$(".homeSlider .prev").click();
			  }
		  },
		  threshold:0
		});
	}
	/*Banner Swipe end*/	
}
