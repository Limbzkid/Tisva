<div class="header">
    <div class="page_wrapper">
      <div class="lhs">  
	  <?php if ($logo): ?>
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
    <?php endif; 
		// check if front page 
		if(drupal_is_front_page())
		{
			// load sidebar 
			if ($page['sidebar_first']): ?>
	 	     	<?php print render($page['sidebar_first']); ?>
    		  <!-- /.section, /#sidebar-second -->
		    <?php endif;
		}
	?> 
	
	</div>
	  <div class="rhs_overlay"></div>
      <div class="rhs">
        <div class="header_right">
		  <?php if ($main_menu): ?>
			<?php print theme('links__system_main_menu', array(
			  'links' => $main_menu,
			  'attributes' => array(
				'id' => 'main-menu-links',
				'class' => array('links', 'top_links'),
			  ),
			  'heading' => array(
				'text' => t('Main menu'),
				'level' => 'h2',
				'class' => array('element-invisible'),
			  ),
			)); ?>
		<?php endif; ?>
		 </div>
      </div>
    </div>
  </div>