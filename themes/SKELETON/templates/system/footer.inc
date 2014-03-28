<?php if ($page['footer']): ?>
  <footer>
    <?php print render($page['footer']); ?>
  </footer>
<?php endif; ?>

<?php if ($page['edit_sidebar']): ?>
  <div id="edit-sidebar" class="hide-for-small">
    <div class="handle"><span></span></div>
    <?php print render($page['edit_sidebar']); ?>
  </div>
<?php endif; ?>
