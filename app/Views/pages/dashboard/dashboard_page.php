<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <header class="flex flex-wrap justify-start items-center w-full gap-2">
    <h2 class="text-lg font-semibold text-primay2">Wellcome Dashboard, </h2>
    <h2 class="text-lg font-semibold text-primay2"><?= session()->get('role') ?></h2>
  </header>
  <div>
  </div>
</main>
<?= $this->endSection() ?>