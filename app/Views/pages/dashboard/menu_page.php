<?= $this->extend('layout/main') ?>

<?php
$session = session()->get('sessionData');
$role = $session['role'];
?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <h2 class="w-full font-semibold text-start text-2xl text-primary py-2">List Menu</h2>
  <div class="flex justify-center items-center flex-col gap-4 w-full lg:w-1/2 mt-4">
    <a href="<?= base_url('goods/goods_trash') ?>" class="flex justify-start items-center p-2 gap-2 bg-dark w-full">
      <img src="<?= base_url('assets/icons/trash-line-black-1.svg') ?>" alt="trash-line" class="block w-[30px] h-[30px]">
      <h2 class="font-semibold text-primary text-lg">Data Barang Sampah</h2>
    </a>
    <a href="<?= base_url('restock/restock_trash') ?>" class="flex justify-start items-center p-2 gap-2 bg-dark w-full">
      <img src="<?= base_url('assets/icons/trash-line-black-1.svg') ?>" alt="trash-line" class="block w-[30px] h-[30px]">
      <h2 class="font-semibold text-primary text-lg">Data Restock Sampah</h2>
    </a>
  </div>
</main>
<?= $this->endSection(); ?>