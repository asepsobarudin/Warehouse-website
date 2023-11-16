<?php if (session()->getFlashdata('success')) : ?>
  <input type="hidden" id="notification_value" value="<?= session()->getFlashdata('success') ?>">
<?php endif; ?>
<?php if (session()->getFlashdata('errors')) : ?>
  <input type="hidden" id="notification_value" value="<?= session()->getFlashdata('errors') ?>">
<?php endif; ?>