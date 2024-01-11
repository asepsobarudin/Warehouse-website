<?= $this->extend('layout/sub_layout') ?>
<?php
$session = session()->get('sessionData');
?>

<?= $this->section('content') ?>
<main class="container flex justify-center items-start min-h-full p-2">
  <?= $this->include('components/flash_message') ?>
  <form action="<?= base_url('auth/remove_online') ?>" method="post" class="w-max h-max p-4 bg-white rounded-md flex flex-col items-center gap-2" id="form_online">
    <?= csrf_field() ?>
    <input type="hidden" name="username" value="<?= $session['username'] ?>">
    <h2 class="text-lg font-medium text-center mb-2">Nampaknya akun dengan username <span class="font-semibold">"<?= $session['username'] ?>"</span> sedang online!</h2>
    <button type="button" class="buttonDanger p-2 flex justify-center items-center gap-2 w-max" onclick="messageConfirmation({ title: 'User online', text: 'Apa anda yakin untuk tetap masuk?', form: 'form_online' })">
      <img src="<?= base_url('assets/icons/log-in-line-white-1.svg') ?>" alt="log-in" class="w-[30px] h-[30px] object-cover">
      <img src="<?= base_url('assets/icons/log-in-line-red-1.svg') ?>" alt="log-in" class="w-[30px] h-[30px] object-cover">
      <h2 class="text-base font-medium">Tetap Masuk</h2>
    </button>
  </form>
</main>
<?= $this->endSection(); ?>