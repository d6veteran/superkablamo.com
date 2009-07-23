<?php // $Id: block-footer.tpl.php,v 1.1.2.1 2008/09/05 15:30:24 njt1982 Exp $ ?>
<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="block block-<?php print $block->module ?> block-header">
  <div class="content">
    <?php if ($block->subject): print '<h2>'. $block->subject .'</h2>'; endif;?>
    <?php print $block->content ?>
  </div>
</div>
