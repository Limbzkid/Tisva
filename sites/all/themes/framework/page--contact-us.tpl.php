
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
		<div class="homeSlider"><?php print render($page['highlighted']); ?></div> 
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
			<p>Copyright 2014 Usha International Ltd.<br>All Rights Reserved.</p>
			<ul>
				<li><a href="<?php print $base_url; ?>/privacy-policy">Privacy policy</a></li>
				<li><a href="<?php print $base_url; ?>/sitemap">Sitemap</a></li>
				<li><a href="<?php print $base_url; ?>/terms-of-use">Terms of use</a></li>
			</ul>
		</div>
	</div>
</div> <!-- pageWrapper -->
