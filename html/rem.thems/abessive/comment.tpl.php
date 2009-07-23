<?php // $Id: comment.tpl.php,v 1.1.2.1 2008/09/05 15:30:24 njt1982 Exp $ ?>
<div class="comment<?php print $comment->new ? ' comment-new' : ''; print $comment->status == COMMENT_NOT_PUBLISHED ? ' comment-unpublished' : ''; ?> clear-block">
  <?php print $picture ?>

<?php if ($comment->new) : ?>
  <a id="new"></a>
  <span class="new"><?php print $new ?></span>
<?php endif; ?>

  <h3><?php print $title ?></h3>

  <div class="submitted">
    <?php print $submitted ?>
  </div>

  <div class="content">
    <?php print $content ?>
  </div>

  <?php print $links ?>
</div>
