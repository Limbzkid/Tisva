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
<!--<script type="text/javascript" src="js/pro_details.js"></script>-->
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
					url: base_url + '/getWinnerDetails.php',
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
	<div class="wrapper bgnone wrapper" >
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
				<div class="title_container">
					<p class="winner_title">Lucky Winners</p>
					<p class="detail">Is luck going your way today? It is time to find out if you are one of the few to walk away with the grand prize! </p>
					<p class="winner_title splcolor">Congratulation to winners of October 2014! </p>
					<div class="winnerlist">
          <div class="winner1">
            <div class="winnerImg btmPad"><img src="images/winner1_delhi.png" align="left" class="btmPad"/><br />
              <a href="javascript:;" class="fbShare"><img src="images/fbshare.png" align="left" /></a></div>
            <div class="details_winner">
              <p> <span>Name : </span> <span class="splColour name">Dr Ritika</span></p>
              <p> <span> Designation : </span><span class="splColour design">Doctor, Guruteg bhadur hospital </span></p>
              <p> <span> Location : </span><span class="splColour loc">Naraina Vihar</span></p>
              <p> <span> Quote : </span><span class="rtInfo quote">Excellent experience. Excellent Collection & Excellent service.</span></p>
            </div>
          </div>
          <div class="winner1">
            <div class="winnerImg btmPad"><img src="images/winner2_delhi.png" align="left" class="btmPad"/><br />
              <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
            <div class="details_winner">
              <p> <span>Name : </span><span class="splColour name"> Mrs Rashmi Gupta</span></p>
              <p> <span> Profession : </span><span class="splColour design">Housewife</span></p>
              <p> <span> Location : </span><span class="splColour loc">Golf Course Road, Gurgaon </span></p>
              <p> <span> Quote : </span><span class="rtInfo quote">I am absolutely delighted winning this lucky draw. Saw many fraud ones, but this one is awesome. I have huge respect for this brand/store. Thanks a ton.</span></p>
            </div>
          </div>
          <div class="winner1">
            <div class="winnerImg btmPad"><img src="images/winner3_delhi.png" align="left" class="btmPad"/><br />
              <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"   align="left" /></a></div>
            <div class="details_winner">
              <p> <span>Name : </span><span class="splColour name"> Mr RC Bhargava</span></p>
              <p> <span> Designation : </span><span class="splColour design">Chairman, Maruti Suzuki</span> </p>
              <p> <span> Location : </span><span class="splColour loc">Noida</span></p>
              <p> <span> Quote : </span><span class="rtInfo quote">Winning the lucky draw prize was unbelievable. I had never won any prize this earlier. The lights we bought were just what we wanted and we are very happy with them.</span></p>
            </div>
          </div>
          <div class="winner1">
            <div class="winnerImg btmPad"><img src="images/winner4_delhi.png" align="left" class="btmPad"/><br />
              <a href="javascript:;" class="fbShare"><img src="images/fbshare.png"  align="left" /></a></div>
            <div class="details_winner">
              <p> <span>Name : </span><span class="splColour name"> Mr Vikas Bajaj</span></p>
              <p> <span> Designation : </span><span class="splColour design">Banker, DCB  </span></p>
              <p> <span> Location : </span><span class="splColour loc">Gurgaon </span></p>
              <p> <span> Quote : </span><span class="rtInfo quote">Wonderful experience and couldn't believe that I have won the lucky draw. Thanks a lot.</span></p>
            </div>
          </div>
          <div class="clear"></div>
          <!--<p class="detail wishes">Congratulations to this month's winners! We have your details and will get in touch with you shortly.</p>-->
		 <p class="detail wishes">If you weren't, don't worry. Visit our store, purchase any of our products  and you stand a chance  to take home 1 lakh worth of Tisva lights.<br />
<span>Best of luck! </span>
</p>
					<p>&nbsp;</p>
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
