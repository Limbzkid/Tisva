
/*window.onload = function(){
	var changeViewport = function () {
	var documentHeight = $(document).height();
	$('#rotation').css('height', documentHeight);
    if (window.orientation == 90 || window.orientation == -90){
        $('meta[name="viewport"]').attr('content', 'height=device-width,width=device-height,initial-scale=1.0,maximum-scale=1.0');
		document.getElementById("rotation").style.display = "block";
		scrollTop();}
    else{
        $('meta[name="viewport"]').attr('content', 'height=device-height,width=device-width,initial-scale=1.0,maximum-scale=1.0');
		document.getElementById("rotation").style.display = "none";
		}
	}
	window.addEventListener('orientationchange', changeViewport, true);
	try { changeViewport(); } catch (err) { }
}*/

/**/
function navWrapScroll () {
var windowHt = $(window).height();
var docHt = $(document).height();
var headerHt = $('.header').height();
var footerHt = $('.footerWrap').height();
var navWrapperHt = windowHt - headerHt
$('.navWrapper .scroller').css({'height': navWrapperHt})
$('.wrapperOverlay').css({'top': headerHt})
//$('.pageWrapper').css({'height': windowHt})
//var scrollerHt = windowHt - headerHt
//$('.navWrapper .scroller').css({'height': scrollerHt})
}
$(document).ready(function(){
	var windowHt = $(window).height();
	var headerHt = $('.header').height();
	var footerHt = $('.footerWrap').height();
	var wrapperHt = windowHt - headerHt - footerHt - 1
	$('.pageWrapper .wrapper').css({'min-height': wrapperHt})
	/*checkbox starts*/
	$('label.checkBox').click(function(){
		if ($(this).find('input').is(':checked'))
		{
		$(this).addClass('checked');
		}
		else $(this).removeClass('checked')	
		
	});
	/*checkbox ends*/
	/*Select code*/
	$("select").each(function(){
		$(this).children("option").each(function(){
			if($(this).attr("selected"))
			{
				$(this).prev(".selectedvalue").html($(this).html());
			}
		});
	});
	$("select").change(function(){
		$(this).prev().html($(this).val());									
	});
	/*Select code*/
	/*Radio buttons code*/
	$('.radioList li label').click(function(){
	  $(this).addClass('active').parent('li').siblings().find('label').removeClass('active');
	  $(this).children('input')
	});
	/*Radio buttons code*/
	$('.prdctTabsWrap .tabs li').click(function(){
		$(this).addClass("sel").siblings("li").removeClass("sel").parents(".prdctTabsWrap").find(".tabContent").eq($(this).index()).show().siblings(".tabContent").hide();
	}).eq(0).click();
	
	$('a.magnifyBtn').click(function(){
		var imgSrc = $(this).find('img').attr('src')
		$('.prdctImgLightBox .imgBox').html("<img src=" + imgSrc +">");
		$('.prdctImgLightBox').fadeIn();
	});
	$('.prdctImgLightBox a.closeBtn').click(function(){
		$('.prdctImgLightBox').fadeOut();
		$(".prdctImgLightBox .imgBox").html('');
	});
	
	
	$('.footer .downloadBtn').click(function(){
	  $(this).toggleClass('active').prev('.downloadLinks').slideToggle();
	});
	$('.footerArrow').click(function(){
	  $(this).fadeOut();
	  $(this).next('.fixBandWrap').slideDown().find('.footerArrowDown').fadeIn(800);
	});
	
	$('.fixBandWrap .footerArrowDown').click(function(){
	  $(this).parents('.fixBandWrap').slideUp();
	  setTimeout(function () {
			$('.footerArrow').fadeIn();
			$('.fixBandWrap').find('.footerArrowDown').fadeOut();
        }, 300);
		
	});
	 /*var owl = $(".owl-vfapp");
	 if($('.owl-vfapp').length>=1){
		$('.owl-vfapp').owlCarousel({
		items:1,
		loop:true,
		autoplay:true,
		autoplayTimeout:5000,
		dots:true,
		nav:false,
		responsive:true,
		});
 	 }*/
	 
	 var headerHt = $('.header').height()
	$('.navWrapper').css('top' , headerHt)
	$('.searchWrapper').css('top' , headerHt)
	
	
	var windowHt = $(window).height();
	var headerHt = $('.header').height();
	var footerHt = $('.footerWrap').height();
	//var homeSliderHt = windowHt - headerHt - footerHt -2;
	var sliderOuter = $('.homeSlider').height();
	var visibleHt = sliderOuter + headerHt + footerHt;
	//alert(sliderOuter)
	//$('.homeSlider').css('height' , homeSliderHt)
	if($('.homeSlider').length>=1){
		if(windowHt>visibleHt)
		{
			var wrapperHt = windowHt - headerHt - footerHt - 1;
			$('.wrapper').css('height' , wrapperHt)
		}
	}
	//$('.wrapper').css('margin-bottom' , footerHt)
	navWrapScroll();
	 $('.homeSlider li a.btnInfo').click(function(){
	   $(this).parents('.slide').find('.infoWrap').slideDown();
	   clearTimeout($autoLoop);
	
	 });
	 $('.homeSlider li a.btnFeatures').click(function(){
	   $(this).parents('.slide').find('.featuresWrap').slideDown();
	   clearTimeout($autoLoop);
	 });
	 
	 $('.homeSlider .closeBtn, .homeSlider .btn').click(function(){
	   $(this).parents('.slide').find('.popup').slideUp();
	   $autoLoop = setTimeout(function(){$(".homeSlider .next").click()},$interval);
	 });
	 
	  

	$(".searchBtn").click(function(){
    if($(this).siblings(".menuBtn").hasClass("active"))
	{
	  	$(".menuBtn").removeClass("active");
		$(".navWrapper").slideUp();
	}
	$(this).toggleClass("active");
	$(".searchWrapper").slideToggle();
	});
	$(".menuBtn").click(function(){
	if($(this).siblings(".searchBtn").hasClass("active"))
	{
	  	$(".searchBtn").removeClass("active");
		$(".searchWrapper").slideUp();
	}
	if($('.table-wrapper').length>=1)
	{
		$('.table-wrapper').css('opacity' , 0)
	}
    /*$(this).toggleClass("active");
	$(".navWrapper").slideToggle();
	$(".wrapperOverlay").fadeToggle(800);*/
    if($(this).hasClass('active'))
    {
      var windowHt = $(window).height();
	 //$('.pageWrapper').css({'height': 'auto'})
	 $(this).removeClass('active');
	  $(".wrapperOverlay").fadeOut(800);
	  $(".navWrapper").slideUp();
	  //$(".pageWrapper").css('overflow' , 'auto');
	  $('.footerWrap, .footerArrow').removeClass('disable');
	  if($('.table-wrapper').length>=1)
	  {
		$('.table-wrapper').css('opacity' , 1)
	  }
    }
    else
    {
	  var windowHt = $(window).height();
	  //$('.pageWrapper').css({'height': windowHt})
	  $(this).addClass('active');
	  $(".navWrapper").slideDown();
	  $(".wrapperOverlay").fadeIn(800);
	  //$(".pageWrapper").css('overflow' , 'hidden');
	  $('.footerWrap, .footerArrow').addClass('disable');
    }
   
  });
  
  var lenBox =$('.product-slide .prod_thumb').length;					   
	for(var i =0; i < lenBox ; i++){
		$('.product-slide').eq(i).find('.prod_thumb:odd').addClass('odd');
	}
  
  $(".navWrapper .mainLink>a").click(function(){
    if($(this).hasClass('active'))
	  {  
		$(this).removeClass('active').next('.subLink').slideUp();
	  }
	else {
		$(this).addClass('active').next('.subLink').slideDown();
		$(this).parent('.mainLink').siblings('.mainLink').children('a').removeClass("active");
		$('.subLink').not($(this).next()).slideUp()
	}
  });
  
});

function clearText(a) {
    if (a.defaultValue == a.value) {
        a.value = ""
    } else {
        if (a.value == "") {
            a.value = a.defaultValue
        }
    }
}