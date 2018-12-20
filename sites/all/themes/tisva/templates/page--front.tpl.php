<?php
global $base_url;
//echo "base url is" . $base_url;
//ini_set('display_errors', 'On');// enable or disable public display of errors (use 'On' or 'Off')
session_start();

/**
 * [removeEverythingFromSession description]
 * @param  [SESSION Array] $session [passing SESSION Array into this function and unsetting everything after succesful data operation]
 * @return [none]          [description]
 */
function removeEverythingFromSession($session) {
	foreach ($session as $key => $value) {
		unset($_SESSION[$key]);
	}
}
function generateSecurityString() {
	$randomString = random_string(50);
	$currTimestamp = time();
	$timestamp = md5($currTimestamp . $randomString);
	/*if ($_SESSION['times'] == "" || !isset($_SESSION["times"])) {
	$_SESSION['times'] = $timestamp;
	}*/
	if (!isset($_SESSION["times"])) {
		$_SESSION['times'] = $timestamp;
	} else if ($_SESSION['times'] == "") {
		$_SESSION['times'] = $timestamp;
	}
	return $_SESSION['times'];
}

/**
 * [random_string Random key of alphabates and numericals as per length specifies]
 * @return [string] [Random alphanumeric key]
 */
function random_string($length) {
	$key = '';
	$keys = array_merge(range(0, 9), range('a', 'z'));

	for ($i = 0; $i < $length; $i++) {
		$key .= $keys[array_rand($keys)];
	}

	return $key;
}

$salt = 'kisva';

$myRandomString = random_string(32);

function simple_encrypt($text) {
	global $salt;
	return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($salt), $text, MCRYPT_MODE_CBC, md5(md5($salt)))));
}

$encryptedString = simple_encrypt($myRandomString);

$_SESSION["user_name"] = "";
$_SESSION["user_email"] = "";
$_SESSION["user_suggestion"] = "";
$_SESSION["times"] = "abc";
$_SESSION["messages"] = "";
//print_r($_SESSION);
removeEverythingFromSession($_SESSION);
$securityCode = generateSecurityString();
//print_r($_SESSION);
?>
<?php
//home page top 5 slider images
$query = new EntityFieldQuery();
$query->entityCondition('entity_type', 'node');
$query->entityCondition('bundle', 'product');
$query->fieldCondition('field_show_on_homepage', 'value', 1, "=");
//$query->propertyOrderBy('changed','desc');
$query->fieldOrderBy('field_order', 'value', 'ASC');
$query->pager(5);
$result = $query->execute();
$home_main_products = node_load_multiple(array_keys($result['node']));
$background_array = array();
$title_array = array();

$image_array = array();
$info_array = array();
$short_title_array = array();
$spaces_array = array();
$feature_array = array();
$color_array = array();
$space_index = 0;
foreach ($home_main_products as $product) {
	$title_array[] = $product->title;
	$short_title_array[] = $product->field_short_title[und][0][value];
	$image_array[] = $product->field_homepagesliderimage[und][0][uri];

	$info_array[] = $product->body[und][0][value];
	$background_array[] = $product->field_navigation_image[und][0][uri];

	$spaces = $product->field_spaces_applicable[und];
	foreach ($spaces as $space) {
		$space_tid = $space[tid];
		if ($space_tid != "") {
			$term = taxonomy_term_load($space_tid);
			if ($image_items = field_get_items('taxonomy_term', $term, 'field_icon')) {
				$uri = $image_items[0]['uri'];
				$external_url = file_create_url($uri);
			}
			$spaces_array[$space_index][] = $term->name;
		}
	}
	$feature_array[] = $product->field_features[und][0][value];
	$color_array[] = $product->field_color[und][0][value];
	$space_index++;
}
?>
<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>
<div class="portrait_overlay">
	<img src="<?php echo base_path() . path_to_theme();?>/images/rotate.jpeg" alt="Please rotate your device" title="Please rotate your device" />
</div>

