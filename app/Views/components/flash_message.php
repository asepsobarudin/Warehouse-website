<?php if (session()->getFlashdata('success')) : ?>
  <textarea id="notification_value" class="hidden"><?= session()->getFlashdata('success') ?></textarea>
  <!-- <input type="hidden" id="notification_value" value=""> -->
<?php endif; ?>
<?php if (session()->getFlashdata('errors')) : ?>
  <textarea id="notification_value" class="hidden"><?= session()->getFlashdata('errors') ?></textarea>
  <!-- <input type="hidden" id="notification_value" value=""> -->
<?php endif; ?>