<script src="http://code.jquyupery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA7IZt-36CgqSGDFK8pChUdQXFyKIhpMBY&sensor=true" type="text/javascript"></script>
<?php global $base_url; ?>
<div class="store">
<div class="portrait_overlay">
	<img src="<?php echo base_path().path_to_theme(); ?>/images/rotate.jpeg" alt="Please rotate your device" title="Please rotate your device" />
</div>

<div class="wrapper">
	<?php include 'includes/header.inc';?>
	<div class="content">
    <div class="page_wrapper">
			<div class="lt_cont">
				<?php
					//echo 'SESS: '. $_SESSION['strCity'] .' -- '.$_SESSION['strState'];
					$state =arg(1);
					$city =arg(2);
					$sid =0;
					$cid =0;
					if(empty($state)) {
						$state = $_SESSION['strState'];
						//$store_state = '';
					} else {
						//$store_state = $state;
					}
					
					if(empty($city)) {
						$city = $_SESSION['strCity'];
						//$store_city = '';
					} else {
						//$store_city = $city;
					}
					if(!empty($state))	{
						$sid_ = taxonomy_get_term_by_name($state);
						if(!empty($sid_))	{
							foreach ($sid_ as $term)
								$sid =  $term->tid;
						}
					} 
					if(!empty($city))	{
						$cid_ = taxonomy_get_term_by_name($city);
						if(!empty($cid_))	{
							foreach ($cid_ as $term)
								$cid =  $term->tid;
						}
					} 
					$query = new EntityFieldQuery();
					$query->entityCondition('entity_type', 'node');
					$query->entityCondition('bundle', 'storelocation');
					if($sid >0)
					$query->fieldCondition('field_state','tid',$sid,"=");
					if($cid >0)
					$query->fieldCondition('field_city','tid',$cid,"=");
					$result = $query->execute();
					$nodes = array_values(node_load_multiple(array_keys($result['node'])));
					//echo "nodes----------------";
					//print_r($nodes);
  		    $address = "";
  		    
					if(!empty($nodes))	{
				foreach($nodes as $node) {
					$address[] = array("DisplayText"=>($node->body["und"][0]["value"]),"LatitudeLongitude"=>$node->field_location_map["und"][0]["lat"].",".$node->field_location_map["und"][0]["lng"]);//
				}
  			}
  			$address =  json_encode($address);
	?>
	<div id="map-canvas" style="width: 454px; height: 450px;"></div>
		
	        <?php //print render($page['content_right']);?>
<!--
	<iframe  style="background-color:#FFFFFF;border:0" width="454"  height="450" frameborder="0" 

src="https://www.google.com/maps/embed/v1/search?key=AIzaSyCNh3E6POs-QzXnLJH8Td_FjX1hBLJZUgo&q=<?php // echo $location?>&zoom=12">
</iframe>-->

    </div>
      <div class="rt_cont">
      	<h1>Store Locator</h1>
        
        <form id="locater" name="locater" method="post" action="<?php echo $base_url?>/storelocater" >
        <div class="selectBox">
		<div class="box" id="box"><?php echo empty($state)?"Select State":$state;?></div>
		<!-- this.parentNode.getElementsByTagName('div')[0].innerHTML=this.options[this.selectedIndex].text -->
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
			<?php
			}
		 ?>
		 </select>
		 </div>
		<div class="selectBox">
			<div class="box" id="box"><?php echo empty($city)?"Select City":$city;?></div>
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
				<?php
				}
				 ?>
			</select>
		</div>
		</form> 
		

<script>
function get_state()
{
	document.getElementById("city").value = "";
	state = document.getElementById("state").value;
	document.getElementById("locater").action = '<?php echo $base_url?>' + "/storelocater/" + state;
	document.getElementById('locater').submit();
}
function get_data()
{
	state = document.getElementById("state").value;
	city = document.getElementById("city").value;
	if(city=="")
	{
		document.getElementById("locater").action = '<?php echo $base_url?>' + "/storelocater/" + state;
	}
	else
	{
		document.getElementById("locater").action = '<?php echo $base_url?>' + "/storelocater/" + state + "/" + city ;
	}	
	document.getElementById('locater').submit();
}
</script>
		<?php
			$index = 1; 
			foreach ($nodes as $nd){
				
		?>
		<div class="rt_cont_box <?php echo $index%2!=0 ? 'first':''?>"  >
        	<p class="ttl"><?php echo $nd->title;?></p>
            <p class="add"><?php echo $nd->body["und"][0]["value"];?></p>
        </div>
        <?php $index++ ;
			}?>
        <?php //print render($page['content']);?>
    </div>
  </div>
</div>
<?php include 'includes/footer.inc';?> 
 </div>
 </div>
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
function ViewCustInGoogleMap() 
{
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
	}
	else {
	alert(people["DisplayText"] + " -- " + people["Address"] + ". This address couldn't be found");
	}
	});
	}
	else {
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
	  


