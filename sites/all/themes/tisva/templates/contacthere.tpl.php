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
<?php
	$metdes='';
	$metkey='';
	$pagetitle='';
	$result1=db_query("SELECT meta_description_metatags_quick FROM field_revision_meta_description WHERE entity_type='taxonomy_term' and entity_id='55'");
	$metdes = $result1->fetchField(0);
	$result2=db_query("SELECT meta_keywords_metatags_quick FROM field_revision_meta_keywords  WHERE entity_type='taxonomy_term' and entity_id='55'");
	$metkey = $result2->fetchField(0);
	$result3=db_query("SELECT meta_meta_title_metatags_quick FROM field_revision_meta_meta_title WHERE entity_type='taxonomy_term' and entity_id='55'");
	$pagetitle = $result3->fetchField(0);
	
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
	if($pagetitle!='') { ?>
	<title><?php print $pagetitle; ?></title>
<?php }
?>

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
		<p class="call_text">Call us on 1800 103 3222</p>
          <ul class="header_links">
            <li class="products"><span></span><a href="javascript:;">Product Range</a>
            	<ul>
             <?php 
				$vid = taxonomy_vocabulary_machine_name_load("categories")->vid;
				$terms = taxonomy_get_tree($vid,$parent=0, $max_depth=1);
				foreach($terms as $term){
				
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
						$urlSpace = drupal_lookup_path('alias', 'taxonomy/term/'.$spaceterm->tid, ''); 
						if($urlSpace=='')
							echo '<li class="'.$class.'"><a href="'. $base_url."/".$spaceterm->name.'">'.$spaceterm->name.'</a></li>';
						else
							echo '<li class="'.$class.'"><a href="'. $base_url."/".$urlSpace.'">'.$spaceterm->name.'</a></li>';
							
						$class= strtolower(strtr ($spaceterm->name, array (' ' => '_'))); 
						//echo '<li class="'.$class.'"><a href="'. $base_url."/".$spaceterm->name.'">'.$spaceterm->name.'</a></li>';
					}
						?>
                </ul>	
            </li>
						<li class=" mail"><span class="iconsilluminart"></span><a href="https://illuminologybytisva.wordpress.com/" target="_blank">Illuminology</a></li>


            <li class="icons mail active"><a href="<?php echo $base_url?>/contact-us">Message</a></li>
            
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
			
         
            
          </ul>
        </div>
      </div>
    </div>
</div>
 <!--<div class="content banner_content">-->
   <form name='contactfrm' id="contactfrm" method='post' action=''>
   <input type="hidden" name='cpt' id='cpt' value=''/>
   <input type="hidden" name='cptFlag' id='cptFlag' value='0'/>
  <div class="content">
    <div class="page_wrapper">
      <div class="overview_top text_cont">
        <h1><span></span>Contact us</h1>
		<?php
				if(isset($_REQUEST['username']) && $_REQUEST['username']!='')
				{
					//print_r($_REQUEST);
			?>
					<h2 style="color:red;">We will contact you shortly</h2>
			<?php
				}
			?>
        <div class="wrapMid1">
          <div class="frmContact">
            <div class="row">
              <label>Name</label>
              <input type="text" name='username' id='username' maxlength="50" autocomplete="off"/>
            </div>
            <div class="row row1">
              <label>Mobile</label>
              <input type="number" name='mobile1' id='mobile1' maxlength="10" autocomplete="off" max="9999999999"/>
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
              <textarea name='query' id='query' maxlength="255" onKeyPress="lengthTextarea();" onblur="lengthTextarea()" onfocus="lengthTextarea();" onclick="lengthTextarea();"></textarea>
			  <label for="query" class="error"></label>
            </div>
			
			<div class="row row1">
				<label>Please Verify </label>
				<div>
					<img src="includes/cool-php-captcha/captcha.php" id="captcha" style="float:left;"/>
				
					<a onclick="document.getElementById('captcha').src='includes/cool-php-captcha/captcha.php?'+Math.random();
			document.getElementById('captcha-form').focus();" id="change-image" style="margin-left:10px;">Refresh Image</a>
				</div>
				<br clear="all">
				<div>
					<input type="text" name="captcha" id="captcha-form" autocomplete="off" style="margin-top: 12px;" />
					<label for="captcha-form" class="error" style="display:none;">Please enter your captcha</label>
				</div>
            </div>
            <div class="row">
            	<!--<a href="javascript:document.contactfrm.submit();" id='submitform'>Submit</a>-->
				<input type="submit" value="Submit" name="Submit" style="background:#ffffff; color:#000; padding-bottom: 22px;padding-left: 15px;padding-right: 15px;padding-top: 8px; font-size:1.3em; float:left; text-transform:uppercase;cursor:pointer;font-family: 'laconicregular';width:100px;height:30px;" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
 <div class="footer">
    <div class="page_wrapper">
      <p>&copy; 2014 Usha International Ltd. All Rights Reserved.</p>
       <?php //links__system_main_menu menu-footer-menu
			print theme('links__menu-footer-menu', array('links' => menu_navigation_links('menu-footer-menu'))); 
	?>
    </div>
  </div>	
 </div> 

