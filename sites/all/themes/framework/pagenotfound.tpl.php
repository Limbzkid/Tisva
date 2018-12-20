<?php
global $base_url;
?>
<?php
/**
 * @file
 * Custom login page template
 *
 * @ingroup page
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title>TISVA - 404 Error</title>
<link rel="stylesheet" href="<?php echo drupal_get_path('theme', 'tisva') ?>/css/style.css" />
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'tisva') ?>/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'tisva') ?>/js/common.js"></script>


</head>
<body>
	<div class="portrait_overlay"><img src="images/rotate.jpeg" alt="Please rotate your device" title="Please rotate your device" /></div>
	<div class="wrapper">
		<div class="header">
			<div class="page_wrapper">
				<?php $logo = theme_get_setting('logo'); ?>
					<div class="lhs"> <a href="<?php print url(); ?>" class="logo"><img src="<?php print $logo;?>" alt="<?php print t('Home'); ?>" title="<?php print t('Home'); ?>" /></a> </div>
					<div class="rhs">
						<div class="header_right">
							<?php 
								$main_menu= theme_get_setting('toggle_main_menu') ? menu_main_menu() : array();
								$secondary_menu= theme_get_setting('toggle_secondary_menu') ? menu_secondary_menu() : array();
							?>
			
							<?php
								print theme('links__system_main_menu', array(
								'links' => $main_menu,
								'attributes' => array(
								'id' => 'main-menu-links',
								'class' => array('links', 'top_links'),
								))); 
							?>
		
						  <ul class="header_links">
							<li class="products"><span></span><a href="javascript:;">Product Range</a>
								<ul>
							 <?php 
								$vid = taxonomy_vocabulary_machine_name_load("categories")->vid;
								$terms = taxonomy_get_tree($vid,$parent=0, $max_depth=1);
								foreach($terms as $term){
									//echo '<li><span></span><a href="'. $base_url."/".$term->name.'">'.$term->name.'</a></li>';;
									$url = drupal_lookup_path('alias', 'taxonomy/term/'.$term->tid, ''); 
									if($url=='')
										echo '<li><span></span><a href="'. $base_url."/".$term->name.'">'.$term->name.'</a></li>';
									else
										echo '<li><span></span><a href="'. $base_url."/".$url.'">'.$term->name.'</a></li>';
								} 
							?>
								</ul>
							</li>
						<li class="spaces"><span></span><a href="javascript:;">Spaces</a>
							<ul>
							  <?php 
								//rooms 
								$vid = taxonomy_vocabulary_machine_name_load("rooms")->vid;
								$space_terms = taxonomy_get_tree($vid);
								foreach($space_terms as $spaceterm){	
									$class= strtolower(strtr ($spaceterm->name, array (' ' => '_'))); 
									//echo '<li class="'.$class.'"><a href="'. $base_url."/".$spaceterm->name.'">'.$spaceterm->name.'</a></li>';
									$urlSpace = drupal_lookup_path('alias', 'taxonomy/term/'.$spaceterm->tid, ''); 
									if($urlSpace=='')
										echo '<li class="'.$class.'"><a href="'. $base_url."/".$spaceterm->name.'">'.$spaceterm->name.'</a></li>';
									else
										echo '<li class="'.$class.'"><a href="'. $base_url."/".$urlSpace.'">'.$spaceterm->name.'</a></li>';
								}
									?>
							</ul>	
						</li>
						<li class="icons mail"><a href="<?php echo $base_url?>/contact-us">Message</a></li>
						
						<li class="icons location"><a href="<?php echo $base_url?>/store-locator" title="Store Locator">Store Locator</a></li>
						<li class="icons search"><a href="javascript:;" title="Search">Search</a>
						<div class="search_form">
						<form class="search-form" action="<?php global $base_url; print $base_url;?>/search/node" method="post" id="search-form" accept-charset="UTF-8">
							<input id="edit-keys" name="keys"  onfocus="clearText(this)" onblur="clearText(this)" value="Search" maxlength="255" class="form-text" type="text">
							<input name="form_id" value="search_form" type="hidden">
							<input id="edit-submit" name="op" value="Go" class="link_btn" type="submit">
						</form>
					</div>
				</li>
				<li class="call_text">Call us on <span>1800 103 3222</span></li>
          </ul>
        </div>
      </div>
    </div>
</div> <!--<div class="content banner_content">--> 
  <div class="content">
    <div class="page_wrapper">
      <div class="overview_top text_cont">
        
        <img src="<?php echo drupal_get_path('theme', 'tisva') ?>/images/404.jpg" alt="Page not found" title="Page not found" class="page_nt_found" />
      </div>
    </div>
  </div>
<div class="footer">
    <div class="page_wrapper">
      <p>&copy; 2014 Usha International Ltd. All Rights Reserved.</p>
       <?php 
			print theme('links__menu-footer-menu', array('links' => menu_navigation_links('menu-footer-menu'))); 
	?>
    </div>
  </div>	
 </div> 

</div>
	
</body>
</html>
<?php die(); ?>