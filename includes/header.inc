<!-- Header.inc text -->
<div class="header">
    <div class="page_wrapper">
      <div class="lhs"> <a href="<?php print $front_page; ?>" class="logo"><img src="<?php print $logo; ?>" alt="TISVA" title="TISVA" /></a> </div>
      <div class="rhs">
        <div class="header_right">
        	<?php //print_r($main_menu); exit();?>
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
					//echo '<li><span></span><a href="'. $base_url."/".$term->name.'">'.$term->name.'</a></li>';;
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
						<li class=" mail"><span class="iconsilluminart"></span><a href="http://tisvailluminology.blogspot.in/" target="_blank">Illuminology</a></li>


            <li class="icons mail"><a href="<?php echo $base_url?>/contact-us">Message</a></li>
            <!--updated on 10th april 2014 - start-->
			<?php
				if(drupal_get_title()=='storelocater')
				{
			?>
					<li class="icons location active">
			<?php
				}
				else
				{
			?>
					<li class="icons location">
			<?php
				}
			?>
			<a href="<?php echo $base_url?>/store-locator" title="Store Locator">Store Locator</a></li>
			<?php
				if(drupal_get_title()=='Search')
				{
			?>
					<li class="icons search active">
			<?php
				}
				else
				{
			?>
					<li class="icons search">
			<?php
				}
			?>
            <a href="javascript:;" title="Search">Search</a>
            <div class="search_form">
            <form class="search-form" action="<?php global $base_url; print $base_url;?>/search/node" method="post" id="search-form" accept-charset="UTF-8">
                <input id="edit-keys" name="keys"  onfocus="clearText(this)" onblur="clearText(this)" value="Search" maxlength="255" class="form-text" type="text">
                <input name="form_id" value="search_form" type="hidden">
                <input id="edit-submit" name="op" value="Go" class="link_btn" type="submit">
			</form>
			</div>
            </li>
			
            <!--updated on 10th april 2014 - end-->
            
          </ul>
        </div>
      </div>
    </div>
</div>