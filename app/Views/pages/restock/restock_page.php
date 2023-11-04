<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <div>
    <div class="flex w-full justify-between items-center mb-2">
      <h2 class="text-lg font-semibold w-max">Restock</h2>
      <a href="<?= base_url('restock/restock_create') ?>" class="p-2 bg-add hover:bg-addHover ease-in-out duration-100 rounded-md flex justify-center items-center gap-1">
        <img src="<?= base_url('assets/icons/add-line.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
        <span class="font-semibold text-white pr-2">Request</span>
      </a>
    </div>
    <table class="table border-collapse w-full">
      <thead>
        <tr>
          <td class="border p-2 font-medium text-center bg-pallet1 text-white">Kode</td>
          <td class="border p-2 font-medium text-center bg-pallet1 text-white">Nama Barang</td>
          <td class="border p-2 font-medium text-center bg-pallet1 text-white">Stok Minimal</td>
          <td class="border p-2 font-medium text-center bg-pallet1 text-white">Stok Tersisa</td>
          <td class="border p-2 font-medium text-center bg-pallet1 text-white">Jumlah</td>
          <td class="border p-2 font-medium text-center bg-pallet1 text-white">Status</td>
          <td class="border p-2 font-medium text-center bg-pallet1 text-white">Action</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border p-2 bg-white text-black font-medium text-center"></td>
          <td class="border p-2 bg-white text-black font-medium text-center"></td>
          <td class="border p-2 bg-white text-black font-medium text-center"></td>
          <td class="border p-2 bg-white text-black font-medium text-center"></td>
          <td class="border p-2 bg-white text-black font-medium text-center"></td>
          <td class="border p-2 bg-white text-black font-medium text-center"></td>
          <td class="border p-2 bg-white text-black font-medium text-center"></td>
        </tr>
      </tbody>
    </table>
  </div>
</main>
<?= $this->endSection() ?>