<?php include("includes/includes.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title>TISVA - Winners</title>
<link rel="stylesheet" href="css/style.css" />
<script>var base_url = "<?php echo BASE_URL; ?>";</script>
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/pro_details.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
		 $(".November").show()
		 $(".October").hide()
		 $("#cities").hide()
		$( "#month" ).change(function() {
		
		if($("#month").val() =="November"){
			//alert($("select#cities1 option:selected").val()+"kkk")
			  $("#cities1").show()
			  $(".November").show()
			  $(".October").hide()
	    	$("#cities").hide()
		}
		if($("#month").val()=="October"){
			  $("#cities1").hide()
			
	    	$("#cities").show()
			$(".October").show()
			 $(".November").hide()

}

		//	alert($("select#cities1 option:selected").val())
			
	
});
        $("select").change(function(){
		
            $( "select option:selected").each(function(){
                if($("#cities").val() =="Pune"){
                  // 	alert($("#cities").val())
                    	$("#Pune").show();
						 $("#Chandigarh").hide();
					 	 $("#Ahmedabad").hide();
						 $("#Hyderabad").hide();
						 $("#Mumbai").hide();
						  $("#Delhi").hide();
								
                }
                if($("#cities").val()=="Delhi"){
                   		 $("#Pune").hide();
                    	  $("#Delhi").show();
						   $("#Chandigarh").hide();
					 	 $("#Ahmedabad").hide();
						 $("#Hyderabad").hide();
						  $("#Mumbai").hide();
                }
                if($("#cities").val()=="Chandigarh"){
                     	 $("#Pune").hide();
					     $("#Delhi").hide();
                    	 $("#Chandigarh").show();
					     $("#Ahmedabad").hide();
						 $("#Hyderabad").hide();
						  $("#Mumbai").hide();
                }
				  if($("#cities").val()=="Ahmedabad"){
                    	
						$("#Pune").hide();
					    $("#Delhi").hide();
                   		$("#Ahmedabad").show();
					    $("#Chandigarh").hide();
						$("#Hyderabad").hide();
						 $("#Mumbai").hide();
                }
				
				 if($("#cities").val()=="Hyderabad"){
                    	$("#Pune").hide();
					    $("#Delhi").hide();
						$("#Hyderabad").show();
                   		$("#Ahmedabad").hide();
					    $("#Chandigarh").hide();
						 $("#Mumbai").hide();
                }
				 if($("#cities").val()=="Mumbai"){
                    	$("#Pune").hide();
					    $("#Delhi").hide();
						$("#Mumbai").show();
                   		$("#Ahmedabad").hide();
					    $("#Chandigarh").hide();
						 $("#Hyderabad").hide();
                }
            });
        }).change();
	  	
		 $("select").change(function(){
			
            $( "select option:selected").each(function(){
                if($("#cities1").val() =="Pune"){
                   	
                    	$(".Pune").show();
						 $(".Chandigarh").hide();
						 $(".Hyderabad").hide();
	             }
			
				if ($("#cities1").val() == "Chandigarh") {//Chandigarh
				   // alert($("#cities1").val() + "in")
                   		 $(".Pune").hide();
                   		 $("#Chandigarh1").show();
						   $(".Hyderabad").hide();
					 	 
                }
              
				 if($("#cities1").val()=="Hyderabad"){
                   		 $(".Pune").hide();
                    	  $(".Hyderabad").show();
						   $(".Chandigarh").hide();
						   
					 	
                }
				
            });
        }).change();
    });
	
	
