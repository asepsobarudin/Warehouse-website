<?php if (session()->getFlashdata('success')) : ?>
  <textarea id="notification_value" class="hidden"><?= session()->getFlashdata('success') ?></textarea>
<?php endif; ?>
<?php if (session()->getFlashdata('errors')) : ?>
  <textarea id="notification_value" class="hidden"><?= session()->getFlashdata('errors') ?></textarea>
<?php endif; ?>