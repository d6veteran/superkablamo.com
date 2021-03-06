<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>">
<head>
    <title><?php print $head_title ?></title>
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <?php print $head ?>
    <?php print $styles ?>
    <?php print $scripts ?>
</head>
<body <?php print theme("onload_attribute"); ?>>
<div id="container">
  <div id="header">  <!--<table><tr><td>
	<img src="/filmography/themes/blix/logo.png" alt="logo" /></td>
	<td valign="top">-->
	<h1><a href="<?php print url() ?>" title="<?php print($site_name) ?>"><?php print($site_name) ?></a></h1><!--</td></tr></table>-->
      <div class="slogan"><?php print($site_slogan) ?>
<div id="navigation_search">
    <?php if ($search_box): ?>
		<?php print $search_box ?>
    <?php endif; ?></div>
</div>
  </div>
  <div id="navigation">
  <!--  <?php if ($search_box): ?>
		<?php print $search_box ?>
    <?php endif; ?> -->
    <?php if (isset($primary_links)) : ?>
      <?php print theme('links', $primary_links, array('class' => 'links primary-links')) ?>
    <?php endif; ?>
  </div>
<hr class="low" />
  <div id="content">
    <div class="navigation"> <?php print $breadcrumb ?> </div>
    <?php if ($messages != ""): ?>
    	<div id="message"><?php print $messages ?></div>
    <?php endif; ?>
    <?php if ($mission != ""): ?>
    	<div id="mission"><?php print $mission ?></div>
    <?php endif; ?>
    <?php if ($title != ""): ?>
    	<h2 class="page-title"><?php print $title ?></h2>
    <?php endif; ?>
    <?php if ($tabs != ""): ?>
    	<?php print $tabs ?>
    <?php endif; ?>
    <?php if ($help != ""): ?>
    	<p id="help"><?php print $help ?></p>
    <?php endif; ?>
    <!-- start main content -->
    <?php print($content) ?>
    <!-- end main content -->
  </div>
  <div id="subcontent">
    <?php print $left ?> <?php print $right ?>
  </div>
 <hr class="low" />
  <div id="footer">
      <?php if ($footer_message) : ?>
      	<p><?php print $footer_message;?><?php print $footer ?></p><br />
      <?php endif; ?>
       Copyright &copy; 2009 <a href="http://www.arvoriad.com">Filmography</a> All Rights Reserved.
  </div>
</div>
<?php print $closure;?>
</body>
</html>
