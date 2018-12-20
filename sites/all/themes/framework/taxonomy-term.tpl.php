<?php

/**
 * @file
 * Default theme implementation to display a term.
 *
 * Available variables:
 * - $name: (deprecated) The unsanitized name of the term. Use $term_name
 *   instead.
 * - $content: An array of items for the content of the term (fields and
 *   description). Use render($content) to print them all, or print a subset
 *   such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $term_url: Direct URL of the current term.
 * - $term_name: Name of the current term.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - taxonomy-term: The current template type, i.e., "theming hook".
 *   - vocabulary-[vocabulary-name]: The vocabulary to which the term belongs to.
 *     For example, if the term is a "Tag" it would result in "vocabulary-tag".
 *
 * Other variables:
 * - $term: Full term object. Contains data that may not be safe.
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $page: Flag for the full page state.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the term. Increments each time it's output.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_taxonomy_term()
 * @see template_process()
 *
 * @ingroup themeable
 */

?>

<pre><?php //print_r($term); exit; ?></pre>

<?php //echo $term->tid; ?>


<?php if (!$page): ?>
  <h2><a href="<?php print $term_url; ?>"><?php print $term_name; ?></a></h2>
<?php endif; ?>

<?php
	$count = 0;
	$desc = str_replace(' class="MsoNormal"', '', $term->description);
	$word_cnt = str_word_count($desc);
	if($word_cnt > 25) {
		$numwords = 25;
		preg_match("/(\S+\s*){0,$numwords}/", $desc, $regs);
		$shortdesc = trim($regs[0]) .'...';
		$shortdesc = str_replace('<p>', '<p class="shortDesc">',trim($regs[0]) .'...');
		$desc = str_replace('<p>', '<p class="fullDesc dnone">', $desc);
	}
?>

<div class="prodctCatWrap">
	<h1><?php echo $term_name?></h1>
	<?php print $shortdesc . $desc; ?>
	<?php if($term->description): ?>
		<?php if($word_cnt > 25): ?>
			<a class="readMore" href="javascript:;">Read More</a>
		<?php endif; ?>
	<?php endif; ?>
</div>

<?php if($term->vid == 3): ?>
	<?php
		$query = db_select('node', 'n');
		$query->leftJoin('field_revision_taxonomy_catalog', 'rtc', 'rtc.entity_id = n.nid');
		$query->leftJoin('field_revision_field_featured_image', 'upi', 'upi.entity_id = n.nid');
		$query->leftJoin('file_managed', 'fm', 'fm.fid = upi.field_featured_image_fid');
		$query->fields('n', array('nid', 'title', 'created', 'status', 'type'))
					->fields('fm', array('uri'))
					->condition('n.type', array('product'), 'IN')
					->condition('n.status', '1', '=')
					->condition('rtc.taxonomy_catalog_tid', $term->tid, '=')
					->groupBy('n.nid')
					->orderBy('n.created', 'DESC')
					->range(0,6);
		$result = $query->execute();
		foreach($result as $row) {
			$temp = explode(' - ', $row->title);
			$title = $temp[0];
			$img_path = file_create_url($row->uri);
			$path = drupal_get_path_alias('node/'.$row->nid);
			$output .= '<div class="prod_thumb" rel="'.$term->tid.'-'.$row->nid.'-'.$term->vid.'">';
			$output .= '<a href="'.$path.'">';
			$output .= '<span class="prod_img"><img src="'.image_style_url("uc_product",$row->uri).'" alt="'.$row->title.'"></span>';
			$output .= '<span class="prod_title">'.$title.'</span></a></div>';
			$count++;
		}
	?>
<?php endif; ?>

<?php if($term->vid == 6): ?>
<?php
	$query = db_select('node', 'n');
	$query->leftJoin('field_data_field_spaces_applicable', 'fsa', 'fsa.entity_id = n.nid');
	$query->leftJoin('field_revision_field_featured_image', 'upi', 'upi.entity_id = n.nid');
	$query->leftJoin('file_managed', 'fm', 'fm.fid = upi.field_featured_image_fid');
	$query->fields('n', array('nid', 'title', 'created', 'status', 'type'))
					->fields('fm', array('uri'))
					->condition('n.type', array('product'), 'IN')
					->condition('n.status', '1', '=')
					->condition('fsa.field_spaces_applicable_tid', $term->tid, '=')
					->orderBy('n.created', 'DESC')
					->range(0,6);
	$result = $query->execute();
	foreach($result as $row) {
		$temp = explode(' - ', $row->title);
		$title = $temp[0];
		$img_path = file_create_url($row->uri);
		$path = drupal_get_path_alias('node/'.$row->nid);
		$output .= '<div class="prod_thumb" rel="'.$term->tid.'-'.$row->nid.'-'.$term->vid.'">';
		$output .= '<a href="'.$path.'">';
		$output .= '<span class="prod_img"><img src="'.image_style_url("uc_product",$row->uri).'" alt="'.$row->title.'"></span>';
		$output .= '<span class="prod_title">'.$title.'</span></a></div>';
		$count++;
	}
	
?>

<?php endif; ?>

<div class="product-slide"><?php print $output; ?></div>
<?php if($count >=6): ?>
	<div class="loadMoreWrap"><a href="javascript:;" class="loadMore">Load More Products</a></div>
<?php endif; ?>


	      
