<?= $this->extend('layout/sub_layout') ?>

<?php if (session()->getFlashdata('_ci_validation_errors')) :
  $errors = session()->getFlashdata('_ci_validation_errors');
endif; ?>
<?php 
$session = session()->get('sessionData')
?>

<?= $this->section('content') ?>
<main class="container my-2 flex flex-col items-center justify-start" id="container_page">
  <?= $this->include('components/flash_message') ?>
  <?= csrf_field() ?>
  <div class="flex justify-center items-start gap-2 w-full">
    <div class="w-full lg:w-[69%] h-[92vh] lg:h-screen overflow-y-scroll scrollBar scrollBarBg scrollBarColors">
      <div class="flex justify-end items-center gap-2 w-full mb-2 px-2">
        <label for="cs_input_search" class="flex justify-center items-center relative w-full md:w-max">
          <input type="text" id="cs_input_search" name="cs_input_search" class="p-2 outline-none rounded-md border-2 border-primary/20 w-full md:w-[250px] lg:w-max focus:border-primary/50 bg-netral" placeholder="Search..." onchange="csSearch({url: '<?= base_url('goods/goods_search') ?>'})">
        </label>
        <button class="p-1 buttonInfo" type="button" id="btn_search" onclick="csSearch({url: '<?= base_url('goods/goods_search') ?>'})">
          <img src="<?= base_url('assets/icons/search-line-white-1.svg') ?>" alt="filter" class="w-[30px] h-[30px] object-cover">
          <img src="<?= base_url('assets/icons/search-line-blue-1.svg') ?>" alt="filter" class="w-[30px] h-[30px] object-cover">
        </button>
      </div>
      <div class="block h-max">
        <table class="table border-collapse rounded-md w-full table-auto">
          <thead>
            <tr>
              <td class="bg-primary text-secondary font-medium p-2 text-center border">No</td>
              <td class="bg-primary text-secondary font-medium p-2 text-center border">
                <span class="hidden lg:block">Nama</span>
                <span class="block lg:hidden">Detail</span>
              </td>
              <td class="bg-primary text-secondary font-medium p-2 text-center border hidden lg:table-cell">Min</td>
              <td class="bg-primary text-secondary font-medium p-2 text-center border hidden lg:table-cell">Stok Toko</td>
              <td class="bg-primary text-secondary font-medium p-2 text-center border hidden lg:table-cell">Stok Gudang</td>
              <td class="bg-primary text-secondary font-medium p-2 text-center border hidden md:table-cell">Aksi</td>
            </tr>
          </thead>
          <tbody class="restock_list_goods" id="restock_list_goods">
            <!-- Goods List -->
          </tbody>
        </table>

        <div class="flex justify-between items-center p-2 gap-2 my-2">
          <div class="paginate_text" id="paginate_text">
          </div>
          <div class="paginate_button" id="paginate_button">
          </div>
        </div>
      </div>
    </div>
    <div class="absolute lg:relative top-0 right-0 restock_cart nonActive effectTrasition" id="restock_cart">
      <?= $this->include('components/restock_cart') ?>
    </div>
  </div>
</main>
<?= $this->endSection(); ?>