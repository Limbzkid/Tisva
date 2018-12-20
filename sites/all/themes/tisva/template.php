<?php

/**
 * Add body classes if certain regions have content.
 */
function tisva_preprocess_html(&$variables) {
  // Add conditional stylesheets for IE
  drupal_add_css(path_to_theme() . '/css/ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
  drupal_add_css(path_to_theme() . '/css/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'IE 6', '!IE' => FALSE), 'preprocess' => FALSE));
  drupal_add_css(path_to_theme() . '/css/style.css');
  drupal_add_js(drupal_get_path('theme', 'tisva') . '/js/jquery-1.4.2.min.js', array( 
    'scope' => 'header', 
    'weight' => '15' 
  ));
  drupal_add_js(drupal_get_path('theme', 'tisva') . '/js/jquery.easing.1.3.js', array( 
    'scope' => 'header', 
    'weight' => '15' 
  ));
  drupal_add_js(drupal_get_path('theme', 'tisva') . '/js/common.js', array( 
    'scope' => 'header', 
    'weight' => '15' 
  ));
 /* drupal_add_js(drupal_get_path('theme', 'tisva') . '/js/homepage.js', array( 
    'scope' => 'header', 
    'weight' => '15' 
  ));
  
  drupal_add_js(drupal_get_path('theme', 'tisva') . '/js/pro_details.js', array( 
    'scope' => 'header', 
    'weight' => '15' 
  ));
  drupal_add_js(drupal_get_path('theme', 'tisva') . '/js/overview.js', array( 
    'scope' => 'header', 
    'weight' => '15' 
  ));*/	 
  //$variables['node'] = $variables['page']['node'];
  
   if(isset($variables['is_front']) && ($variables['is_front']) == 1)
   {
   
	   	$gsv = array(
		'#tag' => 'meta',
		'#attributes' => array(
		'name' => 'google-site-verification',
		'content' => 'HLUkhypZjnuq6RkoV-HNIiQ4H_iUjSn6wh-O0unMIIc',
		),
		);
		drupal_add_html_head($gsv, 'google-site-verification');
   }
   
}

/**
 * Override or insert variables into the page template for HTML output.
 */
function tisva_process_html(&$variables) {
//$vars = &$variables;
//print_r($vars);


}

function tisva_preprocess_page(&$variables, $hook) {
	if(isset($variables["#views_contextual_links_info"]))
	{
		if($variables["#views_contextual_links_info"]["view_ui"]["view"]->name == "storelocater")
		{
			$variables['theme_hook_suggestions'][]= 'page__'. "storelocater";
		} 
		
	}
	if(!isset($variables["node"]))
	{	
		$variables['tisva']['mode'] = "teaser";
	}
	if(isset($variables["page"]["content"]["system_main"]["nodes"]))
	{
		$count =  count($variables["page"]["content"]["system_main"]["nodes"])-1;
		if($count > 0)
		{
			$keys = array_keys($variables["page"]["content"]["system_main"]["nodes"]);
			foreach ($keys as $key)
			{
				$variables["page"]["content"]["system_main"]["nodes"][$key]['#node']->total_count = $count;
			}
		}
	}
	return $variables;
}
/**
 * Override or insert variables into the page template.
 */
function tisva_process_page(&$variables) {
	
	
}

/**
 * Implements hook_preprocess_maintenance_page().
 */
function tisva_preprocess_maintenance_page(&$variables) {
}

/**
 * Override or insert variables into the maintenance page template.
 */
function tisva_process_maintenance_page(&$variables) {
  // Always print the site name and slogan, but if they are toggled off, we'll
  // just hide them visually.
  $variables['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $variables['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
  if ($variables['hide_site_name']) {
    // If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
    $variables['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
  }
  if ($variables['hide_site_slogan']) {
    // If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
    $variables['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
  }
}

/**
 * Override or insert variables into the node template.
 */
function tisva_preprocess_node(&$variables) {
  	
  if ($variables['view_mode'] == 'teaser' && $variables['node']->type == "product") 
  {
    $variables['theme_hook_suggestions'][]= 'node__'. $variables['node']->type .'__teaser';
    if(isset($variables['node']->total_count)){
    	 $variables['tisva']['node_count'] = $variables['node']->total_count;
	} 
	else
	{
		$variables['tisva']['node_count'] = $variables['tisva']['node_count'];
	}
  }
else if ($variables['view_mode'] == 'full' && $variables['node']->type == "product") 
  {
    $variables['theme_hook_suggestions'][]= 'node__'. $variables['node']->type .'__full';
   
  }
 else if ($variables['node']->type == "store_location")
  {
  	//$variables['theme_hook_suggestions'][]= 'node__'. "storelocater";
  }

}


/**
 * Override or insert variables into the block template.
 */
function tisva_preprocess_block(&$variables) {
  
}

/**
 * Implements theme_menu_tree().
 */
function tisva_menu_tree($variables) {
  
}

/**
 * Implements theme_field__field_type().
 */
function tisva_field__taxonomy_term_reference($variables) {
}


//Get Lamp li element classs 
function GetLampCss($cnt) {
	if($cnt<>"") {
		switch ($cnt)	{
			case "1":
				$cls =  "one_lamp";
				break;
			case "2":
				$cls = "two_lamps";
				break;
			case "3":
				$cls = "three_lamps";
				break;
			case "4":
				$cls = "four_lamps";
				break;
			case "5":
				$cls = "five_lamps";
				break;
		}
	}
	if($cls<>"") return $cls; 
    else return "";
}
