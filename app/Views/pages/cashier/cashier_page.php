<?= $this->extend('layout/main') ?>

<?= $this->section('content'); ?>
<main class="flex flex-col md:flex-row justify-center w-full h-full md:h-screen overflow-hidden" id="main">
  <div class="container px-2 pt-2 md:pb-[60px] lg:pb-2 overflow-y-scroll scrollBar scrollBarBg scrollBarColors" id="container_page">
    <div class="w-full h-max block">
      <div class="mb-2 flex flex-col md:flex-row justify-center md:justify-between gap-2 items-start md:items-center">
        <h2 class="text-2xl font-medium text-green-600">
          Kasir
        </h2>

        <div class="flex justify-center items-center gap-2 w-full md:w-max">
          <label for="cs_input_search" class="flex justify-center items-center relative w-full md:w-max">
            <input type="text" id="cs_input_search" name="cs_input_search" class="p-2 outline-none rounded-md border-2 border-black/10 w-full md:w-[250px] lg:w-max focus:border-sky-300 bg-white" placeholder="Search..." onchange="csSearch({url: '<?= base_url('goods/goods_search') ?>'})">
          </label>
          <button class="p-[6px] bg-info hover:bg-info ease-in-out duration-100 rounded-md" onclick="csSearch({url: '<?= base_url('goods/goods_search') ?>'})">
            <img src="<?= base_url('assets/icons/search-line.svg') ?>" alt="filter" class="w-[30px] h-[30px] object-cover">
          </button>
        </div>
      </div>

      <table class="table border-collapse rounded-md w-full table-auto">
        <thead>
          <tr>
            <td class="bg-[#186F65] text-white font-medium p-2 text-center border">No</td>
            <td class="bg-[#186F65] text-white font-medium p-2 text-center border">Nama</td>
            <td class="bg-[#186F65] text-white font-medium p-2 text-center border">Stok</td>
            <td class="bg-[#186F65] text-white font-medium p-2 text-center border hidden lg:table-cell">Harga</td>
            <td class="bg-[#186F65] text-white font-medium p-2 text-center border">Action</td>
          </tr>
        </thead>
        <tbody class="cashier_list_table" id="cashier_list_table">
          <!-- List Table -->
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

  <?= $this->include('components/cart') ?>
</main>
<?= $this->endSection(); ?>