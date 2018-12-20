<!-- Common Footer files -->
<div class="footer">
    <div class="page_wrapper">
      <p>&copy; <?php print date('Y');?> Usha International Ltd. All Rights Reserved.</p>
       <?php
	   
			print theme('links__menu-footer-menu', array('links' => menu_navigation_links('menu-footer-menu'))); 
	?>
    </div>
  </div> 
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50085676-2', 'lightsbytisva.com');
  ga('send', 'pageview');

</script>