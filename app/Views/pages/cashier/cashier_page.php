<?= $this->extend('layout/main') ?>

<?= $this->section('content'); ?>
<main class="flex flex-col md:flex-row justify-center w-full h-full md:h-screen overflow-hidden" id="main">
  <div class="container px-2 pt-2 md:pb-[60px] lg:pb-2 overflow-y-scroll" id="block_ctn">
    <div class="w-full h-max block">
      <div class="mb-2 flex justify-center md:justify-between gap-2 items-center">
        <h2 class="text-xl font-medium text-green-600">
          Cashier
        </h2>

        <label for="search" class="flex justify-center items-center relative w-full md:w-max">
          <span class="absolute top-0 left-2 flex justify-center items-center h-full">
            <img src="<?= base_url('assets/icons/search.png') ?>" alt="filter" class="w-[30px] opacity-70">
          </span>
          <input type="text" id="search" name="search" class="py-2 outline-none pl-10 pr-2 rounded-md border-2 border-transparent w-full md:w-[250px] lg:w-max focus:border-sky-300" placeholder="Search...">
        </label>
      </div>

      <div class="block h-[2px] w-full bg-black/10 rounded-full mb-2"></div>

      <div class="flex justify-center items-start flex-wrap gap-2 h-full" id="goods_container">
      </div>

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