<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Tisva Mobile</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name = "viewport" content="width=device-width, minimum-scale=1, maximum-scale=1"/>
    <?php //print $head; ?>
    <?php //print $styles; ?>
    <?php //print $scripts; ?> 
    <link type="text/css" rel="stylesheet" href="<?php echo base_path(); ?>sites/all/themes/framework/css/style.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_path(); ?>sites/all/themes/framework/css/owl.carousel.css"  />
    <link type="text/css" rel="stylesheet" href="<?php echo base_path(); ?>sites/all/themes/framework/css/media.css">
    <script type="text/javascript" src="<?php echo base_path(); ?>sites/all/themes/framework/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_path(); ?>sites/all/themes/framework/js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="<?php echo base_path(); ?>sites/all/themes/framework/js/responsive-tables.js"></script>
    <script type="text/javascript" src="<?php echo base_path(); ?>sites/all/themes/framework/js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="<?php echo base_path(); ?>sites/all/themes/framework/js/common.js"></script>
    <script type="text/javascript" src="<?php echo base_path(); ?>sites/all/themes/framework/js/homebanner.js"></script>
    <script type="text/javascript" src="<?php echo base_path(); ?>sites/all/themes/framework/js/custom.js"></script>
		<?php if(arg(0) == 'feedback'): ?>
			<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'framework') ?>/js/custom-form-elements.js"></script>
			<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'framework') ?>/js/jquery.validate.js"></script>
			<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'framework') ?>/js/additional-methods.js"></script>
		<?php endif; ?>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
		<script>
			function showPosition(position) {
				//alert("i am in");
				var lat = position.coords.latitude;
				var lng = position.coords.longitude;
				//alert(lat +' '+ lng);
				geocoder = new google.maps.Geocoder();
				var latlng = new google.maps.LatLng(lat, lng);
				geocoder.geocode({'latLng': latlng}, function(results, status) {
					//console.log(results);
					if (status == google.maps.GeocoderStatus.OK) {
						if (results) {
							var form_addr = results[0]['formatted_address'];
							var addr_arr = form_addr.split(',');
							var arrLength = addr_arr.length;
							var state = addr_arr[arrLength-2].trim();
							//alert(state);
							state = state.split(' ')[0];
							//console.log(state);
							var city = addr_arr[arrLength-3];
							//alert('city:' + city);
							//alert('state:' +state);
							$.ajax({
								type: 'POST',
								data: {city: city, state: state},
								url: '/locateCity',
								success: function(data) {
									
								}
							});
						}
					}
				});
			}
			if(navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			} else {
				alert("Geolocation is not supported by this browser.");
			}
		</script>
  </head>

  <body class="<?php print $classes; ?>" <?php print $attributes;?>>
    <div class="rotation" id="rotation"><img alt="" src="<?php echo base_path(); ?>sites/all/themes/framework/images/rotateIcon.png" id="rotateIcon"></div>
    <div class="container"> 
      <?php //print $page_top; ?>
      <?php print $page; ?>
      <?php //print $page_bottom; ?>
    </div>
    <?php //echo 'AAAAA: '. $node->type; ?>
    <div class="prdctImgLightBox"> <a href="javascript:;" class="closeBtn"></a><div class="imgBox"></div></div>
		<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-50085676-11', 'auto');
      ga('send', 'pageview');
    </script>
		<?php if(drupal_is_front_page()): ?><div class="feedback"><a href="<?php echo base_path(); ?>feedback"><img src="<?php echo base_path(); ?>sites/all/themes/framework/images/feedback.png" alt=""></a></div><?php endif; ?>
  </body>

</html>