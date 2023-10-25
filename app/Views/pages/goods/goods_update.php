<?= $this->extend('layout/sub_layout') ?>

<?php if (session()->getFlashdata('_ci_validation_errors')) :
  $errors = session()->getFlashdata('_ci_validation_errors');
endif; ?>

<?= $this->section('content') ?>
<main class="container mt-2 bg-white rounded-md p-2 flex flex-col gap-2">
  <details class="p-2 bg-white ease-in-out duration-100 rounded-md border-2 border-black/5 accordion cursor-pointer">
    <summary class="text-base font-semibold select-none flex items-center gap-2">
      <img src="<?= base_url('assets/icons/arrow-right-s-line.svg') ?>" alt="arrow" class="w-[30px] duration-200 ease-in-out rotate-90">
      <span>Edit Data Barang</span>
    </summary>
    <div class="py-2 flex flex-col gap-4">
      <form action="<?= base_url('goods/goods_delete') ?>" method="post" class="flex justify-end">
        <?= csrf_field() ?>
        <input type="hidden" name="goods_code" value="<?= $goods['goods_code'] ?>">
        <button type="submit" class="py-2 px-3 bg-delete hover:bg-deleteHover font-semibold text-white rounded-md ease-in-out duration-100 flex justify-center items-center gap-1" onclick="return confirm(`Apakah yakin ingin menghapus <?= $goods['goods_name'] ?>`)">
          <img src="<?= base_url('assets/icons/delete-bin-line.svg') ?>" alt="save" class="w-[30px] h-[30px]">
          <span>Hapus</span>
        </button>
      </form>
      <form action="<?= base_url('goods/goods_update') ?>" method="post" class="flex flex-col gap-2">
        <? csrf_field() ?>
        <div class="flex flex-col justify-center items-start gap-2 w-full">
          <div class="block w-full">
            <input type="hidden" name="goods_code" value="<?= $goods['goods_code'] ?>">
            <label for="goods_name" class="relative flex justify-start items-center">
              <input type="text" id="goods_name" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="Nama" name="goods_name" value="<?= old('goods_name') ? old('goods_name') : $goods['goods_name'] ?>" autofocus>
              <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Nama Barang</span>
            </label>
            <?php if (isset($errors['goods_name'])) : ?>
              <span class="block text-red-600 text-sm font-medium mt-1"><?= $errors['goods_name'] ?></span>
            <?php endif; ?>
          </div>
          <div class="block w-full">
            <div class="flex justify-start items-center gap-2 text-sm font-medium text-black/80 px-2 mb-2">
              <span class="block">Harga Sebelumnya : </span>
              <span class="block">Rp. <?= number_format($goods['goods_prev_price'], 0, ',', '.') ?></span>
            </div>
            <div class="flex items-center gap-2">
              <label for="goods_price" class="relative flex justify-start items-center w-[60%]">
                <input type="number" id="goods_price" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="0" name="goods_price" value="<?= old('goods_price') ? old('goods_price') : $goods['goods_price']  ?>">
                <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Harga</span>
              </label>
              <h2 class="w-[40%] font-semibold text-lg text-black/80" id="out_price">Rp. 0</h2>
            </div>
            <?php if (isset($errors['goods_price'])) : ?>
              <span class="block text-red-600 text-sm font-medium mt-1"><?= $errors['goods_price'] ?></span>
            <?php endif; ?>
          </div>
          <div class="block w-full">
            <label for="goods_min_stok" class="relative flex justify-start items-center">
              <input type="number" id="goods_min_stok" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-[50%]" placeholder="0" name="goods_min_stok" value="<?= old('goods_min_stok') ? old('goods_min_stok') : $goods['goods_min_stok'] ?>">
              <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Minimal Stok</span>
            </label>
            <?php if (isset($errors['goods_min_stok'])) : ?>
              <span class="block text-red-600 text-sm font-medium"><?= $errors['goods_min_stok'] ?></span>
            <?php endif; ?>
          </div>
          <div class="flex justify-start items-center gap-2 font-medium text-sm w-full">
            <span class="block p-2 bg-black/10 w-max rounded-md">Di tambahkan : <?= $goods['created_at'] ?></span>
            <span class="block p-2 bg-black/10 w-max rounded-md">Terakhir di ubah : <?= $goods['updated_at'] ?></span>
          </div>
          <h2 class="text-base font-medium p-2 bg-black/5 rounded-md w-max">Terakhir di ubah oleh : Kasir 1</h2>
        </div>
        <div class="flex justify-end items-center">
          <button type="submit" class="py-2 px-3 bg-edit hover:bg-editHover rounded-md ease-in-out duration-100 flex justify-center items-center gap-1" onclick="return confirm(`Apakah yakin ingin mengubah <?= $goods['goods_name'] ?>`)">
            <img src="<?= base_url('assets/icons/file-edit-line.svg') ?>" alt="save" class="w-[30px] h-[30px]">
            <span class="font-semibold text-black">Edit</span>
          </button>
        </div>
      </form>
    </div>
  </details>
  <details open class="p-2 bg-white ease-in-out duration-100 rounded-md border-2 border-black/5 accordion cursor-pointer">
    <summary class="text-base font-semibold select-none flex items-center gap-2">
      <img src="<?= base_url('assets/icons/arrow-right-s-line.svg') ?>" alt="arrow" class="w-[30px] duration-200 ease-in-out rotate-90">
      <span>Tambah Barang</span>
    </summary>
    <div class="py-2 flex flex-col gap-4">
      <form action="<?= base_url('goods/goods_stock') ?>" method="post" class="mt-2">
        <input type="hidden" name="goods_code" value="<?= $goods['goods_code'] ?>">
        <div class="flex flex-col gap-4 w-full">
          <div class="block w-full">
            <label for="goods_stok_toko" class="relative flex justify-start items-center">
              <input type="number" id="goods_stok_toko" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-[50%]" placeholder="0" name="goods_stok_toko" value="<?= old('goods_stok_toko') ? old('goods_stok_toko') : $goods['goods_stok_toko'] ?>">
              <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Stok Toko</span>
            </label>
            <?php if (isset($errors['goods_stok_toko'])) : ?>
              <span class="block text-red-600 text-sm font-medium"><?= $errors['goods_stok_toko'] ?></span>
            <?php endif; ?>
          </div>
          <div class="block w-full">
            <label for="goods_stok_gudang" class="relative flex justify-start items-center">
              <input type="number" id="goods_stok_gudang" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-[50%]" placeholder="0" name="goods_stok_gudang" value="<?= old('goods_stok_gudang') ? old('goods_stok_gudang') : $goods['goods_stok_gudang'] ?>">
              <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Stok Gudang</span>
            </label>
            <?php if (isset($errors['goods_stok_gudang'])) : ?>
              <span class="block text-red-600 text-sm font-medium"><?= $errors['goods_stok_gudang'] ?></span>
            <?php endif; ?>
          </div>
          <div class="flex justify-end items-center w-full">
            <button type="submit" class="py-2 px-3 bg-sky-600 hover:bg-sky-700 font-semibold text-white rounded-md ease-in-out duration-100 flex justify-center items-center gap-1" onclick="return confirm(`Apakah yakin ingin mengubah <?= $goods['goods_name'] ?>`)">
              <span>Simpan</span>
              <img src="<?= base_url('assets/icons/save-line.svg') ?>" alt="save" class="w-[30px] h-[30px]">
            </button>
          </div>
        </div>
      </form>
    </div>
  </details>
</main>
<?= $this->endSection(); ?>