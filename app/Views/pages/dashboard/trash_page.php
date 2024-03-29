<?= $this->extend('layout/main') ?>

<?php
$session = session()->get('sessionData');
$role = $session['role'];
?>

<?= $this->section('content') ?>
<main class="container p-2 min-h-screen" id="main">
  <header class="flex justify-between items-center my-2">
    <div class="flex justify-center items-center gap-1">
      <img src="<?= base_url() ?>/assets/icons/trash-line-black-1.svg" alt="trash" class="w-[40px] h-[40px] object-cover">
      <h2 class="w-full font-semibold text-start text-2xl text-primary py-2">Trash</h2>
    </div>
    <button class="p-2 flex lg:hidden group hover:bg-black/10 rounded-md effectTrasition" onclick="navMobile()">
      <img src="<?= base_url() ?>assets/icons/menu-line-black-1.svg" alt="menu" class="w-[30px] h-[30px] object-cover">
    </button>
  </header>
  <div class="block w-full">
    <div class="flex justify-start items-center w-full">
      <button id="restock_trash" class="block p-2 border-x-2 border-t-2 cursor-pointer tabActive">
        Restock
      </button>
      <button id="goods_trash" class="block p-2 border-x-2 border-t-2 cursor-pointer">
        Barang
      </button>
    </div>
    <div class="tabActive w-full" id="restock_trash_list">
      <div class="block w-full min-h-[75vh]">
        <table class="table w-full">
          <thead>
            <tr>
              <td class="p-2 bg-primary text-secondary font-semibold text-center">#</td>
              <td class="p-2 bg-primary text-secondary font-semibold text-center">
                <span class="hidden md:block">Tanggal</span>
                <span class="block md:hidden">Detail</span>
              </td>
              <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Kode</td>
              <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Pengirim</td>
              <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Jumlah</td>
              <td class="p-2 bg-primary text-secondary font-semibold text-center">Aksi</td>
            </tr>
          </thead>
          <tbody class="trash_list" id="trash_restock_list">
            <!-- List Trash Restock -->
          </tbody>
        </table>
      </div>
      <div class="flex justify-between items-center p-2 gap-2 my-2">
        <div class="paginate_text" id="paginate_text_restock">
        </div>
        <div class="paginate_button" id="paginate_button_restock">
        </div>
      </div>
    </div>
    <div class="tabNotActive w-full" id="goods_trash_list">
      <div class="block w-full min-h-[75vh]">
        <table class="table w-full">
          <thead>
            <tr>
              <td class="p-2 bg-primary text-secondary font-semibold text-center">#</td>
              <td class="p-2 bg-primary text-secondary font-semibold text-center">
                <span class="hidden md:block">Tanggal</span>
                <span class="block md:hidden">Detail</span>
              </td>
              <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Kode</td>
              <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Nama barang</td>
              <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Oleh</td>
              <td class="p-2 bg-primary text-secondary font-semibold text-center">Aksi</td>
            </tr>
          </thead>
          <tbody class="trash_list" id="trash_goods_list">
            <!-- List Trash Goods -->
          </tbody>
        </table>
      </div>
      <div class="flex justify-between items-center p-2 gap-2 my-2">
        <div class="paginate_text" id="paginate_text_goods">
        </div>
        <div class="paginate_button" id="paginate_button_goods">
        </div>
      </div>
    </div>
  </div>
</main>
<?= $this->endSection(); ?>