<div class="wrapper">
<div class="wrapper">
<div class="product_wrapper">
<?php
$i = 0;
$cntBgHmPg = 1;
//print_r($background_array);
//echo image_style_url("uc_product_full",$background)
foreach ($background_array as $background) {
	$styleForProdBgImg = "";
	if ($background != "") {
		$bgPr = image_style_url('uc_product_full', $background);

		$styleForProdBgImg = "background-image:url('" . $bgPr . "')";
	}
	?>
	<div class="product<?php print $cntBgHmPg;?>" style="<?php print $styleForProdBgImg;?>"></div>
<?php $cntBgHmPg++;}?>
   <!-- <div class="product1" style="<?php //print $styleForProdBgImg;?>"></div>
    <div class="product2" style="<?php //print $styleForProdBgImg;?>"></div>
    <div class="product3" style="<?php //print $styleForProdBgImg;?>"></div>
    <div class="product4" style="<?php //print $styleForProdBgImg;?>"></div>
    <div class="product5" style="<?php //print $styleForProdBgImg;?>"></div>-->

</div>

  <!-- <div class="header">
    <div class="page_wrapper">    </div>
  </div>-->
  <!--<div class="content banner_content">-->
  <div class="content">
    <div class="page_wrapper">
      <div class="lhs" class="TISVALogo" itemscope itemtype="http://schema.org/Organization">
				<a itemprop="url" href="/" class="logo" title="Lights by TISVA">
					<img src="<?php print $logo;?>" alt="Lights by TISVA - LED & Designer Home" title="Lights by TISVA - Decorative Lights for Home" />
				</a>
        <ul class="lhs_nav">
<?php
$vid = taxonomy_vocabulary_machine_name_load("categories")->vid;
$terms = taxonomy_get_tree($vid, $parent = 0, $max_depth = 1);
foreach ($terms as $term) {
	echo '<li><span></span><a href="javascript:;">' . $term->name . '</a></li>';
}

?>
</ul>
<?php
$aaaa = taxonomy_vocabulary_machine_name_load("homepage_brochure_and_mrp")->vid;
$hbmrpid = taxonomy_get_tree($aaaa);

$a1 = db_query("SELECT field_brochure_image_fid FROM field_data_field_brochure_image WHERE entity_type='taxonomy_term' and bundle='homepage_brochure_and_mrp' and entity_id='" . $hbmrpid['0']->tid . "'");
$field_brochure_image_fid = $a1->fetchField(0);

$a11 = db_query("SELECT uri FROM file_managed WHERE fid='" . $field_brochure_image_fid . "'");
$brochure_image = file_create_url($a11->fetchField(0));

$b1 = db_query("SELECT field_brochure_pdf_fid FROM field_data_field_brochure_pdf WHERE entity_type='taxonomy_term' and bundle='homepage_brochure_and_mrp' and entity_id='" . $hbmrpid['0']->tid . "'");
$field_brochure_pdf_fid = $b1->fetchField(0);

$b11 = db_query("SELECT uri FROM file_managed WHERE fid='" . $field_brochure_pdf_fid . "'");
$brochure_pdf = file_create_url($b11->fetchField(0));
$expBroPdf = explode('/homepage/', $brochure_pdf);

$c1 = db_query("SELECT field_mrp_image_fid FROM field_data_field_mrp_image WHERE entity_type='taxonomy_term' and bundle='homepage_brochure_and_mrp' and entity_id='" . $hbmrpid['0']->tid . "'");
$field_mrp_image_fid = $c1->fetchField(0);

$c11 = db_query("SELECT uri FROM file_managed WHERE fid='" . $field_mrp_image_fid . "'");
$mrp_image = file_create_url($c11->fetchField(0));

$d1 = db_query("SELECT field_mrp_pdf_fid FROM field_data_field_mrp_pdf WHERE entity_type='taxonomy_term' and bundle='homepage_brochure_and_mrp' and entity_id='" . $hbmrpid['0']->tid . "'");
$field_mrp_pdf_fid = $d1->fetchField(0);

