<?php
/**
 * Implements hook_html_head_alter().
 * We are overwriting the default meta character type tag with HTML5 version.
 */
function framework_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function framework_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $heading = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
    // Uncomment to add current page to breadcrumb
	// $breadcrumb[] = drupal_get_title();
    return '<nav class="breadcrumb">' . $heading . implode(' » ', $breadcrumb) . '</nav>';
  }
}

/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function framework_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }
  return $output;
}

/**
 * Override or insert variables into the node template.
 */
function framework_preprocess_node(&$variables) {
  $variables['submitted'] = t('Published by !username on !datetime', array('!username' => $variables['name'], '!datetime' => $variables['date']));
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
}

/**
 * Preprocess variables for region.tpl.php
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
function framework_preprocess_region(&$variables, $hook) {
  // Use a bare template for the content region.
  if ($variables['region'] == 'content') {
    $variables['theme_hook_suggestions'][] = 'region__bare';
  }
	if ($variables['region'] == 'highlighted') {
    $variables['classes_array'][] = 'owl-vfapp';
  }
	
	
}

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function framework_preprocess_block(&$variables, $hook) {
  // Use a bare template for the page's main content.
  if ($variables['block_html_id'] == 'block-system-main') {
    $variables['theme_hook_suggestions'][] = 'block__bare';
  }
  $variables['title_attributes_array']['class'][] = 'block-title';
}

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function framework_process_block(&$variables, $hook) {
  // Drupal 7 should use a $title variable instead of $block->subject.
  $variables['title'] = $variables['block']->subject;
}

/**
 * Changes the search form to use the "search" input element of HTML5.
 */
function framework_preprocess_search_block_form(&$vars) {
  $vars['search_form'] = str_replace('type="text"', 'type="search"', $vars['search_form']);
}

function product_catalogs() {
	global $base_url;
	$output = '';
	$vid = taxonomy_vocabulary_machine_name_load("categories")->vid;
	$terms = taxonomy_get_tree($vid,$parent=0, $max_depth=1);
	foreach($terms as $term){
		$url = drupal_lookup_path('alias', 'taxonomy/term/'.$term->tid, '');
		if($url=='') {
			$output .= '<li><a href="'.$base_url."/".$term->name.'"><span>'. $term->name .'</span></a></li>';
		} else {
			$output .= '<li><a href="'.$base_url."/".$url.'"><span>'. $term->name .'</span></a></li>';
		}
	}
	return $output;
}

function spaces_catalog() {
	global $base_url;
	$output = '';
	$vid = taxonomy_vocabulary_machine_name_load("rooms")->vid;
	$space_terms = taxonomy_get_tree($vid);
	foreach($space_terms as $spaceterm){
		if($spaceterm->name != 'NA') {
			$class= strtolower(strtr ($spaceterm->name, array (' ' => '_')));  
			$urlSpace = drupal_lookup_path('alias', 'taxonomy/term/'.$spaceterm->tid, ''); 
			if($urlSpace=='') {
				$output .= '<li><a href="'. $base_url."/".$spaceterm->name.'"><span>'.$spaceterm->name.'</span></a></li>';
			} else {
				$output .= '<li><a href="'. $base_url."/".$urlSpace.'"><span>'.$spaceterm->name.'</span></a></li>';
			}
		}
	}
	return $output;
}

function home_pdf_download() {
	global $base_url;
	$query = db_select('field_data_field_brochure_pdf', 'bp');
	$query->leftJoin('file_managed', 'fm', 'fm.fid = bp.field_brochure_pdf_fid ');
	$query->fields('fm', array('uri'));
	$result = $query->execute();
	$row = $result->fetchAssoc();
	$pdf_path = file_create_url($row['uri']);
	$filename = explode('/homepage/',$pdf_path);
	return $filename[1];
}

function home_mrp_download() {
	global $base_url;
	$query = db_select('field_data_field_mrp_pdf', 'mrp');
	$query->leftJoin('file_managed', 'fm', 'fm.fid = mrp.field_mrp_pdf_fid');
	$query->fields('fm', array('uri'));
	$result = $query->execute();
	$row = $result->fetchAssoc();
	$mrp_path = file_create_url($row['uri']);
	$filename = explode('/homepage/',$mrp_path);
	return $filename[1];
}