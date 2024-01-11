<?= $this->extend('layout/sub_layout') ?>

<?php if (session()->getFlashdata('_ci_validation_errors')) :
  $errors = session()->getFlashdata('_ci_validation_errors');
endif; ?>

<?php $open = '';
if (session()->getFlashdata('open')) :
  $open = session()->getFlashdata('open');
endif; ?>

<?php
$session = session()->get('sessionData');
?>

<?= $this->section('content') ?>
<main class="container mt-2 p-2 block">
  <?= $this->include('components/flash_message') ?>
  <div class="flex justify-center items-start gap-2 relative overflow-hidden rounded-md p-4 bg-white">
    <img src="<?= base_url('assets/images/form_goods.jpg') ?>" alt="form_Goods" class="block absolute w-full h-full object-contain lg:relative lg:w-[50%]">
    <div class="w-full md:w-[80%] lg:w-[50%] h-full relative z-10">
      <details open <?= $open ?> class="py-2 px-4 bg-white/80 rounded-md border-2 border-primary/5 accordion cursor-pointer">
        <summary class="text-base font-semibold select-none flex items-center gap-2">
          <img src="<?= base_url('assets/icons/arrow-line-2.svg') ?>" alt="arrow" class="w-[30px] effectTrasition rotate-90">
          <span class="text-primary">Data Barang</span>
        </summary>
        <div class="block w-full mt-4">
          <?php if ($session['role'] === 'gudang' || $session['role'] === 'admin') { ?>
            <form action="<?= site_url() ?>/goods/delete" method="post" class="flex md:justify-between items-center flex-wrap gap-2" id="form_goods_delete">
              <?= csrf_field() ?>
              <input type="hidden" name="goods_code" value="<?= $goods['goods_code'] ?>">
              <input type="text" value="<?= $goods['goods_code'] ?>" class="p-1 border-b-2 border-primary/50 font-semibold bg-white text-primary w-[80%]" disabled>
              <button type="button" class="p-1 lg:p-2 buttonDanger flex justify-center items-center gap-1" onclick="messageConfirmation({ title: 'Hapus Barang', text: 'Apakan anda yakin ingin menghapus \'<?= $goods['goods_name'] ?>\'?', form: 'form_goods_delete' })">
                <img src="<?= base_url('assets/icons/trash-line-white-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
                <img src="<?= base_url('assets/icons/trash-line-red-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
                <span class="font-semibold hidden lg:block">Hapus</span>
              </button>
            </form>
          <?php } ?>
          <form action="<?= site_url() ?>/goods/update" method="post" class="flex flex-col gap-2 mt-4 md:mt-2" id="form_goods_edit">
            <?= csrf_field() ?>
            <div class="flex flex-col justify-center items-start gap-2 w-full">
              <input type="hidden" name="goods_code" value="<?= $goods['goods_code'] ?>">
              <label for="goods_name" class="block w-full">
                <div class="flex justify-between items-center w-full flex-wrap gap-2">
                  <span class="block font-medium text-primary/80 text-sm">Nama Barang</span>
                  <?php if (isset($errors['goods_name'])) : ?>
                    <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['goods_name'] ?>"</span>
                  <?php endif; ?>
                </div>
                <input type="text" id="goods_name" class="p-2 rounded-md font-medium outline-none border-2 border-primary/10 peer focus:border-primary/30 w-full" placeholder="Nama" name="goods_name" value="<?= old('goods_name') ? old('goods_name') : $goods['goods_name'] ?>">
              </label>
              <label for="goods_price" class="block w-full">
                <div class="flex justify-between items-center w-full flex-wrap gap-2">
                  <span class="block font-medium text-primary/80 text-sm">Harga Barang</span>
                  <?php if (isset($errors['goods_price'])) : ?>
                    <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['goods_price'] ?>"</span>
                  <?php endif; ?>
                </div>
                <input type="number" id="goods_price" class="p-2 rounded-md font-medium outline-none border-2 border-primary/10 peer focus:border-primary/30 w-full" placeholder="0" name="goods_price" value="<?= old('goods_price') ? old('goods_price') : $goods['goods_price']  ?>">
                <div class="flex justify-between items-center flex-wrap gap-2">
                  <div class="flex justify-start items-center gap-2 text-sm font-medium text-primary/80 w-max">
                    <span class="block whitespace-nowrap">Harga Sebelumnya : </span>
                    <span class="block whitespace-nowrap">Rp. <?= number_format($goods['goods_prev_price'], 0, ',', '.') ?></span>
                  </div>
                  <h2 class="w-max font-medium text-primary/80 text-start" id="out_price">Rp. 0</h2>
                </div>
              </label>
              <label for="goods_min_stock" class="block w-full">
                <div class="flex justify-between items-center w-full flex-wrap gap-2">
                  <span class="block font-medium text-primary/80 text-sm">Minimal Stok Barang</span>
                  <?php if (isset($errors['goods_min_stock'])) : ?>
                    <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['goods_min_stock'] ?>"</span>
                  <?php endif; ?>
                </div>
                <input type="number" id="goods_min_stock" class="p-2 rounded-md font-medium outline-none border-2 border-primary/10 peer focus:border-primary/30 w-full" placeholder="0" name="goods_min_stock" value="<?= old('goods_min_stock') ? old('goods_min_stock') : $goods['goods_min_stock'] ?>">
              </label>
              <div class="flex flex-col md:flex-row justify-start md:items-center gap-2 font-medium text-sm w-full">
                <span class="block p-2 bg-primary/10 w-max rounded-md">Di tambahkan : <?= $goods['created_at'] ?></span>
                <span class="block p-2 bg-primary/10 w-max rounded-md">Terakhir di ubah : <?= $goods['updated_at'] ?></span>
              </div>
              <h2 class="text-sm font-medium p-2 bg-primary/5 rounded-md w-max">Terakhir di ubah oleh : <?= $goods['users_id'] ?></h2>
            </div>
            <div class="flex justify-end items-center">
              <button type="button" class="buttonWarning p-1 lg:p-2 flex justify-center items-center gap-1" onclick="messageConfirmation({ title: 'Edit Barang', text: 'Apakah anda yakin ingin menyimpan perubahan?', form: 'form_goods_edit' })">
                <img src="<?= base_url('assets/icons/edit-line-white-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
                <img src="<?= base_url('assets/icons/edit-line-yellow-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
                <span class="font-semibold">Edit</span>
              </button>
            </div>
          </form>
        </div>
      </details>
      <details class="py-2 px-4 bg-white/80 rounded-md border-2 border-primary/5 accordion cursor-pointer mt-4">
        <summary class="text-base font-semibold select-none flex items-center gap-2">
          <img src="<?= base_url('assets/icons/arrow-line-2.svg') ?>" alt="arrow" class="w-[30px] effectTrasition rotate-90">
          <span class="text-primary">Perbaharui Stok</span>
        </summary>
        <div class="py-2 flex flex-col gap-4">
          <form action="<?= site_url() ?>/goods/stock" method="post" class="mt-2" id="form_goods_stok">
            <?= csrf_field() ?>
            <input type="hidden" name="goods_code" value="<?= $goods['goods_code'] ?>">
            <div class="flex flex-col gap-4 w-full">
              <label for="goods_stock_warehouse" class="block w-full">
                <div class="flex justify-between items-center w-full flex-wrap gap-2">
                  <span class="block font-medium text-primary/80 text-sm">Stok Gudang</span>
                  <?php if (isset($errors['goods_stock_warehouse'])) : ?>
                    <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['goods_stock_warehouse'] ?>"</span>
                  <?php endif; ?>
                </div>
                <div class="flex justify-center items-center gap-2 flex-wrap md:flex-nowrap">
                  <input type="hidden" id="goods_stock_warehouse" name="goods_stock_warehouse" value="<?= old('goods_stock_warehouse') ? old('goods_stock_warehouse') : $goods['goods_stock_warehouse'] ?>">
                  <h2 id="view_stock_warehouse" class="p-1 lg:p-2 border-2 border-transparent w-full md:w-[50%] block bg-primary font-semibold text-white rounded-md">
                    <?= old('goods_stock_warehouse') ? old('goods_stock_warehouse') : $goods['goods_stock_warehouse'] ?>
                  </h2>
                  <input type="number" id="input_stock_warehouse" class="p-1 lg:p-2 rounded-md font-medium outline-none border-2 border-primary/10 peer focus:border-primary/30 w-full md:w-[50%]" placeholder="0">
                </div>
                <div class="flex justify-end items-center gap-2 mt-2">
                  <button type="button" class="buttonDanger p-1 lg:p-2" onclick="addGoodsQty({getQty: 'goods_stock_warehouse', viewQty: 'view_stock_warehouse', inputQty: 'input_stock_warehouse', oprator: 'minus'})">
                    <img src="<?= base_url('assets/icons/minus-line-white-1.svg') ?>" alt="minus-line" class="w-[20px] h-[20px] object-cover">
                    <img src="<?= base_url('assets/icons/minus-line-red-1.svg') ?>" alt="minus-line" class="w-[20px] h-[20px] object-cover">
                  </button>
                  <button type="button" class="buttonInfo p-1 lg:p-2" onclick="addGoodsQty({getQty: 'goods_stock_warehouse', viewQty: 'view_stock_warehouse', inputQty: 'input_stock_warehouse', oprator: 'plus'})">
                    <img src="<?= base_url('assets/icons/plus-line-white-1.svg') ?>" alt="plus-line" class="w-[20px] h-[20px] object-cover">
                    <img src="<?= base_url('assets/icons/plus-line-blue-1.svg') ?>" alt="plus-line" class="w-[20px] h-[20px] object-cover">
                  </button>
                </div>
              </label>
            </div>
            <div class="flex justify-end items-center w-full mt-4">
              <button type="button" class="buttonWarning p-1 lg:p-2 font-semibold text-white flex justify-center items-center gap-1" onclick="messageConfirmation({ title: 'Perbaharui Stok', text: 'Apakah anda yakin ingin menyimpan perubahan?', form: 'form_goods_stok' })">
                <img src="<?= base_url('assets/icons/update-line-white-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
                <img src="<?= base_url('assets/icons/update-line-yellow-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
                <span>Perbaharui</span>
              </button>
            </div>
          </form>
        </div>
      </details>
    </div>
  </div>
</main>
<?= $this->endSection(); ?>