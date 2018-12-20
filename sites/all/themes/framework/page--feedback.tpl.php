<?php

	if(isset($_REQUEST['name']) && isset($_REQUEST['mail']) && isset($_REQUEST['feed'])) {
		$name = filter_xss(trim($_REQUEST['name']));
		$mail = filter_xss(trim($_REQUEST['mail']));
		$feed = filter_xss(trim($_REQUEST['feed']));
		$sub_time = date('Y-m-d H:i:s', REQUEST_TIME);
		$id = db_insert('user_feedback')
					->fields(array(
								'user_name' => $name,
								'user_email' => $mail,
								'user_suggestion'=> $feed,
								'date_of_submission' => $sub_time,
								'token'=> 'mobilemobilemobilemobilemobilemobilemobile',
								'status' => 1,
		))
		->execute();
		if($id) {
			$subject = 'Tisva Mobile Feedback';
			$from=variable_get('site_mail', ini_get('sendmail_from'));
			$to=variable_get('site_mail', ini_get('sendmail_from'));
			$headers = "From: " . strip_tags($mail) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($mail) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			if(mail($to, $subject, $feed, $headers)) {
				$_SESSION['feedback_msg'] = 'Thank you for your feedback';
			} else {
				$_SESSION['feedback_msg'] = 'Failed to send mail.';
			}
		}
		
	}

?>
<?php global $base_url; ?>
<div class="pageWrapper">
  <div class="header">
		<div class="logo">
			<a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" id="logo">
        <img src="<?php print $base_url; ?>/sites/all/themes/framework/logo.gif" alt="<?php print t('Home'); ?>" />
      </a>
		</div>
		<ul class="rhsLinks">
			<li class="searchBtn"><a href="javascript:;"><span>Search</span></a></li>
			<li class="locator"><a href="<?php echo base_path(); ?>store-locator"><span>Store Locator</span></a></li>
			<li class="menuBtn"><a href="javascript:;"><span>Explore</span></a></li>
		</ul>
	</div>  <!-- header-->
	<div class="searchWrapper">
		<form accept-charset="UTF-8" id="search-form" method="post" action="<?php print $base_url; ?>/search/node" class="search-form">
			<div class="inputWrap">
				<input type="text" class="form-text" maxlength="255" value="Search" onblur="clearText(this)" onfocus="clearText(this)" name="keys" id="edit-keys">
				<input type="hidden" value="search_form" name="form_id">
			</div>
			<input type="submit" class="link_btn btnGO" value="Go" name="op" id="edit-submit">
		</form>
		<!--<input name="" type="text" onblur="clearText(this)" onfocus="clearText(this)" value="Search"></div>
		<input name="" type="button" value="GO" class="btnGO">-->
	</div>  <!-- searchWrapper -->
	<div class="navWrapper">
		<div class="scroller">
			<ul>
				<li class="mainLink"><a href="javascript:;"><span>PRODUCT RANGE</span></a>
					<ul class="subLink"><?php print product_catalogs(); ?></ul>
				</li>
				<li class="mainLink"><a href="javascript:;"><span>SPACES</span></a>
					<ul class="subLink"><?php print spaces_catalog(); ?></ul>
				</li>
				<li><a href="http://tisvailluminology.blogspot.in/" target="_blank"><span>ILLUMINOLOGY</span></a></li>
				<li><a href="<?php print $base_url; ?>/contact-us"><span>CONTACT US</span></a></li>
				<li><a href="<?php print $base_url; ?>/store-locator"><span>STORE LOCATOR</span></a></li>
				<li><a href="<?php print $base_url; ?>/about-us"><span>ABOUT US</span></a></li>
			</ul>
		</div>
	</div>   <!-- navWrapper -->
