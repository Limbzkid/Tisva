<?php
global $base_url;

?>
	<style type="text/css">
		.antispam { display:none;}
	</style>
<?php
	if(isset($_POST['url']) && $_POST['url'] == '') {
		if(isset($_REQUEST['mobile1']) && $_REQUEST['mobile1']!='') {	
			$subject = 'Price Enquiry';
			$message = '<html><body>';
			$message .= '<table width="100%"; rules="all" style="border:1px solid #3A5896;" cellpadding="10">';
			$message .= "<tr><td colspan='2'><span class='item_code'>Item code: ".$_REQUEST['modelName']."</span></td></tr>";
			$message .= "<tr><td colspan='2'>Mobile: ".$_REQUEST['mobile1']."</td></tr>";
			$message .= "<tr><td colspan='2'>City: ".$_REQUEST['city']."</td></tr>";
			$message .= "<tr><td colspan='2'>Enquiry from: <a href='http://".$_SERVER['HTTP_HOST'] . request_uri()."' target='_blank'>http://".$_SERVER['HTTP_HOST'] .request_uri()."</a></td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";
			$nid = db_insert('contactus')->fields(array(
				'mobile1' => $_REQUEST['mobile1'],
				'city' => $_REQUEST['city'],
				'query' => $message,
				'requesttype' => 1,
				'querydate' => format_date(time(), 'custom', 'Y-m-d h:i:s'),'subject'=>$subject,
			))->execute();
			$from=variable_get('site_mail', ini_get('sendmail_from'));
			$to=variable_get('site_mail', ini_get('sendmail_from'));
			$headers = "From: " . strip_tags($from) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail($to, $subject, $message, $headers);
			return;
		}
	}
?>
<?php

/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
?>
<script type="text/javascript" src="<?php echo $base_url.'/'.drupal_get_path('theme', 'tisva') ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $base_url.'/'.drupal_get_path('theme', 'tisva') ?>/js/additional-methods.js"></script>
<script type="text/javascript" src="<?php echo $base_url.'/'.drupal_get_path('theme', 'tisva') ?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo $base_url.'/'.drupal_get_path('theme', 'tisva') ?>/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" id="sourcecode">
	$(function() {
		$('.scroll-pane').jScrollPane({autoReinitialise:true});        
	});
</script> 

