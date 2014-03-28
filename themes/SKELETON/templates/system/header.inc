<?php if ($page['header']): ?>
  <header>
    <div class="container header">
      <div class="row">
        <div class="span12">
          <?php print render($page['header']); ?>
        </div>
      </div>
    </div>
  </header>
<?php endif; ?>

<?php if($messages): ?>
  <div class="container">
    <div class="row">
      <div class="span12">
        <?php print $messages; ?>
      </div>
    </div>
  </div>
<?php endif; ?>
