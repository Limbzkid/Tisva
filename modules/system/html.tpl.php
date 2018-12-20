<?php

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 *
 * @ingroup themeable
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0 Transitional//EN" 
"http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>

<head profile="<?php print $grddl_profile; ?>">
	<meta name="google-site-verification" content="tL3gTuA7SF_-PoAxpaO4H9WQupS03v9ubIelxMf7c64" />
	<?php
	$qryStr = $_GET['q'];
	$metdes='';
	$metkey='';
	$pagetitle='';
	if($qryStr=="node")
	{
		$result1=db_query("SELECT meta_description_metatags_quick FROM field_revision_meta_description WHERE entity_type='taxonomy_term' and entity_id='54'");
		$metdes = $result1->fetchField(0);
		$result2=db_query("SELECT meta_keywords_metatags_quick FROM field_revision_meta_keywords  WHERE entity_type='taxonomy_term' and entity_id='54'");
		$metkey = $result2->fetchField(0);
		$result3=db_query("SELECT meta_meta_title_metatags_quick FROM field_revision_meta_meta_title WHERE entity_type='taxonomy_term' and entity_id='54'");
		$pagetitle = $result3->fetchField(0);
	}
	elseif(strstr($qryStr,"taxonomy/term/"))
	{
		$url = str_replace('taxonomy/term/','',$qryStr);
		$result1=db_query("SELECT meta_description_metatags_quick FROM field_revision_meta_description WHERE entity_type='taxonomy_term' and entity_id='".$url."'");
		$metdes = $result1->fetchField(0);
		$result2=db_query("SELECT meta_keywords_metatags_quick FROM field_revision_meta_keywords  WHERE entity_type='taxonomy_term' and entity_id=:nid",array( ':nid' => $url,));
		$metkey = $result2->fetchField(0);
		$result3=db_query("SELECT meta_meta_title_metatags_quick FROM field_revision_meta_meta_title WHERE entity_type='taxonomy_term' and entity_id=:nid",array( ':nid' => $url,));
		$pagetitle = $result3->fetchField(0);
	}
	elseif(strstr($qryStr,"node/"))
	{
		$url = str_replace('node/','',$qryStr);
		$result1=db_query("SELECT meta_description_metatags_quick FROM field_revision_meta_description WHERE entity_type='node' and entity_id='".$url."'");
		$metdes = $result1->fetchField(0);
		$result2=db_query("SELECT meta_keywords_metatags_quick FROM field_revision_meta_keywords  WHERE entity_type='node' and entity_id=:nid",array( ':nid' => $url,));
		$metkey = $result2->fetchField(0);
		$result3=db_query("SELECT meta_meta_title_metatags_quick FROM field_revision_meta_meta_title WHERE entity_type='node' and entity_id=:nid",array( ':nid' => $url,));
		$pagetitle = $result3->fetchField(0);
	}
	//elseif($qryStr=="storelocater")
	elseif(strstr($qryStr,"storelocater"))
	{
		
		$result1=db_query("SELECT meta_description_metatags_quick FROM field_revision_meta_description WHERE entity_type='taxonomy_term' and entity_id='56'");
		$metdes = $result1->fetchField(0);
		$result2=db_query("SELECT meta_keywords_metatags_quick FROM field_revision_meta_keywords  WHERE entity_type='taxonomy_term' and entity_id='56'");
		$metkey = $result2->fetchField(0);
		$result3=db_query("SELECT meta_meta_title_metatags_quick FROM field_revision_meta_meta_title WHERE entity_type='taxonomy_term' and entity_id='56'");
		$pagetitle = $result3->fetchField(0);
	}
	/*elseif($qryStr=="storelocater")
	{
		
	}
	elseif(strstr($qryStr,"storelocater/"))
	{
		$url = str_replace('storelocater/','',$qryStr);
		print $state =arg(1);
		print $city =arg(2);
		$sid =0;
		$cid =0;
		if(!empty($state))
		{
			$sid_ = taxonomy_get_term_by_name($state);
			if(!empty($sid_))
			{
				foreach ($sid_ as $term)
					$sid =  $term->tid;
			}
		}
		if(!empty($city))
		{
			$cid_ = taxonomy_get_term_by_name($city);
			if(!empty($cid_))
			{
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
			
			if($sid >0 && $cid==0)
			{
				//print $nodes['0']['field_state']['und']['0']['tid'];
				//print "<pre>";print_r($nodes);print "</pre>";
			}
			
			//print $nodes['0']->vid;
			
		$result1=db_query("SELECT meta_description_metatags_quick FROM field_revision_meta_description WHERE entity_type='node' and entity_id='".$url."'");
		$metdes = $result1->fetchField(0);
		$result2=db_query("SELECT meta_keywords_metatags_quick FROM field_revision_meta_keywords  WHERE entity_type='node' and entity_id=:nid",array( ':nid' => $url,));
		$metkey = $result2->fetchField(0);
		$result3=db_query("SELECT meta_meta_title_metatags_quick FROM field_revision_meta_meta_title WHERE entity_type='node' and entity_id=:nid",array( ':nid' => $url,));
		$pagetitle = $result3->fetchField(0);
	}*/
   

	if($metdes!='')
	{
	?>
	<meta name="Description" content="<?php print $metdes;?>" />
	<?php
	echo "\n";
	}
	if($metkey!='')
	{
	?>
	<meta name='Keywords' content="<?php print $metkey;?>" />
	
	<?php
	echo "\n";
    }
?>

  <?php print $head; ?>
  <?php if($pagetitle!='') { ?>
	<title><?php print $pagetitle; ?></title>
<?php } else { ?>
  <title><?php print str_replace('locater','locator',$head_title); ?></title>
  <?php } ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <?php print $styles; ?>
  <?php print $scripts; ?>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
			<script>
				$(document).ready(function() {
					function showPosition(position) {
						var lat = position.coords.latitude;
						var lng = position.coords.longitude;
						//alert(lat +' '+ lng);
						geocoder = new google.maps.Geocoder();
						var latlng = new google.maps.LatLng(lat, lng);
						geocoder.geocode({'latLng': latlng}, function(results, status) {
							//console.log(results);
							if (status == google.maps.GeocoderStatus.OK) {
								if (results) {
									console.log(results);
									var form_addr = results[0]['formatted_address'];
									console.log(form_addr);
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
							} else {
								alert("Geolocation failed.");
							}
						});
					}
					if(navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(showPosition);
					} else {
						alert("Geolocation is not supported by this browser.");
					}
				});
			</script>
</head>

<?php
	$isMobile = (bool)preg_match('#\b(ip(hone|od)|android\b.+\bmobile|opera m(ob|in)i|windows (phone|ce)|blackberry'.
                    '|s(ymbian|eries60|amsung)|p(alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.
                    '|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );
			if($isMobile) header('Location: http://m.lightsbytisva.com'.$_SERVER['REQUEST_URI']);
		 ?>
<?php
	//$isMobile = (bool)preg_match('#\b(ip(hone|od|ad)|android|opera m(ob|in)i|windows (phone|ce)|blackberry|tablet'.'|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.'|mobile|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );
	//if($isMobile) header('Location: http://m.lightsbytisva.com'.$_SERVER['REQUEST_URI']);
?>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
</html>