<?= $this->extend('layout/sub_layout') ?>

<?php if (session()->getFlashdata('_ci_validation_errors')) :
  $errors = session()->getFlashdata('_ci_validation_errors');
endif; ?>
<?php
$session = session()->get('sessionData');
?>

<?= $this->section('content') ?>
<main class="container mt-2 p-2 block">
  <?= $this->include('components/flash_message') ?>
  <div class="flex justify-center items-center w-full bg-netral rounded-md p-4 relative overflow-hidden">
    <img src="<?= base_url('assets/images/form_goods.jpg') ?>" alt="form_Goods" class="block absolute w-full h-full object-contain lg:relative lg:w-[50%]">
    <form action="<?= base_url('goods/create') ?>" method="post" class="w-full h-full md:w-[80%] lg:w-[50%] flex flex-col gap-2 relative z-10 bg-netral/80" id="form_goods_create">
      <?= csrf_field() ?>
      <label for="goods_name" class="block w-full">
        <div class="flex justify-between items-center w-full flex-wrap gap-1">
          <span class="block font-medium text-primary/80 text-sm">Nama Barang</span>
          <?php if (isset($errors['goods_name'])) : ?>
            <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['goods_name'] ?>"</span>
          <?php endif; ?>
        </div>
        <input type="text" id="goods_name" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="Nama" name="goods_name" value="<?= old('goods_name') ?>" autofocus>
      </label>
      <div class="block w-full">
        <label for="goods_price" class="block w-full">
          <div class="flex justify-between items-center w-full flex-wrap gap-1">
            <span class="block font-medium text-primary/80 text-sm">Harga</span>
            <?php if (isset($errors['goods_price'])) : ?>
              <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['goods_price'] ?>"</span>
            <?php endif; ?>
          </div>
          <input type="number" id="goods_price" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="0" name="goods_price" value="<?= old('goods_price') ?>">
        </label>
        <h2 class="w-full font-semibold text-base text-black/80 text-end px-2 pt-2" id="out_price">Rp. 0</h2>
      </div>
      <label for="goods_min_stock" class="block w-full">
        <div class="flex justify-between items-center w-full flex-wrap gap-1">
          <span class="block font-medium text-primary/80 text-sm">Minimal Stok</span>
          <?php if (isset($errors['goods_min_stock'])) : ?>
            <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['goods_min_stock'] ?>"</span>
          <?php endif; ?>
        </div>
        <input type="number" id="goods_min_stock" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="0" name="goods_min_stock" value="<?= old('goods_min_stock') ?>">
      </label>
      <label for="goods_stock_shop" class="block w-full">
        <div class="flex justify-between items-center w-full flex-wrap gap-1">
          <span class="block font-medium text-primary/80 text-sm">Stok Toko</span>
          <?php if (isset($errors['goods_stock_shop'])) : ?>
            <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['goods_stock_shop'] ?>"</span>
          <?php endif; ?>
        </div>
        <input type="number" id="goods_stock_shop" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="0" name="goods_stock_shop" value="<?= old('goods_stock_shop') ?>">
      </label>
      <label for="goods_stock_warehouse" class="block w-full">
        <div class="flex justify-between items-center w-full flex-wrap gap-1">
          <span class="block font-medium text-primary/80 text-sm">Stok Gudang</span>
          <?php if (isset($errors['goods_stock_warehouse'])) : ?>
            <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['goods_stock_warehouse'] ?>"</span>
          <?php endif; ?>
        </div>
        <input type="number" id="goods_stock_warehouse" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="0" name="goods_stock_warehouse" value="<?= old('goods_stock_warehouse') ?>">
      </label>
      <div class="flex justify-end items-center w-full mt-4">
        <button type="button" class="buttonSuccess py-2 px-3 font-semibold text-white flex justify-center items-center gap-1" onclick="messageConfirmation({ title: 'Tambah barang', text: 'Apakah anda yakin ingin menyimpan barang?', form: 'form_goods_create' })">
          <img src="<?= base_url('assets/icons/save-line-white-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
          <img src="<?= base_url('assets/icons/save-line-green-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
          <span>Simpan</span>
        </button>
      </div>

    </form>
  </div>
</main>
<?= $this->endSection(); ?>