$d11 = db_query("SELECT uri FROM file_managed WHERE fid='" . $field_mrp_pdf_fid . "'");
$mrp_pdf = file_create_url($d11->fetchField(0));
$expMrpPdf = explode('/homepage/', $mrp_pdf);

?>

<?php

//echo "<a href='".$brochure_pdf."' target='_blank' class=' download_icon'><img src='".$brochure_image."' alt='' title=''/></a>";
//echo "<a href='http://".$_SERVER['HTTP_HOST']."/kripa/tisva/site/downloadBrochureMrp.php?file=".$expBroPdf[1]."' class=' download_icon'><img src='".$brochure_image."' alt='' title=''/></a>";

//echo "<a href='http://".$_SERVER['HTTP_HOST']."/kripa/tisva/site/downloadBrochureMrp.php?file=".$expMrpPdf[1]."' class=' download_icon'><img src='".$mrp_image."'  alt='' title=''/></a>";
echo "<a href='http://" . $_SERVER['HTTP_HOST'] . "/downloadBrochureMrp.php?file=" . $expBroPdf[1] . "' class=' download_icon' onclick=\"ga('send', 'event', 'PDF', 'Download Brochure');\"><img src='" . $brochure_image . "' alt='' title=''/></a>";

echo "<a href='http://" . $_SERVER['HTTP_HOST'] . "/downloadBrochureMrp.php?file=" . $expMrpPdf[1] . "' class=' download_icon' onclick=\"ga('send', 'event', 'PDF', 'Download Price List');\"><img src='" . $mrp_image . "'  alt='' title=''/></a>";

?>
</div>
      <div class="product_container">
<?php
foreach ($terms as $term) {
	$featured_products = array();

	$query = new EntityFieldQuery();
	$query->entityCondition('entity_type', 'node');
	$query->entityCondition('bundle', 'product');
	$query->fieldCondition('taxonomy_catalog', 'tid', $term->tid, "=");
	$query->fieldCondition('field_featured', 'value', 1, "=");
	$query->propertyCondition('status', 1);
	$query->propertyCondition('promote', 1);
	$query->propertyOrderBy('changed', 'desc');
	$query->pager(2);
	$result = $query->execute();
	$featured_products = node_load_multiple(array_keys($result['node']));

	$category_image = "";

	// get category image ---
	$catid = $term->tid; //$product->taxonomy_catalog[und][0][tid];

	$category = taxonomy_term_load($catid);
	if ($cat_image = field_get_items('taxonomy_term', $category, 'field_home_featured_banner')) {
		$uri = $cat_image[0]['uri'];
		$category_image = file_create_url($uri);
	}
	?>
	  <div class="product_info"> <?php if ($category_image != "") {?><img src="<?php echo $category_image?>" alt="" title="" /><?php }?>
<div class="pro_info_rhs"> <a href="javascript:;" class="close">Close</a>
		<h3><span></span>Featured Products</h3>
<?php

	if (!empty($featured_products)) {
		foreach ($featured_products as $product) {
			$title = $product->title;
			$pid = $product->nid;
			$info = $product->field_short_title[und][0][value];
			// changed it to featured
			$productimg = $product->field_featured_image[und][0][uri];
			$spaces = $product->field_spaces_applicable[und];

			$url = drupal_lookup_path('alias', 'node/' . $product->vid, '');

			if ($url == '') {
				$url = 'node/' . $product->vid;
			}

			?>
					 <div class="prod_box">
					  <div class="prod_thumb">
						<div class="prod_img"> <a href="<?php echo $base_url . '/' . $url;?>"><img src="<?php echo image_style_url("uc_product", $productimg)?>" height="110" title="" alt="">
						  <p class="p_thumb_title"><?php $explodeTitle = explode('-', $title);
			echo $explodeTitle[0];?></p></a>
						</div>
						<div class="prod_data">
						  <a href="<?php echo $base_url . '/' . $url;?>"><p class="info_data"><?php echo $info?></p>
						  <p class="p_thumb_title"><?php echo $explodeTitle[0];?></p></a>
						</div>
					  </div>
					  <ul>
<?php $cnt = 1;foreach ($spaces as $space) {

				?>
						  <li class="room<?php echo $cnt?>"></li>
<?php $cnt++;
			}
			?></ul>
           		 </div>
<?php
}
	}
	$viewAllProdurl = drupal_lookup_path('alias', 'taxonomy/term/' . $term->tid, '');

	if ($viewAllProdurl == '') {
		$viewAllProdurl = $term->name;
	} else {
		$viewAllProdurl = $viewAllProdurl;
	}

	?>
		 <a href="<?php echo $viewAllProdurl?>" class="prod_view">View all <?php echo $term->name;?></a> </div>
        </div>
<?php }// category loop ends ?></div>
      <div class="rhs_overlay"></div>
      <div class="rhs">
        <div class="header_right">










