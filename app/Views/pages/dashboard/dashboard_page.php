<?= $this->extend('layout/main') ?>

<?php
$session = session()->get('sessionData');
?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <header class="flex justify-between items-center w-full gap-2">
    <div class="flex justify-center items-center gap-2">
      <h2 class="text-2xl font-semibold text-primary whitespace-normal">Wellcome Dashboard, <span class="text-xl font-semibold text-green-800"><?= $session['username'] ?></span></h2>
    </div>
    <button class="p-2 flex lg:hidden group hover:bg-black/10 rounded-md effectTrasition" onclick="navMobile()">
      <img src="<?= base_url() ?>assets/icons/menu-line-black-1.svg" alt="menu" class="w-[30px] h-[30px] object-cover">
    </button>
  </header>
  <div>
  </div>
</main>
<?= $this->endSection() ?>