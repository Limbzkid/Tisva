<?php 
?>
<?php
global $base_url;
?>
<div class="portrait_overlay">
	<img src="<?php echo base_path().path_to_theme(); ?>/images/rotate.jpeg" alt="Please rotate your device" title="Please rotate your device" />
</div>
<div class="wrapper">
<?php include 'includes/header.inc';?>
 <!--<div class="content banner_content">-->
 <?php 
 //print_r($tisva["mode"]);
if($tisva['mode']=="teaser")
{
?>
<div class="content">
    <div class="page_wrapper">
    	<?php print render($page['content']);?>
    </div>
 </div> 	
<?php 
}
else 
{
	print render($page['content']);	
}
 
 ?>
<?php include 'includes/footer.inc';?>
 </div> 
 <script type="text/javascript" src="<?php echo $base_url."/" .drupal_get_path('theme', 'tisva') ?>/js/pro_details.js"></script>
 <script type="text/javascript" src="<?php echo $base_url."/" .drupal_get_path('theme', 'tisva') ?>/js/overview.js"></script>