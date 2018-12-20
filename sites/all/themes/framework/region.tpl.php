<?php if (!empty($content)): ?>
  <?php if(drupal_is_front_page()): ?>
    <ul class="homeSliderUL">
      <?php print $content; ?>
    </ul>
  <?php else: ?>
    <div class="<?php print $classes; ?>">
      <?php print $content; ?>
    </div>
  <?php endif; ?>
<?php endif; ?> <!-- /.region -->
