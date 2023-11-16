<?= $this->extend('layout/main') ?>

<?php 
$session = session()->get('sessionData');
?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <header class="flex flex-wrap justify-start items-center w-full gap-2">
    <h2 class="text-2xl font-semibold text-primary">Wellcome Dashboard, </h2>
    <h2 class="text-xl font-semibold text-green-800"><?= $session['username'] ?></h2>
  </header>
  <div>
  </div>
</main>
<?= $this->endSection() ?>