</script>
<script type="text/javascript">
	$(document).ready(function(){
		//fbShare
		$(".fbShare").click(function(){
			var imgPath = $.trim($(this).closest(".winner1").find(".winnerImg").find("img").attr("src"));
			var name =	$.trim($(this).closest(".winner1").find(".name").text());
			var designation = $.trim($(this).closest(".winner1").find(".design").text());
			var loc = $.trim($(this).closest(".winner1").find(".loc").text());
			var quote = $.trim($(this).closest(".winner1").find(".quote").text());
			//alert(name + ' ' + designation + ' ' + loc + ' ' + quote);
			$.ajax({
					url: base_url + '/offer/getWinnerDetails.php',
					type: 'GET',
					data: {'img' : imgPath, 'name': name, 'design': designation, 'loc': loc, 'quote': quote },
					success: function(data) {
						var t = document.title;
						var u = base_url + '/getWinnerDetails.php?name='+name+'&img='+imgPath+'&design='+designation+'&loc='+loc+'&quote='+quote;
						//alert(u);
						//alert(encodeURIComponent(u));
						window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');
				}
			});
		})
	})
</script>
</head>
<body class="bgwinner">
<div class="portrait_overlay"><img src="images/rotate.jpeg" alt="Please rotate your device" title="Please rotate your device" /></div>
<div class="wrapper bgnone" >
  <div class="header">
    <div class="page_wrapper">
      <div class="lhs"> <a href="index.html" class="logo"><img src="images/tisva-logo.png" alt="TISVA" title="TISVA" /></a> </div>
      <div class="rhs">
        <div class="header_right">
          <ul class="top_links">
            <li><span></span><a href="mailto:Customer_care@lifebytisva.com">Email Us Tisva</a></li>
            <li><span></span><a href="store-locator.html">Store Locator</a></li>
          </ul>
          <ul class="header_links">
            <li class="products"><span></span><a href="javascript:;">Product Range</a>
              <ul>
                <li><a href="chandelier-overview.html">Chandeliers</a></li>
                <li><a href="LED-spots-overview.html">LED Spots</a></li>
                <li><a href="wall-lights-overview.html">Wall Lights</a></li>
                <li><a href="kids-range-overview.html">Kids Range</a></li>
                <li class="no_border"><a href="pendants-overview.html">Pendants</a></li>
                <li class="no_border"><a href="led-decorative-overview.html">LED Decorative Range</a></li>
              </ul>
            </li>
            <li><span></span><a href="about-tisva.html">About Tisva</a></li>
            <li class="call_text">Call us on <span>1800 103 3222</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!--<div class="content banner_content">-->
  <div class="content">
    <div class="page_wrapper">
      <!--<div class="overview_top">
        <ul class="breadcrumb">
          <li><span></span><a href="chandelier-overview.html">Chandelier</a></li>
          <li class="active"><span></span><a href="javascript:;">Feyyo</a></li>
        </ul>
      </div>-->
      <div class="title_container"><p class="winner_title">Lucky Winners</p>
        <p class="detail">Is luck going your way today? It is time to find out if you are one of the few to walk away with the grand prize! </p>
        <p class="winner_title splcolor"><span style="float:left">Congratulation to the winners of</span>
          <select id="month" >
            <option title="October" value="October">October</option>
            <option title="November" value="November" selected="selected">November</option>
          </select>
          <span  style="float:left; padding:0 0 0 8px;">2014 from</span>
          <select id="cities" >
            <!-- <option selected="true" value="Please Select">Cities</option>-->
            <option title="Ahmedabad" value="Ahmedabad" selected="selected">Ahmedabad</option>
            <option title="Chandigarh" value="Chandigarh">Chandigarh</option>
            <option title="Delhi" value="Delhi">Delhi</option>
            <option title="Hyderabad" value="Hyderabad">Hyderabad</option>
            <option title="Mumbai" value="Mumbai">Mumbai</option>
            <option title="Pune" value="Pune">Pune</option>
          </select>
          <select id="cities1" >
            <!--<option selected="true" value="Please Select">Cities</option>-->
            <option title="Chandigarh" value="Chandigarh"  selected="selected">Chandigarh</option>
            <option title="Hyderabad" value="Hyderabad">Hyderabad</option>
            <option title="Pune" value="Pune">Pune</option>
          </select>
        </p>
        <div class="October">
          <div class="winnerlist Ahmedabad1" id="Ahmedabad">
            <div class="winner2">
              <div class="winnerImg btmPad"><img src="images/kiara_shah.gif" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner details_winnerother">
                <p> <span>Name : </span> <span class="splColour other">Mr Kiran Shah</span></p>
                <p> <span> Profession  : </span><span class="splColour other">Importer of Building Material </span></p>
                <p> <span> Location : </span><span class="splColour other">Bodakdev</span></p>
                <p> <span> Quote : </span><span class="rtInfoOther other">Really impressed to branding efforts, marketing, skilled & polite staff, display choice of distributors as well as location. No doubt about quality & appearance and nice looking all contacts. Wish you all the best and confident that your brand name will grow very fast in Indian market (Top 3). </span></p>
              </div>
            </div>
            <div class="clear"></div>
            <p class="detail wishes">If you weren't, don't worry. Visit our store, purchase any of our products  and you stand a chance  to take home 1 lakh worth of Tisva lights. <span>Best of luck! </span> </p>
            <p>&nbsp;</p>
          </div>
          <div class="winnerlist Delhi1" id="Delhi">
            <div class="winner1">
              <div class="winnerImg btmPad"><img src="images/winner1_delhi.png" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner">
                <p> <span>Name : </span> <span class="splColour">Dr Ritika</span></p>
                <p> <span> Designation : </span><span class="splColour">Doctor, Guruteg bhadur hospital </span></p>
                <p> <span> Location : </span><span class="splColour">Naraina Vihar</span></p>
                <p> <span> Quote : </span><span class="rtInfo">Excellent experience. Excellent Collection & Excellent service.</span></p>
              </div>
            </div>
            <div class="winner1">
              <div class="winnerImg btmPad"><img src="images/winner2_delhi.png" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner">
                <p> <span>Name : </span><span class="splColour"> Mrs Rashmi Gupta</span></p>
                <p> <span> Profession : </span><span class="splColour">Housewife</span></p>
                <p> <span> Location : </span><span class="splColour">Golf Course Road, Gurgaon </span></p>
                <p> <span> Quote : </span><span class="rtInfo">I am absolutely delighted winning this lucky draw. Saw many fraud ones, but this one is awesome. I have huge respect for this brand/store. Thanks a ton.</span></p>
              </div>
            </div>
            <div class="winner1">
              <div class="winnerImg btmPad"><img src="images/winner3_delhi.png" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner">
                <p> <span>Name : </span><span class="splColour"> Mr RC Bhargava</span></p>
                <p> <span> Designation : </span><span class="splColour">Chairman, Maruti Suzuki</span> </p>
                <p> <span> Location : </span><span class="splColour">Noida</span></p>
                <p> <span> Quote : </span><span class="rtInfo">Winning the lucky draw prize was unbelievable. I had never won any prize this earlier. The lights we bought were just what we wanted and we are very happy with them.</span></p>
              </div>
            </div>
            <div class="winner1">
              <div class="winnerImg btmPad"><img src="images/winner4_delhi.png" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner">
                <p> <span>Name : </span><span class="splColour"> Mr Vikas Bajaj</span></p>
                <p> <span> Designation : </span><span class="splColour">Banker, DCB </span></p>
                <p> <span> Location : </span><span class="splColour">Gurgaon </span></p>
                <p> <span> Quote : </span><span class="rtInfo">Wonderful experience and couldn't believe that I have won the lucky draw. Thanks a lot.</span></p>
              </div>
            </div>
            <div class="clear"></div>
            <!--<p class="detail wishes">Congratulations to this month's winners! We have your details and will get in touch with you shortly.</p>-->
            <p class="detail wishes">If you weren't, don't worry. Visit our store, purchase any of our products  and you stand a chance  to take home 1 lakh worth of Tisva lights. <span>Best of luck! </span> </p>
            <p>&nbsp;</p>
          </div>
          <div class="winnerlist Chandigarh1" id="Chandigarh">
            <div class="winner1">
              <div class="winnerImg btmPad"><img src="images/s_singh.gif" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner">
                <p> <span>Name : </span> <span class="splColour">Mr.Swarandeep Singh</span></p>
                <p> <span> Business : </span><span class="splColour">Owner of Logic Software</span></p>
                <p> <span> Location : </span><span class="splColour">Mohali</span></p>
                <p> <span> Quote : </span><span class="rtInfo">Mrs. And Mr. Dhillon were very excited and delighted to have won the lucky draw </span></p>
              </div>
            </div>
            <div class="winner1">
              <div class="winnerImg btmPad"><img src="images/BS_Dhillon.jpg" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner">
                <p> <span>Name : </span><span class="splColour"> Mr BS Dhillon</span></p>
                <p> <span> Profession : </span><span class="splColour">President, Fortis Healthcare Ltd</span></p>
                <p> <span> Location : </span><span class="splColour">gf </span></p>
                <p> <span> Quote : </span><span class="rtInfo">hgfhgf</span> 
              </div>
            </div>
            <div class="clear"></div>
            <p class="detail wishes">If you weren't, don't worry. Visit our store, purchase any of our products  and you stand a chance  to take home 1 lakh worth of Tisva lights. <span>Best of luck! </span> </p>
            <p>&nbsp;</p>
          </div>
          <div class="winnerlistPune Pune1" id="Pune">
            <div class="winner2">
              <div class="winnerImg btmPad"><img src="images/Pune_Yash_Shaha.png" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner details_winnerother">
                <p> <span>Name : </span> <span class="splColour other">Yash Shaha</span></p>
                <p> <span> Designation : </span><span class="splColour other">Manager, Regional Sales, Tyco Sanmar Ltd </span></p>
                <p> <span> Location : </span><span class="splColour other">Koregaon Park</span></p>
                <p> <span> Quote : </span><span class="rtInfoOther other">A wonderful and unbelievable experience. It was all accidental we landed up in Tisva store before Diwali to buy wall and ceiling chandelier. We were impressed with the product range and MRP of really good items and proper response. We were lucky to get a promotional coupon also from the company worth 1 lac. It was a wonderful experience having visiting the store and meeting good sales manager here at the shop. All the best to the brand and the company.</span></p>
              </div>
            </div>
            <div class="clear"></div>
            <p class="detail wishes">If you weren't, don't worry. Visit our store, purchase any of our products  and you stand a chance  to take home 1 lakh worth of Tisva lights. <span>Best of luck! </span> </p>
            <p>&nbsp;</p>
          </div>
          <div class="winnerlistPune Hyderabad1" id="Hyderabad">
            <div class="winner2">
              <div class="winnerImg btmPad"><img src="images/krishnan.gif" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner details_winnerother">
                <p> <span>Name : </span> <span class="splColour other">Mr C. Krishna</span></p>
                <p> <span> Profession  : </span><span class="splColour other">Retired General Manager, TVS Lucas</span></p>
                <p> <span> Location : </span><span class="splColour other">Lodha Casafaradino</span></p>
                <p> <span> Quote : </span><span class="rtInfoOther other">The experience with TISVA is excellent, customer focus is very good & I will recommend to my friends & relatives to buy only TISVA.</span></p>
              </div>
            </div>
            <div class="clear"></div>
            <p class="detail wishes">If you weren't, don't worry. Visit our store, purchase any of our products  and you stand a chance  to take home 1 lakh worth of Tisva lights. <span>Best of luck! </span> </p>
            <p>&nbsp;</p>
          </div>
          <div class="winnerlistPune Mumbai1" id="Mumbai">
            <div class="winner2">
              <div class="winnerImg btmPad"><img src="images/bose.gif" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner details_winnerother">
                <p> <span>Name : </span> <span class="splColour other">Anusha Bose</span></p>
                <p> <span> Profession  : </span><span class="splColour other">Head of Development, RowdyRascal (TV Production House)</span></p>
                <p> <span> Location : </span><span class="splColour other">Andheri</span></p>
                <p> <span> Quote : </span><span class="rtInfoOther other">Thank you for lighting up my daughter Myra's room & making it the perfect Diwali gift ever !! Most grateful.</span></p>
              </div>
            </div>
            <div class="clear"></div>
            <p class="detail wishes">If you weren't, don't worry. Visit our store, purchase any of our products  and you stand a chance  to take home 1 lakh worth of Tisva lights. <span>Best of luck! </span> </p>
            <p>&nbsp;</p>
          </div>
        </div>
        <div class="November">
          <div class="winnerlist Pune">
            <div class="winner2">
              <div class="winnerImg btmPad"><img src="images/jagtar.jpg" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner details_winnerother">
                <p> <span>Name : </span> <span class="splColour other">Mr. Jagtar Singh Bhatiya</span></p>
                <p> <span> Profession  : </span><span class="splColour other">Business consulting owner and MD of SIMS industrial and manie services</span></p>
                <p> <span> Location : </span><span class="splColour other">Wanworie, Pune</span></p>
                <p> <span> Quote : </span><span class="rtInfoOther other">TISVA has a very good collection of lights. We're very excited about winning this prize and will definitely come back for more lights in future. The staff in Pune were very pleasant and helpful . Mr Tiwari and Sachin take very good care of us.</span></p>
              </div>
            </div>
          </div>
          <div class="winnerlist Chandigarh" id="Chandigarh1">
            <div class="winner1">
              <div class="winnerImg btmPad"><img src="images/harjot_sidhu.jpg" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner">
                <p> <span>Name : </span> <span class="splColour">Harjot Sidhu</span></p>
                <p> <span> Profession  : </span><span class="splColour">Owner of Go Adventure Sports and Kotia Infrastructure</span></p>
                <p> <span> Location : </span><span class="splColour">Panchkula, Chandigarh</span></p>
                <p> <span> Quote : </span><span class="rtInfo">The best surprise of my life (after my wife though). Vipin is the guy who told me about it and put my name.</span></p>
              </div>
            </div>
            <div class="winner1">
              <div class="winnerImg btmPad"><img src="images/Vaneet.jpg" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner">
                <p> <span>Name : </span> <span class="splColour">Dr.Vaneet Jishtu</span></p>
                <p> <span> Profession  : </span><span class="splColour">Scientist-NWFP-Himalayan Forest Research Institute</span></p>
                <p> <span> Location : </span><span class="splColour">Panthaghati, Shimla</span></p>
                <p> <span> Quote : </span><span class="rtInfo">Very good lights for ambiance, rally very excited after winning the prize.</span></p>
              </div>
            </div>
          </div>
          <div class="winnerlist Hyderabad">
            <div class="winner2">
              <div class="winnerImg btmPad"><img src="images/mrSubhash.jpg" align="left" class="btmPad"/><br />
                <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
              <div class="details_winner">
                <p> <span>Name : </span> <span class="splColour">Mr D Subhash</span></p>
                <p> <span> Designation : </span><span class="splColour">Editor and Film (Eenadu) </span></p>
                <p> <span> Location : </span><span class="splColour">Dilshuknagar</span></p>
                <p> <span> Quote : </span><span class="rtInfo"> Fully Satisfied, Very happy to win</span></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer">
    <div class="page_wrapper">
      <p>&copy; 2014 Usha International Ltd. All Rights Reserved.</p>
      <ul>
        <!--<li><a href="javascript:;">FAQ's</a></li>-->
        <li><a href="terms-conditions.html">Terms of use</a></li>
        <!--<li><a href="javascript:;">Customer care</a></li>-->
        <li class="last"><a href="privacy-policy.html">Privacy policy</a></li>
      </ul>
    </div>
  </div>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50085676-2', 'lifebytisva.com');
  ga('send', 'pageview');
</script>
</body>
</html>
