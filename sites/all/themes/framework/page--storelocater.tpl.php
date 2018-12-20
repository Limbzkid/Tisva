<?php global $base_url; ?>
<?php 
	$state =arg(1);
	$city =arg(2);
	$sid =0;
	$cid =0;
	if(empty($city)) {
		$city = $_SESSION['strCity'];
		//$store_city = '';
	} else {
		//$store_city = $city;
	}
	if(empty($state)) {
		$state = $_SESSION['strState'];
	}
	
	if(!empty($state)) {
		$sid_ = taxonomy_get_term_by_name($state);
		if(!empty($sid_)) {
			foreach ($sid_ as $term)
				$sid =  $term->tid;
		}
	}
	if(!empty($city)) {
		$cid_ = taxonomy_get_term_by_name($city);
		if(!empty($cid_)) {
			foreach ($cid_ as $term)
				$cid =  $term->tid;	
		}
	}
	
	$query = new EntityFieldQuery();
	$query->entityCondition('entity_type', 'node');
	$query->entityCondition('bundle', 'storelocation');
	if($sid > 0) $query->fieldCondition('field_state','tid',$sid,"=");
	if($cid > 0) $query->fieldCondition('field_city','tid',$cid,"=");
	$result = $query->execute();
	$nodes = array_values(node_load_multiple(array_keys($result['node'])));
	//echo "nodes----------------";
	//echo '<pre>';
	
	//print_r($nodes);
	//echo '</pre>';
	$address = "";
	if(!empty($nodes)) {
		foreach($nodes as $node) {
			$address[] = array("DisplayText"=>($node->body["und"][0]["value"]),"LatitudeLongitude"=>$node->field_location_map["und"][0]["lat"].",".$node->field_location_map["und"][0]["lng"]);//
		}

	}
	
	$address =  json_encode($address);
?>
<div class="pageWrapper">
  <div class="header">
		<div class="logo">
			<a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" id="logo">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
		</div>
		<ul class="rhsLinks">
			<li class="searchBtn"><a href="javascript:;"><span>Search</span></a></li>
			<li class="locator"><a href="<?php echo base_path(); ?>store-locator"><span>Store Locator</span></a></li>
			<li class="menuBtn"><a href="javascript:;"><span>Explore</span></a></li>
		</ul>
	</div>  <!-- header-->
	<div class="searchWrapper">
		<form accept-charset="UTF-8" id="search-form" method="post" action="<?php print $base_url; ?>/search/node" class="search-form">
			<div class="inputWrap">
				<input type="text" class="form-text" maxlength="255" value="Search" onblur="clearText(this)" onfocus="clearText(this)" name="keys" id="edit-keys">
				<input type="hidden" value="search_form" name="form_id">
			</div>
			<input type="submit" class="link_btn btnGO" value="Go" name="op" id="edit-submit">
		</form>
		<!--<input name="" type="text" onblur="clearText(this)" onfocus="clearText(this)" value="Search"></div>
		<input name="" type="button" value="GO" class="btnGO">-->
	</div>  <!-- searchWrapper -->
	<div class="navWrapper">
		<div class="scroller">
			<ul>
				<li class="mainLink"><a href="javascript:;"><span>PRODUCT RANGE</span></a>
					<ul class="subLink"><?php print product_catalogs(); ?></ul>
				</li>
				<li class="mainLink"><a href="javascript:;"><span>SPACES</span></a>
					<ul class="subLink"><?php print spaces_catalog(); ?></ul>
				</li>
				<li><a href="http://tisvailluminology.blogspot.in/" target="_blank"><span>ILLUMINOLOGY</span></a></li>
				<li><a href="<?php print $base_url; ?>/contact-us"><span>CONTACT US</span></a></li>
				<li><a href="<?php print $base_url; ?>/store-locator"><span>STORE LOCATOR</span></a></li>
				<li><a href="<?php print $base_url; ?>/about-us"><span>ABOUT US</span></a></li>
			</ul>
		</div>
	</div>   <!-- navWrapper -->
	<div class="wrapper">
		<div class="storeLocatorWrap">
			<div class="locatorForm">
				<h1>Store Locator</h1>
					<form id="locater" name="locater" method="post" action="<?php echo $base_url?>/storelocater" >
						<div class="selectBox">
							<div class="selectedvalue box" id="box"><?php echo empty($state)?"Select State":$state;?></div>
							<select name="state" id="state" onchange="get_state();">
								<option value="" class="primero">Select State</option>
								<?php 
									$pid="";
									$vid = taxonomy_vocabulary_machine_name_load("store_location")->vid;
									$terms = taxonomy_get_tree($vid,$parent=0, $max_depth=1);
									$selected ="";
									foreach($terms as $term){
										$selected = ""; 
										if($state == $term->name) { 
											$pid  = $term->tid ; 
											$selected = "selected='selected'"; 
										}
									?>
									<option value="<?php echo $term->name?>" <?php echo $selected?>><?php echo $term->name?></option>
									<?php } ?>
									<input type="hidden" name="curLoc" id="curLoc" />
							</select>
						</div>
						<div class="selectBox">
							<div class="selectedvalue box" id="box"><?php echo empty($city)?"Select City":$city;?></div>
							<select name="city" id="city" onchange="get_data()">
								<option value="" class="primero">Select City</option>
								 <?php 
									$terms = taxonomy_get_tree($vid,$parent=$pid, $max_depth=2);
									$selected = "";
									foreach($terms as $term){
										$selected = "";
									if($city == $term->name) { 
										$selected = "selected='selected'"; 
									}
								?>
									<option value="<?php echo $term->name?>" <?php echo $selected?> ><?php echo $term->name?> </option>
								<?php } ?>
							</select>
						</div>
					</form> 
			</div>
			<ul class="locatorAddress">
				<?php foreach ($nodes as $nd): ?>
					<li>
						<span class="iconLocator" rel="<?php print $nd->field_location_map["und"][0]["lat"]; ?>-<?php print $nd->field_location_map["und"][0]["lng"]; ?>"></span>
						<p class="ttl"><?php echo $nd->title;?></p>
						<p class="add"><?php echo $nd->body["und"][0]["value"];?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div> <!-- wrapper -->
  <div class="footerWrap">
		<div class="footer"> 
			<ul class="downloadLinks">
				<li><a href="<?php print $base_url; ?>/downloadBrochureMrp.php?file=<?php print home_pdf_download(); ?>">Brochure</a></li>
				<li><a href="<?php print $base_url; ?>/downloadBrochureMrp.php?file=<?php print home_mrp_download(); ?>">Price List</a></li>
			</ul>
			<a href="javascript:;" class="downloadBtn">Downloads</a>
			<p class="callUs"><span>Call us on</span> 1800 103 3222</p>
		</div>
	</div>  <!-- footerWrap -->
	<div class="wrapperOverlay"></div>
	<a href="javascript:;" class="footerArrow"></a>
	<div class="fixBandWrap">
		<div class="fixBand">
			<a href="javascript:;" class="footerArrowDown"></a>
			<p>&copy <?php print date('Y'); ?> Usha International Ltd.<br>All Rights Reserved.</p>
			<ul>
				<li><a href="<?php print $base_url; ?>/privacy-policy">Privacy policy</a></li>
				<li><a href="<?php print $base_url; ?>/sitemap">Sitemap</a></li>
				<li><a href="<?php print $base_url; ?>/terms-of-use">Terms of use</a></li>
			</ul>
		</div>
	</div>