<?php
print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('class' => array('links', 'top_links'))));
?>
<p class="call_text">Call us on 1800 103 3222</p>
           <ul class="header_links">
            <li  class="products"><span></span><a href="javascript:;">Product Range</a>

             <ul>
<?php
foreach ($terms as $term) {
	$url = drupal_lookup_path('alias', 'taxonomy/term/' . $term->tid, '');

	if ($url == '') {
		echo '<li><span></span><a href="' . $base_url . "/" . $term->name . '">' . $term->name . '</a></li>';
	} else {
		echo '<li><span></span><a href="' . $base_url . "/" . $url . '">' . $term->name . '</a></li>';

	}
}

?>
</ul>
            </li>
           <!--updated on 10th april 2014 - start-->
            <li class="spaces"><span></span><a href="javascript:;">Spaces</a>
                <ul>
<?php
//rooms
$vid = taxonomy_vocabulary_machine_name_load("rooms")->vid;
$space_terms = taxonomy_get_tree($vid);
foreach ($space_terms as $spaceterm) {

	$class = strtolower(strtr($spaceterm->name, array(' ' => '_')));

	//echo '<li class="'.$class.'"><a href="'.$base_url."/".$spaceterm->name.'">'.$spaceterm->name.'</a></li>';
	$urlSpace = drupal_lookup_path('alias', 'taxonomy/term/' . $spaceterm->tid, '');

	if ($urlSpace == '') {
		echo '<li class="' . $class . '"><a href="' . $base_url . "/" . $spaceterm->name . '">' . $spaceterm->name . '</a></li>';
	} else {
		echo '<li class="' . $class . '"><a href="' . $base_url . "/" . $urlSpace . '">' . $spaceterm->name . '</a></li>';
	}
}

?>
                </ul>
            </li>
            <!--updated on 10th april 2014 - end-->
           <!-- updated on 14th April 2014 - start-->
            <!-- updated on 14th April 2014 - start-->
 			<li class=" mail"><span class="iconsilluminart"></span><a href="https://illuminologybytisva.wordpress.com/" target="_blank">Illuminology</a></li>


            <li class="icons mail"><a href="<?php echo $base_url?>/contact-us" title="Contact Us">Contact Us</a></li>
            <!-- updated on 14th April 2014 - end-->
            <!-- updated on 14th April 2014 - end-->
            <!--updated on 10th april 2014 - start-->
            <li class="icons location"><a href="<?php echo $base_url?>/store-locator" title="Store Locator">Store Locator</a></li>
            <li class="icons search"><a href="javascript:;" title="Search">Search</a>
            <div class="search_form">
              <form class="search-form" action="<?php global $base_url;print $base_url;?>/search/node" method="post" id="search-form" accept-charset="UTF-8">
                <input id="edit-keys" name="keys"  onfocus="clearText(this)" onblur="clearText(this)" value="Search" maxlength="255" class="form-text" type="text">
                <input name="form_id" value="search_form" type="hidden">
                <input id="edit-submit" name="op" value="Go" class="link_btn" type="submit">
             </form>
             </div>
            </li>
            <!--updated on 10th april 2014 - end-->
          <!--  <li class="call_text">Call us on <span>1800 103 3222</span></li>-->
          </ul>
        </div>
        <div class="rhs_content">
          <div class="slider_container">
            <div class="slider_content">
              <div class="slider_lhs">
                <div class="slider">
