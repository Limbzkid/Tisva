

<?php
	$total_items =  $tisva['node_count'];
	$render_layout =  $id == 1?true:false;
	$change_slide = ($id == 1)? true : ($id%6)==1 ? true:false;
	$end_slide = ($id%6)==0 || $id==(($total_items)) ? true:false;
	$productimg = $node->field_featured_image[und][0][uri];
	//echo $render_layout;
?>
<?php if($id == 1) {?>
	<div class="overview_right">	
      	<div class="product_slider">
       <?php }?> 
       <?php if($change_slide) {?>
     	<div class="product_slide"> 
     	<?php }?>
 		<div class="prod_thumb">
          <div class="prod_img">
			<?php  
				$url = drupal_lookup_path('alias', 'node/'.$node->vid, ''); 
				if($url=='')
					$url = 'node/'.$node->vid;
			?>
			<a href="<?php echo $url; ?>"> 
				<img src="<?php echo image_style_url("uc_product",$productimg)?>" title="<?php $node->title;?>" alt="<?php $node->title;?>">
				<p class="p_thumb_title">
					<?php 
						$explodeTitle=explode('-',$node->title);
						echo $explodeTitle[0];
					?>
				</p>
			</a>
          </div>
          <div class="prod_data">
          	<a href="<?php echo $url; ?>">
            <p class="info_data"><?php echo $node->field_short_title["und"][0]["value"];?></p>
            <p class="p_thumb_title"><?php echo $node->title;?></p></a>
           </div> 
          </div> 
        <?php
        	if($end_slide) { ?>
         </div> 
        <?php }?>    
          
  		<?php 
			
  			if($id == $total_items) 
  			{ 
  				echo "</div>";
         		echo '<ul class="pagination">';
         		echo '<li><a href="javascript:;">&nbsp;</a></li>';
         		$page_ =  $total_items/6;	
         		for($i=0;$i<$page_-1;$i++)
         		{
					echo '<li><a href="javascript:;">&nbsp;</a></li>';
		 		}	
				echo "</ul>";
				echo "</div>";
		 }?>
		
        
       