</div> <!-- pageWrapper -->

<script>
	function get_state() {
		document.getElementById("city").value = "";
		state = document.getElementById("state").value;
		document.getElementById("locater").action = '<?php echo $base_url?>' + "/storelocater/" + state;
		document.getElementById('locater').submit();
	}
	function get_data() {
		state = document.getElementById("state").value;
		city = document.getElementById("city").value;
		if(city=="") {
			document.getElementById("locater").action = '<?php echo $base_url?>' + "/storelocater/" + state;
		} else {
			document.getElementById("locater").action = '<?php echo $base_url?>' + "/storelocater/" + state + "/" + city ;
		}	
		document.getElementById('locater').submit();
	}
</script>


<script type="text/javascript">
	var map;
	var geocoder;
	var marker;
	var people = new Array();
	var latlng;
	var infowindow;
	$(document).ready(function() {
		
		
		
		
		ViewCustInGoogleMap();
	});
	function ViewCustInGoogleMap() {
		var mapOptions = {
			center: new google.maps.LatLng(11.0168445, 76.9558321),   // Coimbatore = (11.0168445, 76.9558321)
			zoom: 7,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		// Get data from database. It should be like below format or you can alter it.
		//var data = '[{ "DisplayText": "Jamiya Nagar Kovaipudur Coimbatore-641042", "ADDRESS": "Jamiya Nagar Kovaipudur Coimbatore-641042", "LatitudeLongitude": "10.9435131,76.9383790", "MarkerId": "Customer" },{ "DisplayText": "Coimbatore-641042", "ADDRESS": "Coimbatore-641042", "LatitudeLongitude": "11.0168445,76.9558321", "MarkerId": "Customer"}]';
		var data = '<?php echo($address);?>';
		//people = JSON.parse(data); 
		people = jQuery.parseJSON(data);
		for (var i = 0; i < people.length; i++) {
			setMarker(people[i]);
		}
	}

	function setMarker(people) {
		geocoder = new google.maps.Geocoder();
		infowindow = new google.maps.InfoWindow();
		if ((people["LatitudeLongitude"] == null) || (people["LatitudeLongitude"] == 'null') || (people["LatitudeLongitude"] == '')) {
			geocoder.geocode({ 'address': people["Address"] }, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					latlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
					marker = new google.maps.Marker({
						position: latlng,
						map: map,
						draggable: false,
						html: people["DisplayText"],
						icon: "images/marker/" + people["MarkerId"] + ".png"
					});
					//marker.setPosition(latlng);
					//map.setCenter(latlng);
					google.maps.event.addListener(marker, 'click', function(event) {
						infowindow.setContent(this.html);
						infowindow.setPosition(event.latLng);
						infowindow.open(map, this);
					});
				} else {
					alert(people["DisplayText"] + " -- " + people["Address"] + ". This address couldn't be found");
				}
			});
		} else {
			var latlngStr = people["LatitudeLongitude"].split(",");
			var lat = parseFloat(latlngStr[0]);
			var lng = parseFloat(latlngStr[1]);
			latlng = new google.maps.LatLng(lat, lng);
			marker = new google.maps.Marker({
				position: latlng,
				map: map,
				draggable: false,               // cant drag it
				html: people["DisplayText"]    // Content display on marker click
				//icon: "images/marker.png"       // Give ur own image
			});
			marker.setPosition(latlng);
			map.setCenter(latlng);
			google.maps.event.addListener(marker, 'click', function(event) {
				infowindow.setContent(this.html);
				infowindow.setPosition(event.latLng);
				infowindow.open(map, this);
			});
		}
	}

</script>