<?php
//echo "<pre>";
/*$nodes = $page["content"]["system_main"]["nodes"];

$i=0;
foreach($nodes as $node)
{
if($node['#node']->type=="product") {
if($i==5) break;
$title_array[] = $node['#node']->title;
$image_array[] = $node['#node']->uc_product_image[und][0][uri];
$info_array[] = $node['#node']->body[und][0][value];
$tid =  $node['#node']->field_spaces_applicable[und][0][tid];
$short_title_array[] = $node['#node']->field_short_title[und][0][value];
if($tid<>"") {
$term = taxonomy_term_load($tid);
//print_r($term);
if ($image_items = field_get_items('taxonomy_term', $term, 'field_icon')) {
$uri = $image_items[0]['uri'];
$external_url = file_create_url($uri);
}
$spaces_array[] = $term->name ;
}
$feature_array[] = $node['#node']->field_features[und][0][value];
$color_array[] = $node['#node']->field_color[und][0][value];
$i++;
}
}*/

?>
<div class="title_container">
<?php for ($j = 0; $j < count($title_array); $j++) {?>
                    	<p class="product_title"><?php echo $title_array[$j];?></p>
<?php }?>
</div>
                  <div class="img_container">
<?php for ($j = 0; $j < count($image_array); $j++) {?>
                    <div class="img_wrapper">
                    	<img src="<?php echo image_style_url("uc_product_full", $image_array[$j])?>" alt="" title="" class="off" />
					</div>
<?php }?></div>
                  <div class="info1_container">




















<?php for ($j = 0; $j < count($info_array); $j++) {?>
                    <div class="info_cont"><?php echo $info_array[$j];?></div>
<?php }?>
</div>
<?php /* <div class="spaces_container">
<?php for($j=0;$j<count($spaces_array);$j++) {	?>
<div class="info_cont">
<?php for($k=0;$k<count($spaces_array[$j]);$k++)?>
<img src="<?php echo $external_url?>" title="<?php echo $spaces_array[$j][$k];?>" />
<?php ?>
</div>
<?php } ?>
</div> */?>
<div class="features_container">
<?php for ($j = 0; $j < count($feature_array); $j++) {
	?>
	                    <div class="info_cont"><?php if ($feature_array[$j] != "") {
		echo $feature_array[$j];
	}
	?></div>
<?php }?>
</div>
<?php /* <div class="colours_container">
<?php for($j=0;$j<count($color_array);$j++) {	?>
<div class="info_cont"><?php echo $color_array[$j];?></div>
<?php } ?>
</div>*/?>
</div>
              </div>
              <div class="slider_rhs">
<?php for ($j = 0; $j < count($short_title_array); $j++) {?>
    	            <p class="info_title"><span class="title1"><?php echo $short_title_array[$j];?></span></p>
<?php }?>
</div>
            </div>
            <ul class="pagination">
            </ul>
          </div>
          <div class="slider_nav">
            <div class="thumbnails">
