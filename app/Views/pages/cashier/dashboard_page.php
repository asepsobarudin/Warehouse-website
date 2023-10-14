<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <header class="flex flex-wrap justify-between items-center w-full gap-2">
    <div class="w-full md:w-max">
      <h2 class="text-xl font-semibold text-sky-800">TokoKu</h2>
      <h2 class="text-sm font-medium text-black/60">Building Materials Shop</h2>
    </div>
    <div class="w-full md:w-max flex gap-2 justify-center items-center">
      <div class="p-2 ease-in duration-100 rounded-md flex justify-center items-center font-semibold text-white gap-1 cursor-pointer bg-sky-600 hover:bg-sky-700">
        <img src="<?= base_url("/assets/icons/transaction.png") ?>" alt="transaction" class="w-[40px]">
        <div class="block text-lg">
          <h2 class="hidden lg:block">Transaksi</h2>
          <h2>10</h2>
        </div>
      </div>
      <div class="p-2 ease-in duration-100 rounded-md flex justify-center items-center font-semibold text-white gap-1 cursor-pointer bg-yellow-500 hover:bg-yellow-600">
        <img src="<?= base_url("/assets/icons/transaction.png") ?>" alt="transaction" class="w-[40px]">
        <div class="block text-lg">
          <h2 class="hidden lg:block">Transaksi</h2>
          <h2>10</h2>
        </div>
      </div>
      <div class="p-2 ease-in duration-100 rounded-md flex justify-center items-center font-semibold text-white gap-1 cursor-pointer bg-green-600 hover:bg-green-700">
        <img src="<?= base_url("/assets/icons/transaction.png") ?>" alt="transaction" class="w-[40px]">
        <div class="block text-lg">
          <h2 class="hidden lg:block">Transaksi</h2>
          <h2>10</h2>
        </div>
      </div>
    </div>
  </header>
</main>
<?= $this->endSection() ?>