</div>
	<script>
  
  // When the browser is ready...
  jQuery(function() {
  

    // Setup form validation on the #contactfrm element
    jQuery.validator.addMethod("loginRegex", function(value, element) {
		return this.optional(element) || /^[a-z .\']+$/i.test(value);
		}, "Username must contain only letters, dot, space and single quotes.");
		
	jQuery.validator.addMethod('integer', function (value, element, param) {
        return (value != 0) && (value == parseInt(value, 10));
    }, 'Please enter a non zero integer value!');
		
		
    jQuery("#contactfrm").validate({
		
        // Specify the validation rules
        rules: {
			username: {
                required: true,
				loginRegex: true,
				maxlength:50,minlength:2
            },
			mobile1: {
                required: true,
				digits: true,
				integer: true,
				maxlength:10,minlength:10
            },
			query: {
                required: true,
				maxlength:255
            },
			captcha: "required"
        },

        // Specify the validation error messages
        messages: {
			username: {
                required: "Please enter your name",
				maxlength: "Name should be 20 digit",
				minlength: "Name should be atleast 2 digit"
				
            },
            mobile1: {
                required: "Please enter your phone number",
				maxlength: "Phone number should not exceed 10 digit",
				minlength: "Phone number should be atleast 10 digit"
				
            },
			captcha:"Please enter your captcha",
			query: {
                required: "Please enter your query",
				maxlength: "Query should contain only 255 character"
            }
        },
        
        submitHandler: function(form) 
		{
			var data = jQuery("#captcha-form").serialize();
			jQuery.ajax({
			 data: data,
			 type: "post",
			 url: "includes/cool-php-captcha/captchaChk.php",
			 success: function(data1){
			 if(data1==0)
			 {
				document.getElementById('captcha').src='includes/cool-php-captcha/captcha.php?'+Math.random();
				document.getElementById('captcha-form').focus();
				$('#captcha-form').val("");
        		$('label[for="captcha-form"]').show();
        		$('label[for="captcha-form"]').text("Please enter correct captcha.");
			 }
			 else
			 {
				$('#cpt').val(document.getElementById('captcha-form').value);
				$('#cptFlag').val("1");
				form.submit();
			 }
				
			 }
			});
        }
    });
	
	
	$("input#mobile1").keydown(function(e)
	{
		var key = e.charCode || e.keyCode || 0;
		var curchr = $("#mobile1").val().length;
		return (((key >= 96 && key <= 105) || (key >= 48 && key <= 57) || (key == 8 || key == 46 || key == 16 || key == 37 || key == 39)) && (curchr <= 9 || (curchr > 9 && (key == 8 || key == 46 || key == 16 || key == 37 || key == 39))));
	});
	
			
    });
	
	function lengthTextarea() { 
	
	
var txts = document.getElementsByTagName('TEXTAREA') 

for(var i = 0, l = txts.length; i < l; i++) {
    if(/^[0-9]+$/.test(txts[i].getAttribute("maxlength"))) { 
    var func = function(event) { 
	if ($("#query").val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) 
	{
		$("#query").val("");
		$('label[for="query"]').show();
		$('label[for="query"]').text("Query should not contain any html script.");
		return false;
	}
    var len = parseInt(this.getAttribute("maxlength"), 10); 
	//alert(this.value.length);
	var keycode;
	if(window.event) keycode = window.event.keyCode;
	else return true;
	//alert(keycode);
	if(keycode!=8 && keycode!=46)
	{
		if(this.value.length > len) { 
		  //alert('Maximum length exceeded: ' + len); 
		  this.value = this.value.substr(0, len); 
		  return false; 
		} 
	}
  }

  
   txts[i].onkeyup = func;
   txts[i].onblur = func;
  } 
 } 
}
  </script>

</body>
</html>