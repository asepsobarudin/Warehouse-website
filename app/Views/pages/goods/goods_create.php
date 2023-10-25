<?= $this->extend('layout/sub_layout') ?>

<?php if (session()->getFlashdata('_ci_validation_errors')) :
  $errors = session()->getFlashdata('_ci_validation_errors');
endif; ?>

<?= $this->section('content') ?>
<main class="container mt-2">
  <form action="<?= base_url('goods/goods_create') ?>" method="post" class="p-2 bg-white rounded-md flex flex-col gap-2">
    <? csrf_field() ?>
    <div class="flex flex-col lg:flex-row justify-center items-start gap-2 w-full">
      <div class="w-full flex flex-col gap-4 py-2">
        <div class="block">
          <label for="goods_name" class="relative flex justify-start items-center">
            <input type="text" id="goods_name" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="Nama" name="goods_name" value="<?= old('goods_name') ?>" autofocus>
            <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Nama Barang</span>
          </label>
          <?php if (isset($errors['goods_name'])) : ?>
            <span class="block text-red-600 text-sm font-medium"><?= $errors['goods_name'] ?></span>
          <?php endif; ?>
        </div>
        <div class="block w-full">
          <div class="flex items-center gap-2">
            <label for="goods_price" class="relative flex justify-start items-center w-[60%]">
              <input type="number" id="goods_price" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="0" name="goods_price" value="<?= old('goods_price') ?>">
              <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Harga</span>
            </label>
            <h2 class="w-[40%] font-semibold text-lg text-black/80" id="out_price">Rp. 0</h2>
          </div>
          <?php if (isset($errors['goods_price'])) : ?>
            <span class="block text-red-600 text-sm font-medium"><?= $errors['goods_price'] ?></span>
          <?php endif; ?>
        </div>
        <div class="block">
          <label for="goods_stok_toko" class="relative flex justify-start items-center">
            <input type="number" id="goods_stok_toko" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-[50%]" placeholder="0" name="goods_stok_toko" value="<?= old('goods_stok_toko') ?>">
            <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Stok Toko</span>
          </label>
          <?php if (isset($errors['goods_stok_toko'])) : ?>
            <span class="block text-red-600 text-sm font-medium"><?= $errors['goods_stok_toko'] ?></span>
          <?php endif; ?>
        </div>
        <div class="block">
          <label for="goods_stok_gudang" class="relative flex justify-start items-center">
            <input type="number" id="goods_stok_gudang" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-[50%]" placeholder="0" name="goods_stok_gudang" value="<?= old('goods_stok_gudang') ?>">
            <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Stok Gudang</span>
          </label>
          <?php if (isset($errors['goods_stok_gudang'])) : ?>
            <span class="block text-red-600 text-sm font-medium"><?= $errors['goods_stok_gudang'] ?></span>
          <?php endif; ?>
        </div>
        <div class="block">
          <label for="goods_min_stok" class="relative flex justify-start items-center">
            <input type="number" id="goods_min_stok" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-[50%]" placeholder="0" name="goods_min_stok" value="<?= old('goods_min_stok') ?>">
            <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Stok Minimal</span>
          </label>
          <?php if (isset($errors['goods_min_stok'])) : ?>
            <span class="block text-red-600 text-sm font-medium"><?= $errors['goods_min_stok'] ?></span>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="flex justify-end items-center">
      <button class="py-2 px-3 bg-sky-600 hover:bg-sky-700 font-semibold text-white rounded-md ease-in-out duration-100 flex justify-center items-center gap-1">
        <span>Simpan</span>
        <img src="<?= base_url('assets/icons/save-line.svg') ?>" alt="save" class="w-[30px] h-[30px]">
      </button>
    </div>
  </form>
</main>
<?= $this->endSection(); ?>