<?php for ($j = 0; $j < count($image_array); $j++) {?>
                    <div class="thumb"> <img src="<?php echo image_style_url("thumbnail", $image_array[$j])?>" alt="" title=""/> </div>
<?php }?></div>
            <a href="javascript:;" class="prev" title="Previous">Prev</a> <a href="javascript:;" class="next" title="Next">Next</a> </div>
          <ul class="bottom_links">
            <li  class="info_link"><a id="info" href="javascript:;">Info</a>
              <div class="info_content"> <a class="close">close</a>
                <p class="info_title"></p>
                <div class="slide_info"></div>
                <span class="pointer"></span> </div>
            </li>
           <!--  <li  class="info_link"><a id="spaces" href="javascript:;">Spaces</a>
              <div class="info_content"> <a class="close">close</a>
                <p class="info_title"></p>
                <div class="slide_info"></div>
                <span class="pointer"></span> </div>
            </li>  -->
             <!--updated on 10th april 2014 - start-->
           <!-- <li class="two_lines"><a  id="swith_on" href="javascript:;">Switch<br />
              ON</a></li>-->
               <!--updated on 10th april 2014 - end-->
            <li  class="info_link rt_info_link"><a id="features" href="javascript:;">Features</a>
              <div class="info_content"> <a class="close">close</a>
                <p class="info_title"></p>
                <div class="slide_info"></div>
                <span class="pointer"></span> </div>
            </li>
          <!--   <li  class="info_link rt_info_link"><a id="colours" href="javascript:;">Colours</a>
              <div class="info_content"> <a class="close">close</a>
                <p class="info_title"></p>
                <div class="slide_info"></div>
                <span class="pointer"></span> </div>
            </li> -->
            <!--<li><a href="javascript:;">360&deg;</a></li>-->
          </ul>
        </div>
      </div>
    </div>
  </div>
<?php include 'includes/footer.inc';?>
</div>
</div>
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'tisva')?>/js/homepage.js"></script>
<script type="text/javascript">
	var base_url = "<?php echo $base_url;?>";
	//alert(base_url);
</script>
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'tisva')?>/js/validation.js"></script>

 <!-- Tisva Feedback form starts-->
  <div class="feedback-head">
	<div class="drag">
		<a class="slideout" href=""></a>
	</div>
	<div class="feedback-main">
		<a class="close_feedback" href="#close_feedback">x</a>
		<div class="dvtellus">
			<h2>Feedback</h2>
		</div>
		<div class="feedback_divider"></div>
		<div class="result">
		</div>
		<div class="feedbackFormContainer">
			<form id="frmFeedback" name="frmFeedback" enctype="multipart/form-data" method="POST" action="<?php echo $base_url;?>/offer/procesUserRequest.php">
				<input type="hidden" name="code" id="code" value="<?php echo $encryptedString;?>" readonly />
				<input type="hidden" name="extras" id="extras" value="<?php echo $myRandomString;?>" readonly />
				<div class="name label-text">
					Name:
				</div>
				<div>
					<input class="fullname" placeholder="Enter your name" name="user_name" id="user_name" type="text" maxlength="50" value="">
					<span class="field-validation-valid" data-valmsg-for="FullName" data-valmsg-replace="true"></span>
				</div>
				<div class="email label-text">
					Email:
				</div>
				<div>
					<input class="email" placeholder="Enter your email address" name="user_email" id="user_email" type="text" maxlength="50" value="">
					<span class="field-validation-valid" data-valmsg-for="Email" data-valmsg-replace="true"></span>
				</div>
				<div class="comment label-text">
					Suggestion:
				</div>
				<div>
					<textarea class="enquiry" cols="20" placeholder="Enter your feedback" name="user_suggestion" id="user_suggestion" maxlength="1024" rows="2"></textarea>
					<span class="field-validation-valid" data-valmsg-for="user_suggestion" data-valmsg-replace="true"></span>
				</div>
				<div class="buttons">
					<input type="submit" name="send-email" id="send-email" class="btn green right big" value="Submit">
				</div>
			</form>
		</div>
		<div class="feedbackThankYou">
			<p class="feedbackMessage">Thank you for your feedback, We will get back to you shortly</p>
		</div>
	</div><!--
	<div class="feedback-main" style="display: none">
		<div class="resptxt">Thank you for providing your valuable feedback.<a href="#feedbackresp" title="Close" class="fadeout close_lnk">x</a></div>
		<div class="backdrop"></div>
	</div> -->
</div>
<!-- Tisva Feedback form ends-->