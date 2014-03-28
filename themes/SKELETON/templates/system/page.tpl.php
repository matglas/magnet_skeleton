<div id="wrapper">
  <?php include_once('header.inc'); ?>
  <?php if (isset($is_panelized) && $is_panelized): ?>
    <?php print render($page['content']); ?>
  <?php else: ?>
    <div class="content-wrapper main-content clearfix">
      <div class="container">

        <?php if (isset($title)): ?>
          <h1 class="full-node-title"><?php print check_plain($title); ?></h1>
        <?php endif; ?>

        <?php print render($page['content']); ?>
      </div>
    </div>
  <?php endif; ?>
  <?php include_once('footer.inc'); ?>
</div>
