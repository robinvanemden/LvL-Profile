<?php
// $Id: node.tpl.php
?>

<div id="node-<?php print $node->nid; ?>" class="node <?php print $node_classes; ?>">
  <div class="inner">
    <?php if ($picture || ($title && !$page) || $submitted): ?>
    <div class="clearfix">
      <?php print $picture ?>

    
      <?php if ($page == 0): ?>
      <h2 class="title"><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title; ?></a></h2>
      <?php endif; ?>

      <?php if ($submitted): ?>
      <div class="meta">
        <span class="submitted"><?php print $submitted ?></span>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($node_top && !$teaser): ?>
    <div id="node-top" class="node-top row nested">
      <div id="node-top-inner" class="node-top-inner inner">
        <?php print $node_top; ?>
      </div><!-- /node-top-inner -->
    </div><!-- /node-top -->
    <?php endif; ?>

    <div class="content clearfix">
      <?php print $content ?>
    </div>

    <?php if ($terms): ?>
    <div class="terms">
      <?php print $terms; ?>
    </div>
    <?php endif;?>

    <?php if ($links): ?>
    <div class="links">
      <?php print $links; ?>
    </div>
    <?php endif; ?>
  </div><!-- /inner -->

  <?php if ($node_bottom && !$teaser): ?>
  <div id="node-bottom" class="node-bottom row nested">
    <div id="node-bottom-inner" class="node-bottom-inner inner">
      <?php print $node_bottom; ?>
    </div><!-- /node-bottom-inner -->
  </div><!-- /node-bottom -->
  <?php endif; ?>
<div class="node-shadow pngfix"><img src="<?php print base_path(). path_to_theme() ?>/images/node-shadow.png"  height="19" width="100%"  alt="shadow"/></div>
</div><!-- /node-<?php print $node->nid; ?> -->
