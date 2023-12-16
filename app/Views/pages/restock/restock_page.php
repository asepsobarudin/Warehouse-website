<?= $this->extend('layout/main') ?>

<?php
$session = session()->get('sessionData');
$role = $session['role'];
?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <?= $this->include('components/flash_message') ?>
  <div class="flex w-full justify-between items-center my-2 flex-wrap">
    <div class="flex justify-center items-center gap-2 w-max">
      <img src="<?= base_url('assets/icons/van-line-black-1.svg') ?>" alt="van-line" class="w-[40px] h-[40px] object-cover">
      <h2 class="text-2xl text-black font-semibold w-max">Kirim Barang</h2>
    </div>
    <button class="p-2 flex lg:hidden group hover:bg-black/10 rounded-md effectTrasition" onclick="navMobile()">
      <img src="<?= base_url() ?>assets/icons/menu-line-black-1.svg" alt="menu" class="w-[30px] h-[30px] object-cover">
    </button>
    <div class="flex justify-between items-center gap-2 w-full lg:w-max">
      <div class="flex justify-center items-center w-ma">
        <label for="input-date">
          <input type="date" name="input-date" id="input-date" class="block min-w-[100px] outline-none p-2 border-2 border-black/10 focus:border-black/30 rounded-md" value="<?= date('Y-m-d') ?>" onchange="DateRestockList()">
        </label>
        <button type="button" id="button_refresh" class="buttonWarning ml-1 p-1 py-1 w-max" onclick="RestockPageList({url: '<?= site_url() ?>/restock/restock_list'})">
          <img src="<?= base_url('assets/icons/update-line-white-1.svg') ?>" alt="save" class="w-[30px] h-[30px] object-cover">
          <img src="<?= base_url('assets/icons/update-line-yellow-1.svg') ?>" alt="save" class="w-[30px] h-[30px] object-cover">
        </button>
      </div>
      <?php if ($role === 'gudang' || $role === 'admin') { ?>
        <a href="<?= site_url() ?>/restock/create" class="buttonInfo p-1 lg:py-2 lg:pl-4 lg:pr-2 flex justify-center items-center gap-1">
          <img src="<?= base_url('assets/icons/van-line-white-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
          <img src="<?= base_url('assets/icons/van-line-blue-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
          <span class="font-semibold pr-2 hidden lg:block">Kirim Barang</span>
        </a>
      <?php } ?>
    </div>
  </div>
  <div class="block w-full min-h-[75vh]">
    <table class="table w-full my-2">
      <thead>
        <tr>
          <td class="p-2 font-semibold text-center bg-primary text-secondary">#</td>
          <td class="p-2 font-semibold text-center bg-primary text-secondary">
            <span class="hidden md:block">Tanggal</span>
            <span class="block md:hidden">Restock</span>
          </td>
          <td class="p-2 font-semibold text-center bg-primary text-secondary hidden md:table-cell">
            Kode
          </td>
          <td class="p-2 font-semibold text-center bg-primary text-secondary hidden md:table-cell">Status</td>
          <?php if ($role == 'admin') : ?>
            <td class="p-2 font-semibold text-center bg-primary text-secondary hidden md:table-cell">
              <span class="hidden lg:block">Pengirim</span>
              <span class="block lg:hidden">Detail</span>
            </td>
          <?php endif; ?>
          <td class="p-2 font-semibold text-center bg-primary text-secondary hidden lg:table-cell">Jumlah</td>
          <td class="p-2 font-semibold text-center bg-primary text-secondary">Aksi</td>
        </tr>
      </thead>
      <tbody class="restock_page_list" id="restock_page_list">
        <!-- List Restock -->
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