<div class="wrapper">
		<div class="contentWrap">
			<h1>Feedback</h1>
			<?php if(isset($_REQUEST['name']) && $_REQUEST['name']!='') { //print_r($_REQUEST); ?>
				<h2 style="color:red;"><?php echo $_SESSION['feedback_msg']; ?></h2>
			<?php } ?>
			<div class="formWrap">
				<form name='feedbackfrm' id="feedbackfrm" method='post' action='<?php echo base_path(); ?>feedback'>
					<input type="hidden" name='cpt' id='cpt' value=''/>
					<input type="hidden" name='cptFlag' id='cptFlag' value='0'/>
					<div class="fieldWrap">
						<!--<div class="inputWrap">-->
							<input class="inputWrap" type="text" name='name' id='name' maxlength="50" autocomplete="off" placeholder="Name"/>
							<!--<input name="username" id="username" type="text" maxlength="50" autocomplete="off" onblur="clearText(this)" onfocus="clearText(this)" value="Name">-->
						<!--</div>-->
					</div>
					<div class="fieldWrap">
						<!--<div class="inputWrap">-->
							<input class="inputWrap" type="text" name='mail' id='mail' maxlength="50" autocomplete="off" placeholder="Email"/>
							<!--<input type="number" name="mobile1" id="mobile1" maxlength="10" autocomplete="off"  onblur="clearText(this)" onfocus="clearText(this)" value="Mobile">-->								</div>
					<!--</div>-->
		
					<div class="fieldWrap">
						<div class="textAreaWrap">
							<textarea name='feed' id='feed' maxlength="255" placeholder="Feedback" onKeyPress="lengthTextarea();" onblur="lengthTextarea()" onfocus="lengthTextarea();" onclick="lengthTextarea();"></textarea>
						</div>
						<label for="feed" class="error"></label>
					</div>
					<div class="fieldWrap">
						<label>Please Verify</label>
						<div class="captchaImgWrap"><img src="includes/cool-php-captcha/captcha.php" id="captcha" alt="" /></div>
						<a onclick="document.getElementById('captcha').src='includes/cool-php-captcha/captcha.php?'+Math.random();document.getElementById('captcha-form').focus();" id="change-image" class="captchaRefresh">
							<img src="<?php echo base_path(); ?>sites/all/themes/framework/images/btn-refresh.gif" alt="">
						</a>

						<div class="inputCaptcha">
							<input class="inputWrap" type="text" name="captcha" id="captcha-form" autocomplete="off" style="margin-top: 12px;" placeholder="Enter Captcha"/>
							<!--<input name="captcha" type="text" id="captcha-form" autocomplete="off" onblur="clearText(this)" onfocus="clearText(this)" value="Enter Captcha" />-->
						</div>
						<label for="captcha-form" class="error" style="display:none;">Please enter your captcha</label>
					</div>
					 
					<div class="formBtns">
						<input name="Submit" type="submit" value="Submit">
					</div>
				</form>
			</div>
		</div>
	</div> <!-- wrapper -->
  <div class="footerWrap">
		<div class="footer"> 
			<ul class="downloadLinks">
				<li><a href="<?php print $base_url; ?>/downloadBrochureMrp.php?file=<?php print home_pdf_download(); ?>">Brochure</a></li>
				<li><a href="<?php print $base_url; ?>/downloadBrochureMrp.php?file=<?php print home_mrp_download(); ?>">Price List</a></li>
			</ul>
			<a href="javascript:;" class="downloadBtn">Downloads</a>
			<p class="callUs"><span>Call us on</span> 1800 103 3222</p>
		</div>
		
		
	</div>  <!-- footerWrap -->
	<div class="wrapperOverlay"></div>
	<a href="javascript:;" class="footerArrow"></a>
	<div class="fixBandWrap">
		<div class="fixBand">
			<a href="javascript:;" class="footerArrowDown"></a>
			<p>&copy; <?php print date('Y');?> Usha International Ltd. All Rights Reserved.</p>
			<ul>
				<li><a href="<?php print $base_url; ?>/privacy-policy">Privacy policy</a></li>
				<li><a href="<?php print $base_url; ?>/sitemap">Sitemap</a></li>
				<li><a href="<?php print $base_url; ?>/terms-of-use">Terms of use</a></li>
			</ul>
		</div>
	</div>
</div> <!-- pageWrapper -->
<?php unset($_SESSION['feedback_msg']); ?>

		<script>
			// When the browser is ready...
			jQuery(function() {
				//alert('aaaaaaaaaaaaaaaaa');
				// Setup form validation on the #contactfrm element
				jQuery.validator.addMethod("loginRegex", function(value, element) {
					return this.optional(element) || /^[a-z .\']+$/i.test(value);
				}, "Name must contain only letters, dot, space and single quotes.");
					
				jQuery.validator.addMethod('integer', function (value, element, param) {
					return (value != 0) && (value == parseInt(value, 10));
				}, 'Please enter a non zero integer value!');
					
				jQuery("#feedbackfrm").validate({
					// Specify the validation rules
					rules: {
						name: {
							required: true,
							loginRegex: true,
							maxlength:50,minlength:2
						},
						mail: {
							required: true,
							email: true,
							maxlength:50
						},
						feed: {
							required: true,
							maxlength:255
						},
						captcha: "required"
					},
			
					// Specify the validation error messages
					messages: {
						name: {
							required: "Please enter your name",
							maxlength: "Name should be 20 digit",
							minlength: "Name should be atleast 2 digit"	
						},
						mail: {
							required: "Please enter your email",
							
						},
						captcha:"Please enter your captcha",
						feed: {
							required: "Please enter your feedback",
							maxlength: "Query should contain only 255 character"
						}
					},
					submitHandler: function(form) {
						//console.log('sunil');
						//$(".contentWrap h2").remove();
						var data = jQuery("#captcha-form").serialize();
						jQuery.ajax({
							data: data,
							type: "post",
							url: "includes/cool-php-captcha/captchaChk.php",
								success: function(data1) {
									console.log(data1);
								if(data1==0) {
									document.getElementById('captcha').src='includes/cool-php-captcha/captcha.php?'+Math.random();
									document.getElementById('captcha-form').focus();
									$('#captcha-form').val("");
										$('label[for="captcha-form"]').show();
										$('label[for="captcha-form"]').text("Please enter correct captcha.");
									}	else	{
										$('#cpt').val(document.getElementById('captcha-form').value);
										$('#cptFlag').val("1");
										form.submit();
									}
								}
							});
						}
					});
				
				/*$("input#mobile1").keydown(function(e)	{
					var key = e.charCode || e.keyCode || 0;
					var curchr = $("#mobile1").val().length;
					return (((key >= 96 && key <= 105) || (key >= 48 && key <= 57) || (key == 8 || key == 46 || key == 16 || key == 37 || key == 39)) && (curchr <= 9 || (curchr > 9 && (key == 8 || key == 46 || key == 16 || key == 37 || key == 39))));
				});*/
							
			});
				
			function lengthTextarea() { 
				var txts = document.getElementsByTagName('TEXTAREA') 
				for(var i = 0, l = txts.length; i < l; i++) {
					if(/^[0-9]+$/.test(txts[i].getAttribute("maxlength"))) { 
						var func = function(event) { 
							if ($("#feed").val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
								$("#feed").val("");
								$('label[for="feed"]').show();
								$('label[for="feed"]').text("Query should not contain any html script.");
								return false;
							}
							var len = parseInt(this.getAttribute("maxlength"), 10); 
							//alert(this.value.length);
							var keycode;
							if(window.event) keycode = window.event.keyCode;
								else return true;
							//alert(keycode);
							if(keycode!=8 && keycode!=46) {
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