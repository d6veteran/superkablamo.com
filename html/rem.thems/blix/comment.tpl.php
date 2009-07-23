<div class="comment <?php print ($comment->new) ? 'comment-new' : '' ?>"> 
  <p class="header"><?php if ($comment->new) : ?> 
  <a id="new"></a> <span class="new"><?php print $new ?></span> 
  <?php endif; ?> 
  <?php print $author ?> | <?php print $date ?></p>   
  <div class="content"><?php print $content ?></div> 
  <?php if ($picture) : ?> 
  <br class="clear" /> 
  <?php endif; ?> 
  <p class="postmetadata"><?php print $links ?> &#187;</p> 
</div>