<?php

/**
 * @file
 * Default theme implementation for displaying search results.
 *
 * This template collects each invocation of theme_search_result(). This and
 * the child template are dependent to one another sharing the markup for
 * definition lists.
 *
 * Note that modules may implement their own search type and theme function
 * completely bypassing this template.
 *
 * Available variables:
 * - $search_results: All results as it is rendered through
 *   search-result.tpl.php
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 *
 *
 * @see template_preprocess_search_results()
 *
 * @ingroup themeable
 */
?>
<?php if ($search_results): ?>
	<div class="content overview_top search_pg" style="min-height: 470px;">
		<h1><span></span><?php print t('Search results');?></h1>
		<ol class="search-results <?php print $module; ?>-results">
			<?php print $search_results; ?>
		</ol>
	</div>
  <?php print $pager; ?>
<?php else : ?>
	<div class="content overview_top search_pg" style="min-height: 470px;">
  <h1><span></span><?php print t('Your search yielded no results');?></h1>
  <?php print search_help('search#noresults', drupal_help_arg()); ?>
  </div>
<?php endif; ?>