<link type="text/css" href="<?php echo $base_url.'/'.drupal_get_path('theme', 'tisva') ?>/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
<?php  if($node->type == "product" && $view_mode == 'full') { ?>
	<div class="content">
    <div class="page_wrapper">
      <div class="overview_top">
        <ul class="breadcrumb">
					<pre>
					<?php
						// first, get a term object from a term ID
						$term = taxonomy_term_load($node->taxonomy_catalog["und"][0]["taxonomy_term"]->tid);
						//print_r($node);
						
						$term_uri = taxonomy_term_uri($term); // get array with path
						$term_title = taxonomy_term_title($term);
						$term_path = $term_uri['path'];
						$link = l($term_title,$term_path);
					?>
					</pre>
          <li><span></span><?php echo $link?></li>
          <li class="active"><span></span><a href="javascript:;"><?php $explodeBreadCrumbTitle=explode('-',$node->title);echo $explodeBreadCrumbTitle[0];?></a></li>
        </ul>
				<?php //if($node->taxonomy_catalog["und"][0]["tid"] <> 22 &&  $node->taxonomy_catalog["und"][0]["tid"] <> 23) {?>
				<h1 class="detail_title"><?php $explodeMainTitle=explode('-',$node->title);echo $explodeMainTitle['0'];?><span class="item_code" id="item_code">Item code <?php echo $node->model;?></span></h1>
				<p><?php echo $node->body["und"][0]["value"];?></p>
				<p class="price">MRP: <span class="rupee">` </span><span id="mrp_code"><?php echo number_format($node->list_price, 2, '.', ''); ?></span></p>
        <?php /*}else {?>
        <h1 class="detail_title"><?php $explodeMainTitle=explode('-',$node->title);
							echo $explodeMainTitle['0'];?>
		<span></span></h1>
		<p><?php echo $node->body["und"][0]["value"];?></p>
		
        <?php } */?>
        
        
      </div>
	  <?php // call function to get GetNoOfLamps(); for product?>
      <ul class="lamps_list">
	  <?php 
		
			
			
	  		//get similar products by name
	  	$query = new EntityFieldQuery();
			$query->entityCondition('entity_type', 'node');
			$query->entityCondition('bundle', 'product');
			//$query->propertyCondition('title',$node->title);
			$query->fieldCondition('taxonomy_catalog','tid',$node->taxonomy_catalog["und"][0]["tid"],"=");
			if($node->field_sub_category["und"][0]["tid"]!='') {
				$query->fieldCondition('field_sub_category','tid',$node->field_sub_category["und"][0]["tid"],"=");
			} else {
				$query->propertyCondition('title',$node->title);
			}
			$query->propertyCondition('status',1);
			$query->propertyCondition('promote',1);
			
			$result = $query->execute();
			$product_variations = node_load_multiple(array_keys($result['node']));
			echo '<pre>';
			print_r($product_variations);
			echo '</pre>';
	  	if(!empty($product_variations)) {
				foreach($product_variations as $product) {
					if(isset($product->field_no_of_lamps['und'])) {
						//$explodeNodeTitle=explode('-',$product->title);
						//$line['#node']->field_sub_category["und"][0]["tid"]
						$ifSubCat='';
						if($product->field_sub_category['und'][0]["tid"]!='') {
							$explodeNodeTitle=explode('-',$product->title);
							$ifSubCat=$explodeNodeTitle[1].'<br>';
						}
						$listPrice=number_format($product->list_price, 2, '.', '');
						$lamps = $product->field_no_of_lamps['und'][0]["tid"];
						$lamp_details = taxonomy_term_load($lamps);
						$name = $lamp_details->name;
						$lamp_image =image_style_url("large",$product->field_lamp_detail_background_ima['und'][0]["uri"]);
						$style ="";
						if($lamp_image != "") {
							$style = "background-image:url('".$lamp_image."')";
						}
						$tmp = explode(" ",$name);
						$cls = $name;//GetLampCss($tmp);
						if($product->vid == $node->vid)
							$cls .=  " active";
						echo '<li class="'.$cls.'" rel="'.$product->model.'"><div class="lamp_data" id="'.$product->model.'"> <span  style="'. $style.'" ></span> <a href="javascript:;">'.$ifSubCat.$name.'<br/>'.$product->field_color["und"][0]["value"].'</a></div><span style="display:none;" id="'.$product->model.'_pl">'.$listPrice.'</span></li>';
					}
				
				}				
			}
      	?>
        </ul>
      <div class="lamps_tabs">
	  <?php 
	  
	  if(!empty($product_variations))
	  {
		$i=0;$ids='';
			foreach($product_variations as $product)
			{
				
				if($ids == '') $ids.='#submitfrm'+$i+' ';
				else $ids.=',#submitfrm'+$i;	
	 ?>	
      <!--  content for  lamp start-->
      	<div class="lamps_tab_container">
  <div class="lamp_info">
    <div class="lamp_info_lhs">
      <div class="left_top_section">
        <div class="info_features">
          <p class="info_features_ttl">Design & Features</p>
          <ul>
			<?php
				if($product->field_material["und"][0]["value"]!='-')
				{
			?>
            <li> <span class="bullet"></span> <span class="name">Material</span> <span class="para"><?php echo $product->field_material["und"][0]["value"];?></span></li>
			<?php
				}
				if($product->field_color["und"][0]["value"]!='-')
				{
			?>
            <li> <span class="bullet"></span> <span class="name">Color</span> <span class="para"><?php echo $product->field_color["und"][0]["value"];?></span></li>
			<?php
				}
				if($product->field_installation["und"][0]["value"]!='-')
				{
			?>
            <li> <span class="bullet"></span> <span class="name">Installation</span> <span class="para"><?php echo $product->field_installation["und"][0]["value"];?></span></li>
			<?php 
				}
				if($node->taxonomy_catalog["und"][0]["taxonomy_term"]->name=='Kids Range')
				{
			?>
					<li> <span class="bullet"></span> <span class="name">Dimensions</span> <span class="para"><?php echo $product->field_dimensions["und"][0]["value"];?></span></li>
			<?php
				}
			?>
			
          </ul>
        </div>
		
		<?php 
		
			$tmpSpc='';
			$spaces = $product->field_spaces_applicable['und'];
			if(count($spaces)>0) { 
				for($t=0;$t<=count($spaces)-1;$t++) {
					if($spaces[$t]['tid']<>"") {
						$term_id = $spaces[$t]['tid'];
						$term = taxonomy_term_load($term_id);
						
						if ($image_items = field_get_items('taxonomy_term', $term, 'field_icon')) {
						  $uri = $image_items[0]['uri'];
						  $external_url = file_create_url($uri);
						 }
						 $tmpSpc=$term->name;
					}
				}
			}
			
			
		?>
			
        <div class="info_features info_features2"> <?php echo $product->field_features["und"][0]["value"];?> </div>
		<?php
		if($tmpSpc!='NA')
		{
		?>
        <div class="info_mid">
          <p class="mid_left">Suitable for</p>
          <ul>
		  	<?php 
					$spaces = $product->field_spaces_applicable['und'];
						if(count($spaces)>0) { 
							for($t=0;$t<=count($spaces)-1;$t++) {
								if($spaces[$t]['tid']<>"") {
									$term_id = $spaces[$t]['tid'];
									$term = taxonomy_term_load($term_id);
									
									if ($image_items = field_get_items('taxonomy_term', $term, 'field_icon')) {
									  $uri = $image_items[0]['uri'];
									  $external_url = file_create_url($uri);
									 }
									  ?>
										<li class="living"> <span><?php echo  $term->name;?></span> <span><?php if($external_url<>"")  { ?><img src="<?php echo $external_url; ?>"/><?php } ?></span> </li>								  								  <?php
								}
							}
						}
			?>
            <!--<li class="living"> <span>Living</span> <span class="ico"></span> </li>-->
          </ul>
        </div>
		<?php
			}
		?>
        <ul class="info_bottom">
          <?php 
				$other_attr  = $product->field_other_attirutes["und"];
                foreach($other_attr as $att)
                {
                	switch($att[value])
                	{
                		case "No harmful uv/infrared emission" :
                			echo '<li class="spec1"><span></span>No harmful uv/infrared emission</li>';
                			break;
                		case "Low carbon footprint" :
                			echo '<li class="spec2"><span></span>Low carbon footprint</li>';
                			break;
                		case "Zero mercury" :
                			echo '<li class="spec3"><span></span>Zero mercury</li>';
                			break;	
                		case "Long life led technology" :
                			echo '<li class="spec4"><span></span>Long life led technology</li>';
                			break;
                	}
                }
                ?>

        </ul>
      </div>
	  
	  <form name='prdfrm<?php print $i;?>' id='prdfrm<?php print $i;?>' action='' method="POST">
	  <input type="hidden" name="modelName" value="<?php print $product->model;?>">
      <div class="left_bottom_section">
        <p>INTERESTED? <span>Check availability, price!</span></p>
			<div class="fld">
			  <!--<input type="number" value="Enter Your mobile" onblur="clearText(this)" onfocus="clearText(this)" name="mobile1" id="mobile1" maxlength="10" autocomplete="off" max="9999999999"/>-->
			  <input type="number" max="9999999999" autocomplete="off" maxlength="10" id="mobile1<?php print $i;?>" name="mobile1" onfocus="myFocus(this)" onblur="myBlur(this)" value="Enter Your mobile" placeholder="Enter Your mobile">

			  <label class="error" id="error1<?php print $i;?>">Please enter only digits.</label>
			</div>
			
			<div class="fld">
			  <div class="selectBox">
				<div id="box" class="box">Select City</div>
				<select onChange="this.parentNode.getElementsByTagName('div')[0].innerHTML=this.options[this.selectedIndex].text" id="city<?php print $i;?>" name="city">
					<option value="" class="primero">Select City</option>
					 <?php 
						$vid = taxonomy_vocabulary_machine_name_load("store_location")->vid;
						$terms = taxonomy_get_tree($vid,$parent=0, $max_depth=2);
						$selected = "";
						foreach($terms as $term){
							$selected = "";
						/*(if($city == $term->name) { 
						$selected = "selected='selected'";*/ 
					//}
					?>
						<option value="<?php echo $term->name?>" <?php echo $selected?> ><?php echo $term->name?> </option>
					<?php
					}
					 ?>
					</select>
			  </div>
			  <label class="error" id="error2<?php print $i;?>">Please select city.</label>
			</div>
			
			<p class="antispam">Leave this empty:
			<br /><input name="url" /></p>
			
			<a href="javascript:;" class="link_btn" id="submitfrm<?php print $i;?>">Have us call you</a>
			<h2 id="successMsg<?php print $i;?>" class="successMsg" style="display:none;">We will contact you shortly</h2>
		</div>
	</form>
	<?php $i++;?>
    </div>
    <div class="lamp_info_rhs">
      <p class="rhs_view">Product View</p>
      <div class="product_bg">
        <?php if($product->uc_product_image['und'][0]['uri']<>"") {  ?>
        <img title="<?php echo $product->title?>" alt="<?php echo $product->title?>" src="<?php echo image_style_url("large",$product->uc_product_image[und][0][uri])?>">
        <?php } ?>
      </div>
      <div class="lamp_types">
        <ul class="slider_container">
          <?php if(count($product->field_other_images)>0) { 
								$images = $product->field_other_images;
								for($n=0;$n<=count($images);$n++) {
								//print_r($images['und'][$n]);
									if($images['und'][$n]['uri']<>"") { 
						?>
          <li class="prod_img" rel="<?php echo image_style_url("uc_product",$images['und'][$n]['uri'])?>"> <img alt="<?php $product->title?>" src="<?php echo image_style_url("uc_product",$images['und'][$n]['uri'])?>" title=""/></li>
          <?php 					} 
		  						}
								}
						?>
        </ul>
        <ul class="pagination">
        </ul>
      </div>
    </div>
  </div>
  <div class="bottom_tabs">
    <ul>
      <!--  <li><a href="javascript:;">Features</a></li>-->
      <?php if(empty($product->field_related_products)){?>
      <li class="active"><a href="javascript:;">Technical Specifications</a></li>
      <?php }else{?>
      <li class="active"><a href="javascript:;">Features</a></li>
      <?php }?>
    </ul>
    
    <?php

	    //Get Sub products if any
		$query = new EntityFieldQuery();
		$query->entityCondition('entity_type', 'node');
		$query->entityCondition('bundle', 'product');
		$query->fieldCondition('field_related_products','target_id',$product->vid,"=");
		$query->fieldOrderBy('field_sub_category', 'tid', 'ASC');
		$result = $query->execute();
		$subproducts = node_load_multiple(array_keys($result['node']));
    if(empty($subproducts)){?>
    <div class="bottom_tab_data">
      <?php /* <div class="tab_info">
        <?php if($node->field_featured_image[und][0][uri]<>"") {  ?>
            	<div class="tab_box box1">
                	<img src="<?php echo image_style_url("uc_product",$node->field_featured_image[und][0][uri])?>" alt="" title="" />
                </div>
            <?php } ?>    
        <div class="tab_box box2">
          <h3><span></span>The Features</h3>
          <ul>
            <li> <span class="name">Material</span> <span class="para"><?php echo $product->field_material["und"][0]["value"];?> </span> </li>
            <li> <span class="name">Color</span> <span class="para"><?php echo $product->field_color["und"][0]["value"];?></span> </li>
            <li> <span class="name">Installation</span> <span class="para"><?php echo $product->field_installation["und"][0]["value"];?></span> </li>
          </ul>
        </div>
        <div class="tab_box box3">
          <h3><span></span>What it means</h3>
          <ul>
            <li><?php echo $product->field_material_tip["und"][0]["value"];?></li>
            <li><?php echo $product->field_color_tip["und"][0]["value"];?></li>
            <li><?php echo $product->field_installation_tip["und"][0]["value"];?></li>
          </ul>
        </div>
      </div> */?>
      <div class="tab_info">
        <?php if($product->field_specification_image['und'][0]['uri']<>"") {  ?>
        <div class="tab_box box1"> <img src="<?php echo image_style_url("uc_product",$product->field_specification_image['und'][0]['uri'])?>" alt="" title="" /> </div>
        <?php } ?>
        <?php if ($product->field_techincal_spec["und"][0]["value"] <> "") { ?>
        <div class="tab_box box2">
          <h3><span></span>The Specifications</h3>
          <?php echo $product->field_techincal_spec["und"][0]["value"];?> </div>
        <?php }	?>
        <?php if($product->field_technical_specification_wh["und"][0]["value"] <> "") { ?>
        <div class="tab_box box3">
          <!-- <h3><span></span>What it means 1</h3>  -->
          <?php echo $product->field_technical_specification_wh["und"][0]["value"] ?> </div>
        <?php } ?>
      </div>
	  
    </div>
	<?php } else{
    ?>
    	<div class="bottom_tab_data">
            <!--updated on 02 June 2014 - start-->
              <div class="tab_info scroll-pane">
              <?php
              		$arr_rel_prod= array();
              		$index=0;
		              $table_index =0;
		              $current_subcat =0;
		              $prev_subcat =0;
		              $row_index =0;
		              $col_index =0;
              foreach ($subproducts as $pro_details)
              {
              		 $cat_id_temp = ($pro_details->taxonomy_catalog["und"][0]["tid"]);
	              	 //$pro_details = ($rel_prodcut["entity"]);
	              	 $current_subcat = $pro_details->field_sub_category["und"][0]["tid"];
	              	 $form_table = false;
	              	 if(($current_subcat != $prev_subcat))
	              	 {
	              	 		$form_table = true;
	              		 	$index = 0;
	              		 	
	              	 }
	              	 else
	              	 {
	              	 	$index++;
	              	 	if($index%9 == 0)
	              	 		$form_table = true;
	              	 	
	              	 }
              		 if($form_table)
              		 {
	              		 $table_index++;
              		 	/*if($index >0 || ($current_subcat != $prev_subcat))
              				$table_index++;*/
              					
              			switch($cat_id_temp)
              			{
              				case 35 :	
		              		 	$arr_rel_prod[$table_index][0][0] ="ITEM CODE";
			              		$arr_rel_prod[$table_index][1][0] ="RATED WATTAGE";
			              		$arr_rel_prod[$table_index][2][0] ="OPERATING VOLTAGE";
			              		$arr_rel_prod[$table_index][3][0] ="CCT";
			              		$arr_rel_prod[$table_index][4][0] ="FREQUENCY";
			              		$arr_rel_prod[$table_index][5][0] ="NO OF LEDS";
			              		$arr_rel_prod[$table_index][6][0] ="WATTAGE";
			              		$arr_rel_prod[$table_index][7][0] ="DIMMING";
			              		$arr_rel_prod[$table_index][8][0] ="Remote Control";
			              		$arr_rel_prod[$table_index][9][0] ="MRP (in Rs.)";
			              	break;
			              	case 27 :	
			              		
			              		$arr_rel_prod[$table_index][0][0] ="ITEM CODE";
		              		 	$arr_rel_prod[$table_index][1][0] ="TYPE OF LAMP";
			              		$arr_rel_prod[$table_index][2][0] ="BASE";
			              		$arr_rel_prod[$table_index][3][0] ="RATED VOLTAGE";
			              		$arr_rel_prod[$table_index][4][0] ="OPERATING VOLTAGE";
			              		$arr_rel_prod[$table_index][5][0] ="FREQUENCY";
			              		$arr_rel_prod[$table_index][6][0] ="WATTAGE";
			              		$arr_rel_prod[$table_index][7][0] ="CURRENT";
			              		$arr_rel_prod[$table_index][8][0] ="LUMINOUS FLUX";
			              		$arr_rel_prod[$table_index][9][0] ="CCT";
			              		$arr_rel_prod[$table_index][10][0] ="LIFE";
			              		$arr_rel_prod[$table_index][11][0] ="DIMMING";
			              		$arr_rel_prod[$table_index][12][0] ="MRP (in Rs.)";
			              	break;
			              	case 28 :	
		              		 	$arr_rel_prod[$table_index][0][0] ="ITEM CODE";
		              		 	$arr_rel_prod[$table_index][1][0] ="RATED WATTAGE";
		              		 	$arr_rel_prod[$table_index][2][0] ="LAMP TYPE";
			              		$arr_rel_prod[$table_index][3][0] ="CAPSULE TYPE";
			              		$arr_rel_prod[$table_index][4][0] ="BASE";
			              		$arr_rel_prod[$table_index][5][0] ="RATED VOLTAGE";
			              		$arr_rel_prod[$table_index][6][0] ="RATED FREQUENCY";
			              		$arr_rel_prod[$table_index][7][0] ="CCT";
			              		$arr_rel_prod[$table_index][8][0] ="POWER FACTOR";
			              		$arr_rel_prod[$table_index][9][0] ="RATED LUMINOUS FLUX";
			              		$arr_rel_prod[$table_index][10][0] ="MAXIMUM LENGTH (IN MM)";
			              		$arr_rel_prod[$table_index][11][0] ="MRP (in Rs.)";
			              	break;
			              	case 30 :	
		              		 	$arr_rel_prod[$table_index][0][0] ="ITEM CODE";
		              		 	$arr_rel_prod[$table_index][1][0] ="TYPE OF LAMP";
		              		 	$arr_rel_prod[$table_index][2][0] ="NO OF LAMP";
			              		$arr_rel_prod[$table_index][3][0] ="FITTING/CAP";
			              		$arr_rel_prod[$table_index][4][0] ="RATED VOLTAGE";
			              		$arr_rel_prod[$table_index][5][0] ="OPERATING VOLTAGE";
			              		$arr_rel_prod[$table_index][6][0] ="FREQUENCY";
			              		$arr_rel_prod[$table_index][7][0] ="RATED WATTAGE";
			              		$arr_rel_prod[$table_index][8][0] ="TOTAL WATTAGE";
			              		$arr_rel_prod[$table_index][9][0] ="MRP (in Rs.)";
			              	break;
			              	case 31 :	
		              		 	$arr_rel_prod[$table_index][0][0] ="ITEM CODE";
			              		$arr_rel_prod[$table_index][1][0] ="TYPE OF LAMP";
		              		 	$arr_rel_prod[$table_index][2][0] ="RATED VOLTAGE";
			              		$arr_rel_prod[$table_index][3][0] ="OPERATING VOLTAGE";
			              		$arr_rel_prod[$table_index][4][0] ="FREQUENCY";
			              		$arr_rel_prod[$table_index][5][0] ="RATED WATTAGE";
			              		$arr_rel_prod[$table_index][6][0] ="TOTAL WATTAGE";
			              		$arr_rel_prod[$table_index][7][0] ="CCT";
			              		$arr_rel_prod[$table_index][8][0] ="LUMINOUS FLUX";
			              		$arr_rel_prod[$table_index][9][0] ="MRP (in Rs.)";
			              	break;
			              	case 32 :
			              	case 33 :		
		              		 	$arr_rel_prod[$table_index][0][0] ="ITEM CODE";
		              		 	$arr_rel_prod[$table_index][1][0] ="TYPE OF LAMP";
		              		 	$arr_rel_prod[$table_index][2][0] ="NO OF LAMP";
			              		$arr_rel_prod[$table_index][3][0] ="FITTING/CAP";
			              		$arr_rel_prod[$table_index][4][0] ="RATED VOLTAGE";
			              		$arr_rel_prod[$table_index][5][0] ="OPERATING VOLTAGE";
			              		$arr_rel_prod[$table_index][6][0] ="FREQUENCY";
			              		$arr_rel_prod[$table_index][7][0] ="RATED WATTAGE";
			              		$arr_rel_prod[$table_index][8][0] ="TOTAL WATTAGE";
			              		$arr_rel_prod[$table_index][9][0] ="CCT";
			              		$arr_rel_prod[$table_index][10][0] ="LUMINOUS FLUX";
			              		$arr_rel_prod[$table_index][11][0] ="MRP (in Rs.)";
												break;
											
											case 133:
												$arr_rel_prod[$table_index][0][0] ="ITEM CODE";
		              		 	$arr_rel_prod[$table_index][1][0] ="TYPE OF LAMP";
		              		 	$arr_rel_prod[$table_index][2][0] ="NO OF LAMP";
			              		$arr_rel_prod[$table_index][3][0] ="FITTING/CAP";
			              		$arr_rel_prod[$table_index][4][0] ="RATED VOLTAGE";
			              		$arr_rel_prod[$table_index][5][0] ="OPERATING VOLTAGE";
			              		$arr_rel_prod[$table_index][6][0] ="FREQUENCY";
			              		$arr_rel_prod[$table_index][7][0] ="RATED WATTAGE";
			              		$arr_rel_prod[$table_index][8][0] ="TOTAL WATTAGE";
			              		$arr_rel_prod[$table_index][9][0] ="CCT";
			              		$arr_rel_prod[$table_index][10][0] ="LUMINOUS FLUX";
			              		$arr_rel_prod[$table_index][11][0] ="MRP (in Rs.)";
												break;
		              		
              			}
	              		$arr_rel_prod[$table_index]["subcategroy"] =($current_subcat != $prev_subcat) ? $current_subcat : "";
	              		$row_index =0;
              			$col_index=0;
              			
              		 }
              		 else
              		 {
              		 	
              		 }
              		 
              		 {
              		 	$col_index++;
              		 switch($cat_id_temp)
              			{
              				case 35 :	
		              		 	$arr_rel_prod[$table_index][0][$col_index] =$pro_details->model;
			              		$arr_rel_prod[$table_index][1][$col_index] =$pro_details->field_rated_wattage["und"][0]["value"];
	    		          		$arr_rel_prod[$table_index][2][$col_index] =$pro_details->field_operating_voltage["und"][0]["value"];
	            		  		$arr_rel_prod[$table_index][3][$col_index] =$pro_details->field_cct["und"][0]["value"];
	    		          		$arr_rel_prod[$table_index][4][$col_index] =$pro_details->field_frequency["und"][0]["value"];
	              				$arr_rel_prod[$table_index][5][$col_index] =$pro_details->field_no_of_leds["und"][0]["value"];
	              				$arr_rel_prod[$table_index][6][$col_index] =$pro_details->field_wattage["und"][0]["value"];
	              				$arr_rel_prod[$table_index][7][$col_index] =$pro_details->field_dimming["und"][0]["value"];
	              				$arr_rel_prod[$table_index][8][$col_index] =$pro_details->field_remote_control["und"][0]["value"] ? $pro_details->field_remote_control["und"][0]["value"] == "1" ?"Yes" : "No" :"N/A";
	              				$arr_rel_prod[$table_index][9][$col_index] = number_format($pro_details->list_price, 2, '.', '');
	              				$arr_rel_prod[$table_index]["last_index"] = 9;
			              	break;
			              	case 27 :	
			              		$arr_rel_prod[$table_index][0][$col_index] =$pro_details->model;
		              		 	$arr_rel_prod[$table_index][1][$col_index] =$pro_details->field_type_of_lamp["und"][0]["value"];
			              		$arr_rel_prod[$table_index][2][$col_index] =$pro_details->field_base["und"][0]["value"];
			              		$arr_rel_prod[$table_index][3][$col_index] =$pro_details->field_rated_voltage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][4][$col_index] =$pro_details->field_operating_voltage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][5][$col_index] =$pro_details->field_frequency["und"][0]["value"];
			              		$arr_rel_prod[$table_index][6][$col_index] =$pro_details->field_wattage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][7][$col_index] =$pro_details->field_current["und"][0]["value"];
			              		$arr_rel_prod[$table_index][8][$col_index] =$pro_details->field_luminous_flux["und"][0]["value"];
			              		$arr_rel_prod[$table_index][9][$col_index] =$pro_details->field_cct["und"][0]["value"];
			              		$arr_rel_prod[$table_index][10][$col_index] =$pro_details->field_life["und"][0]["value"];
			              		$arr_rel_prod[$table_index][11][$col_index] =$pro_details->field_dimming["und"][0]["value"];
			              		$arr_rel_prod[$table_index][12][$col_index] =number_format($pro_details->list_price, 2, '.', '');
			              		$arr_rel_prod[$table_index]["last_index"] = 12;
			              	break;
			              	case 28 :	
		              		 	$arr_rel_prod[$table_index][0][$col_index] =$pro_details->model;
		              		 	$arr_rel_prod[$table_index][1][$col_index] =$pro_details->field_rated_wattage["und"][0]["value"];
		              		 	$arr_rel_prod[$table_index][2][$col_index] =$pro_details->field_type_of_lamp["und"][0]["value"];
			              		$arr_rel_prod[$table_index][3][$col_index] =$pro_details->field_capsule_type["und"][0]["value"];
			              		$arr_rel_prod[$table_index][4][$col_index] =$pro_details->field_base["und"][0]["value"];
			              		$arr_rel_prod[$table_index][5][$col_index] =$pro_details->field_rated_voltage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][6][$col_index] =$pro_details->field_rated_frequency["und"][0]["value"];
			              		$arr_rel_prod[$table_index][7][$col_index0] =$pro_details->field_cct["und"][0]["value"];
			              		$arr_rel_prod[$table_index][8][$col_index] =$pro_details->field_power_factor["und"][0]["value"];
			              		$arr_rel_prod[$table_index][9][$col_index] =$pro_details->field_rated_luminous_flux["und"][0]["value"];
			              		$arr_rel_prod[$table_index][10][$col_index] =$pro_details->field_maximum_length_in_mm_["und"][0]["value"];
			              		$arr_rel_prod[$table_index][11][$col_index] =number_format($pro_details->list_price, 2, '.', '');
			              		$arr_rel_prod[$table_index]["last_index"] = 11;
			              	break;
			              	case 30 :	
		              		 	$arr_rel_prod[$table_index][0][$col_index] =$pro_details->model;
		              		 	$arr_rel_prod[$table_index][1][$col_index] =$pro_details->field_type_of_lamp["und"][0]["value"];
		              		 	$arr_rel_prod[$table_index][2][$col_index] =$pro_details->field_no_of_lamps["und"][0]["value"];
			              		$arr_rel_prod[$table_index][3][$col_index] =$pro_details->field_fitting_cap["und"][0]["value"];
			              		$arr_rel_prod[$table_index][4][$col_index] =$pro_details->field_rated_voltage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][5][$col_index] =$pro_details->field_operating_voltage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][6][$col_index] =$pro_details->field_frequency["und"][0]["value"];
			              		$arr_rel_prod[$table_index][7][$col_index] =$pro_details->field_rated_wattage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][8][$col_index] =$pro_details->field_total_wattage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][9][$col_index] =number_format($pro_details->list_price, 2, '.', '');
			              		$arr_rel_prod[$table_index]["last_index"] = 9;
			              	break;
			              	case 31 :	
		              		 	$arr_rel_prod[$table_index][0][$col_index] =$pro_details->model;
			              		$arr_rel_prod[$table_index][1][$col_index] =$pro_details->field_type_of_lamp["und"][0]["value"];
		              		 	$arr_rel_prod[$table_index][2][$col_index] =$pro_details->field_rated_voltage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][3][$col_index] =$pro_details->field_operating_voltage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][4][$col_index] =$pro_details->field_frequency["und"][0]["value"];
			              		$arr_rel_prod[$table_index][5][$col_index] =$pro_details->field_rated_wattage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][6][$col_index] =$pro_details->field_total_wattage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][7][$col_index] =$pro_details->field_cct["und"][0]["value"];
			              		$arr_rel_prod[$table_index][8][$col_index] =$pro_details->field_luminous_flux["und"][0]["value"];
			              		$arr_rel_prod[$table_index][9][$col_index] =number_format($pro_details->list_price, 2, '.', '');
			              		$arr_rel_prod[$table_index]["last_index"] = 9;
			              	break;
			              	case 32 :
			              	case 33 :		
		              		 	$arr_rel_prod[$table_index][0][$col_index] =$pro_details->model;
		              		 	$arr_rel_prod[$table_index][1][$col_index] =$pro_details->field_type_of_lamp["und"][0]["value"];
		              		 	$arr_rel_prod[$table_index][2][$col_index] =$pro_details->field_no_of_lamps["und"][0]["value"];
			              		$arr_rel_prod[$table_index][3][$col_index] =$pro_details->field_fitting_cap["und"][0]["value"];
			              		$arr_rel_prod[$table_index][4][$col_index] =$pro_details->field_rated_voltage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][5][$col_index] =$pro_details->field_operating_voltage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][6][$col_index] =$pro_details->field_frequency["und"][0]["value"];
			              		$arr_rel_prod[$table_index][7][$col_index] =$pro_details->field_rated_wattage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][8][$col_index] =$pro_details->field_total_wattage["und"][0]["value"];
			              		$arr_rel_prod[$table_index][9][$col_index] =$pro_details->field_cct["und"][0]["value"];
			              		$arr_rel_prod[$table_index][10][$col_index] =$pro_details->field_luminous_flux["und"][0]["value"];
			              		$arr_rel_prod[$table_index][11][$col_index] =number_format($pro_details->list_price, 2, '.', '');
			              		$arr_rel_prod[$table_index]["last_index"] = 11;
			              	break;
		              		
              			}
              		 	
              		 }
              		 
		             $prev_subcat = $current_subcat;
              		 
              		
              }
              ?>
              
              <?php
              $rel_index =0 ;
              
              	foreach($arr_rel_prod as $table)
              	{
              	?>
              		<div class="table_info">
	                <div class="table_left"> 
	                <?php if($table["subcategroy"] != "")
		              	$temp_scategory = taxonomy_term_load($table["subcategroy"]);
		              	$category_image ="";
		              	$category_remote_image="";
						if ($cat_image = field_get_items('taxonomy_term', $temp_scategory, 'field_home_featured_banner')) {
						  $uri = $cat_image[0]['uri'];
						  $category_remote_image = file_create_url($uri);
						}
              			if ($cat_image = field_get_items('taxonomy_term', $temp_scategory, 'field_cat_image')) {
						  $uri = $cat_image[0]['uri'];
						  $category_image = file_create_url($uri);
						}
	                {?>
	                <img src="<?php echo  $category_image ?>" title="" alt=""/> 
    	            <img src="<?php echo $category_remote_image?>" title="" alt=""/> </div>
        	        <?php }
        	        $rel_index++;
        	        ?>
        	        <div class="table_right">
                  <table width="100%" cellpadding="0" cellspacing="0">
                <?php 
              		$row_index = 0;
              		 foreach($table as $row)
              		 {
              		 	?>
              		 	<tr class="<?php echo $row_index == 0 ? 'table_head':($row_index==$table["last_index"]?'prices':'') ?>">
              		 	<?php 
              		 	foreach ($row as $col)
              		 	{
              		 		if($row_index==0)
              		 			echo "<th>".$col."</th>";
              		 		else
              		 			echo "<td>".$col."</td>";
              		 	}
              		 	$row_index++;
              		 	?>
              		 	</tr>
              		 <?php 		
              		 }
					?>
					</table>
					</div>
					</div>
				<?php 
              	}
              ?>
              </div>
        </div>
    <?php }?>
        <?php 
			
			//$related_prodcuts =  
		   //here add code for field_not_display_on_any_product display 
	  		//echo "121212".$product->field_not_display_on_any_product;
			//print_r($product);
			
			
			//if($product->field_not_display_on_any_product["und"][0]["value"]) 
			//{
				
			//}
	  ?>
  </div>
</div>
      <!--  content for first lamp end-->
      <?php 	
			}
		} 
	   ?>
       </div>
    </div>
  </div>
<?php 	
}//end of node type
else if($node->type == "page")
{
?>
<div class="content">
    <div class="page_wrapper">
    	<div class="overview_top text_cont">
        <h1><span></span><?php echo $title;?></h1>
        <div class="wrapMid">
        
			<?php
			if(isset($content['field_image']))
			{ 
				print render($content['field_image']);
			}			
			?>
			<?php echo ($node->body['und'][0]['value']);?>
      	</div>
        </div>
    </div>
  </div>
<?php }?>

<script>
  
  jQuery(function() {
  
	

	$("label.error").hide();
		var activeLi=$(".lamps_list li.active").index();
		$('.lamps_list > li .lamp_data').click(function(){
													
		activeLi = $(this).parent('li').attr('rel');
		activeLiPrice = $('#'+activeLi+'_pl').html();
		$("#mrp_code").html(activeLiPrice);
		});
		
		var k="<?php print $i;?>";
		for(var activeLi=0;activeLi < k;activeLi++)
		{
			$('.lamps_list > li .lamp_data').click(function(){										
				activeLi = $(this).parent('li').index();
			});
			$( "#submitfrm"+activeLi).click(function() {
			
			var phone = $("input#mobile1"+activeLi).val();
			var city1 = $("input#city"+activeLi).val();
			var myCity = $(this).parents(".lamps_tab_container").find("#box").text();
			console.log($(this).parents(".lamps_tab_container").find("#box").text());
			var flag1=true;
			var flag2=true;
			var flag3=true;
			if (phone == "" || phone == "Enter Your mobile") 
			{
				$("label#error1"+activeLi).text("Please enter your phone number").show(); //Show error
				flag3=false;
			}
			else if ((phone !== "" && !$.isNumeric(phone)) || phone.length<10 || phone=='' || phone=='0000000000') 
			{
				$("label#error1"+activeLi).text('Please enter valid mobile number').show(); //Show error
				flag1=false;
			}
			
			if ($("select#city"+activeLi).val()=="") 
			{
				$("label#error2"+activeLi).show(); //Show error
				flag2=false;
			}
			
			
			if(flag1==true && flag3==true)
			{
				$("label#error1"+activeLi).hide();
			}
			if(flag2==true)
			{
				$("label#error2"+activeLi).hide();
			}
			
			
			if(flag1==true && flag2==true && flag3==true)
			{
				var temp_url = "http://<?php print $_SERVER['HTTP_HOST'] . '/' . request_uri();?>";
				var data = jQuery("#prdfrm"+activeLi).serialize();
					jQuery.ajax({
					 data: data,
					 type: "post",
					 url: "http://<?php print $_SERVER['HTTP_HOST'] . '/' . request_uri();?>",
					 success: function(data){
						ga('send','event',temp_url, myCity, phone);
						$("#mobile1"+activeLi).val("Enter Your mobile");
						$("#city"+activeLi).val("");
						$("#city"+activeLi+" option[value='']").attr('selected', true)
						
						$("#successMsg"+activeLi).show();
					 }
				});
			}
			else
			{
				return false;
			}
			
		});
		
		
		$(window).keydown(function(event){
		if(event.keyCode == 13) {
		event.preventDefault();
		return false;
		}
		});
		

		/*$("input#mobile1").keydown(function(e)
		{
			var key = e.charCode || e.keyCode || 0;
			return (((key >= 48 && key <= 57) || (key == 8 || key == 46 || key == 16)));
		});*/
	
		$("input#mobile1"+activeLi).keydown(function(e)
		{
			var key = e.charCode || e.keyCode || 0;
			var curchr = $("#mobile1"+activeLi).val().length;
			return (((key >= 96 && key <= 105) || (key >= 48 && key <= 57) || (key == 8 || key == 46 || key == 16 || key == 37 || key == 39)) && (curchr <= 9 || (curchr > 9 && (key == 8 || key == 46 || key == 16 || key == 37 || key == 39))));
		});
		} 
    });
	  
	

  </script>