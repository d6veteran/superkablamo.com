<div class="entry<?php print ($sticky) ? " sticky" : ""; ?>"> 
  <?php if ($page == 0): ?> 
  <h2><a href="<?php print $node_url ?>" rel="bookmark" title="Permanent Link to <?php print $title ?>"><?php print $title ?></a></h2> 
  <?php endif; ?> 
  <?php print $content ?>
  <?php if ($links): ?> 
  <p class="info">Posted in <?php print $terms ?> <?php print $links ?></p>
   <small><?php print $submitted ?></small>
  <?php endif; ?> 
</div>

<hr class="low" />