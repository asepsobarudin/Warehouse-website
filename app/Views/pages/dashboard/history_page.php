<?= $this->extend('layout/main') ?>

<?php
$session = session()->get('sessionData');
?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <?= $this->include('components/flash_message') ?>
  <div class="w-full flex justify-between items-center my-2 gap-2 flex-wrap">
    <div class="flex justify-center items-center gap-2 w-max">
      <img src="<?= base_url('assets/icons/history-line-black-1.svg') ?>" alt="box-line" class="w-[40px] h-[40px] object-cover">
      <h2 class="text-2xl text-black font-semibold">History Barang</h2>
    </div>
    <button class="p-2 flex lg:hidden group hover:bg-black/10 rounded-md effectTrasition" onclick="navMobile()">
      <img src="<?= base_url() ?>assets/icons/menu-line-black-1.svg" alt="menu" class="w-[30px] h-[30px] object-cover">
    </button>
    <div class="flex justify-between items-center w-full lg:w-max gap-2">
      <label for="input-date">
        <input type="date" name="input-date" id="input-date" class="block min-w-[100px] outline-none p-2 border-2 border-black/10 focus:border-black/30 rounded-md" value="<?= date('Y-m-d') ?>" onchange="DateHistoryList()" pattern="">
      </label>
      <button type="button" id="button_refresh" class="buttonWarning ml-1 p-1 py-1 w-max" onclick="GoodsHistoryList({url: '<?= site_url() ?>/history/history_list'})">
        <img src="<?= base_url('assets/icons/update-line-white-1.svg') ?>" alt="save" class="w-[30px] h-[30px] object-cover">
        <img src="<?= base_url('assets/icons/update-line-yellow-1.svg') ?>" alt="save" class="w-[30px] h-[30px] object-cover">
      </button>
    </div>
  </div>
  <div class="block">
    <table class="table-auto w-full my-2">
      <thead>
        <tr>
          <td class="p-2 bg-primary text-secondary font-semibold text-center">#</td>
          <td class="p-2 bg-primary text-secondary font-semibold text-center">
            <span class="hidden md:block">Tangal</span>
            <span class="block md:hidden">Detail</span>
          </td>
          <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Nama Barang</td>
          <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Status</td>
          <td class="p-2 bg-primary text-secondary font-semibold text-center hidden lg:table-cell">User</td>
          <td class="p-2 bg-primary text-secondary font-semibold text-center hidden lg:table-cell">Qty</td>
        </tr>
      </thead>
      <tbody class="tabel_history_list" id="tabel_history_list">
        <!-- History -->
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