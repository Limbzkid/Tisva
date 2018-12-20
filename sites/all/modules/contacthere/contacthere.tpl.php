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
<title>TISVA - Contact Us</title>
<link rel="stylesheet" href="<?php echo drupal_get_path('theme', 'tisva') ?>/css/style.css" />
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'tisva') ?>/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'tisva') ?>/js/overview.js"></script>
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'tisva') ?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'tisva') ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'tisva') ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'tisva') ?>/js/additional-methods.js"></script>


</head>
<body class="contactus">
<div class="portrait_overlay">
	<img src="<?php echo base_path().path_to_theme(); ?>/images/rotate.jpeg" alt="Please rotate your device" title="Please rotate your device" />
</div>
<div class="wrapper">
  <div class="header">
    <div class="page_wrapper">
		<?php $logo = theme_get_setting('logo'); ?>
      <div class="lhs"> <a href="<?php print url(); ?>" class="logo"><img src="<?php print $logo;?>" alt="<?php print t('Home'); ?>" title="<?php print t('Home'); ?>" /></a> </div>
      <div class="rhs">
        <div class="header_right">
        	 <?php 
				
				//print render($page['header']); 
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
					//print theme('links__system_secondary_menu', array('links' => $secondary_menu, 'attributes' => array('id' => 'secondary-menu', 'class' => array('links', 'inline', 'clearfix')))); 
					?>
		
          <ul class="header_links">
            <li class="products"><span></span><a href="javascript:;">Product Range</a>
            	<ul>
             <?php 
				$vid = taxonomy_vocabulary_machine_name_load("categories")->vid;
				$terms = taxonomy_get_tree($vid,$parent=0, $max_depth=1);
				foreach($terms as $term){
					echo '<li><span></span><a href="'. $base_url."/".$term->name.'">'.$term->name.'</a></li>';;
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
						echo '<li class="'.$class.'"><a href="'. $base_url."/".$spaceterm->name.'">'.$spaceterm->name.'</a></li>';
					}
						?>
                </ul>	
            </li>
            <li class="icons mail"><a href="<?php echo $base_url?>/contacthere">Message</a></li>
            <!--updated on 10th april 2014 - start-->
            <li class="icons location"><a href="store-locator.html" title="Store Locator">Store Locator</a></li>
            <li class="icons search"><a href="javascript:;" title="Search">Search</a>
            <div class="search_form">
            <form class="search-form" action="<?php global $base_url; print $base_url;?>/search/node" method="post" id="search-form" accept-charset="UTF-8">
                <input id="edit-keys" name="keys"  onfocus="clearText(this)" onblur="clearText(this)" value="Search" maxlength="255" class="form-text" type="text">
                <input name="form_id" value="search_form" type="hidden">
                <input id="edit-submit" name="op" value="Go" class="link_btn" type="submit">
			</form>
			</div>
            </li>
			
            <!--updated on 10th april 2014 - end-->
            <li class="call_text">Call us on <span>1800 103 3222</span></li>
          </ul>
        </div>
      </div>
    </div>
</div>
 <!--<div class="content banner_content">-->
 
  <form name='contactfrm' id="contactfrm" method='post' action=''>
  <div class="content">
    <div class="page_wrapper">
      <div class="overview_top text_cont">
        <h1><span></span>Contact us</h1>
		<?php
				if(isset($_REQUEST['username']) && $_REQUEST['username']!='')
				{
			?>
					<h2 style="color:red;">We will contact you shortly</h2>
			<?php
				}
			?>
        <div class="wrapMid1">
          <div class="frmContact">
            <div class="row">
              <label>Name</label>
              <input type="text" name='username' id='username'/>
            </div>
            <div class="row row1">
              <label>Mobile</label>
              <input type="text" name='mobile1' id='mobile1'/>
              <input type="text" name='mobile2' id='mobile2'/>
            </div>
            <div class="row radioWr">
            	<div class="rad">
                <input id="rdo1" type="radio" name="radio" value="1" class="styled" checked /><label for="rdo1">Product Information</label>
                </div>
              <div class="rad">
                <input id="rdo2" type="radio" name="radio" value="2" class="styled" /><label for="rdo2">Service Request</label>
                </div>
            </div>
            <div class="row">
              <label>Details of query</label>
              <textarea name='query' id='query'></textarea>
            </div>
            <div class="row">
            	<!--<a href="javascript:document.contactfrm.submit();" id='submitform'>Submit</a>-->
				<input type='submit' value='Submit' style="background:#ffffff; color:#000; padding-bottom: 22px;padding-left: 15px;padding-right: 15px;padding-top: 8px; font-size:1.3em; float:left; text-transform:uppercase;cursor:pointer;font-family: 'laconicregular';width:100px;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
 <div class="footer">
    <div class="page_wrapper">
      <p>&copy; <?php print date('Y');?> Usha International Ltd. All Rights Reserved.</p>
       <?php
	   
			print theme('links__menu-footer-menu', array('links' => menu_navigation_links('menu-footer-menu'))); 
	?>
    </div>
  </div> <!-- /.section, /#footer -->
	
 </div> 

</div>
	<script>
  
  // When the browser is ready...
  jQuery(function() {
    // Setup form validation on the #contactfrm element
    
    jQuery("#contactfrm").validate({
    
        // Specify the validation rules
        rules: {
            username: "required",
			mobile1: {
                required: true,
				digits: true,
				maxlength:10,minlength:10
            },
			mobile2: {
                required: false,
                digits: true,
				maxlength:10,minlength:10
            },
            query: "required"
        },

        // Specify the validation error messages
        messages: {
            username: "Please enter your name",
            mobile1: {
                required: "Please enter your phone number",
				maxlength: "Phone number shoud not exceed 10 digit",
				minlength: "Phone number shoud be atleast 10 digit"
				
            },
			mobile2: {
                required: "Please enter your phone number",
				maxlength: "Phone number shoud not exceed 10 digit",
				minlength: "Phone number shoud be atleast 10 digit"

            },
            query: "Please enter your query"
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });
	
    });

  
  </script>

</body>
</html>
