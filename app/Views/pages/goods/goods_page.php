<?= $this->extend('layout/main') ?>

<?php
$session = session()->get('sessionData');
$role = $session['role'];
?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <?= $this->include('components/flash_message') ?>
  <div class="w-full flex justify-between items-center my-4 gap-2 flex-wrap">
    <div class="flex justify-center items-center gap-2 w-max">
      <img src="<?= base_url('assets/icons/box-line-black-1.svg') ?>" alt="box-line" class="w-[40px] h-[40px] object-cover">
      <h2 class="text-2xl text-black font-semibold">Barang</h2>
    </div>
    <button class="p-2 flex lg:hidden group hover:bg-black/10 rounded-md effectTrasition" onclick="navMobile()">
      <img src="<?= base_url() ?>assets/icons/menu-line-black-1.svg" alt="menu" class="w-[30px] h-[30px] object-cover">
    </button>
  </div>
  <div class="flex justify-between items-center gap-2">
    <div class="flex justify-center md:justify-end items-center min-w-[80%] md:min-w-[350px] gap-2">
      <?= csrf_field() ?>
      <input type="text" name="search" id="search" class="p-2 w-[90%] bg-transparent border-2 border-primary/10 focus:border-primary/30 rounded-md outline-none font-medium text-primary/80" placeholder="Cari barang...">
      <button type="button" id="button_search" class="buttonInfo px-2 py-1 w-max" onclick="GoodsSearchList({ url: '<?= site_url() ?>/goods/goods_search'})">
        <img src="<?= base_url('assets/icons/search-line-white-1.svg') ?>" alt="" class="w-[35px] h-[30px] object-cover">
        <img src="<?= base_url('assets/icons/search-line-blue-1.svg') ?>" alt="" class="w-[35px] h-[30px] object-cover">
      </button>
      <button type="button" id="button_refresh" class="buttonWarning px-2 py-1 w-max" onclick="GoodsPageList({url: '<?= site_url() ?>/goods/goods_list'})">
        <img src="<?= base_url('assets/icons/update-line-white-1.svg') ?>" alt="save" class="w-[35px] h-[30px] object-cover">
        <img src="<?= base_url('assets/icons/update-line-yellow-1.svg') ?>" alt="save" class="w-[35px] h-[30px] object-cover">
      </button>
    </div>
    <?php if ($role === 'gudang' || $role === 'admin') { ?>
      <a href="<?= base_url("goods/create") ?>" class="p-1 md:p-2 buttonInfo flex justify-center items-center gap-1">
        <img src="<?= base_url('assets/icons/add-line-white-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
        <img src="<?= base_url('assets/icons/add-line-blue-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
        <span class="font-medium hidden lg:block">Tambah Barang</span>
      </a>
    <?php } ?>
  </div>
  <div class="block w-full min-h-[65vh]">
    <table class="table-auto w-full my-2">
      <thead>
        <tr>
          <td class="p-2 bg-primary text-secondary font-semibold text-center">#</td>
          <td class="p-2 bg-primary text-secondary font-semibold text-center">
            <span class="hidden md:block">Kode</span>
            <span class="block md:hidden">Detail</span>
          </td>
          <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Nama</td>
          <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">
            <span class="hidden lg:block">Harga</span>
            <span class="block lg:hidden">Detail</span>
          </td>
          <td class="p-2 bg-primary text-secondary font-semibold text-center hidden lg:table-cell">Stok</td>
          <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Aksi</td>
        </tr>
      </thead>
      <tbody class="goods_page_list" id="goods_page_list">
        <!-- List Goods -->
      </tbody>
    </table>
  </div>
  <div class="flex justify-between items-center p-2 gap-2 my-2">
    <div class="paginate_text" id="paginate_text">
    </div>
    <div class="paginate_button" id="paginate_button">
    </div>
  </div>
</main>
<?= $this->endSection() ?>