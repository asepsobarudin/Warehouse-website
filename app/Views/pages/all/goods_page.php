<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <div class="block relative">
    <?php if (session()->getFlashdata('success')) : ?>
      <div class="absolute right-0 top-0">
        <span class="text-lg font-semibold py-4 px-3 bg-green-600 text-white rounded-md"><?= session()->getFlashdata('success') ?></span>
      </div>
    <?php endif; ?>
    <div class="w-full flex justify-between items-center my-2">
      <h2 class="text-xl font-semibold">Barang</h2>
      <a href="<?= base_url("/goods_create") ?>" class="p-2 bg-sky-500 hover:bg-sky-600 rounded-md font-medium text-white ease-in duration-100">Tambah Barang</a>
    </div>
    <table class="table-auto w-full border-separate border-2 border-black/10 border-spacing-1 my-2">
      <thead>
        <tr>
          <td class="p-2 bg-black text-white font-semibold text-center">Kode Barang</td>
          <td class="p-2 bg-sky-500 text-white font-semibold text-center">Nama Barang</td>
          <td class="p-2 bg-sky-500 text-white font-semibold text-center">Toko</td>
          <td class="p-2 bg-sky-500 text-white font-semibold text-center">Harga</td>
          <td class="p-2 bg-sky-500 text-white font-semibold text-center">Update</td>
          <td class="p-2 bg-sky-500 text-white font-semibold text-center">Action</td>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($goods as $list) : ?>
          <tr>
            <td class="p-2 bg-white text-black font-medium text-center">
              <?= $list['goods_code'] ?>
            </td>
            <td class="p-2 bg-white text-black font-medium"><?= $list['goods_name'] ?></td>
            <td class="p-2 bg-white text-black font-medium text-center"><?= $list['goods_stok'] ?></td>
            <td class="p-2 bg-white text-green-600 font-semibold">
              Rp <?= number_format($list['goods_price'], 0, ',', '.') ?>
            </td>
            <td class="p-2 bg-white text-green-600 font-semibold"></td>
            <td class="p-2 bg-white">
              <a href="<?= base_url("/goods_edit/".$list['goods_code']) ?>" class="p-2 bg-sky-500 hover:bg-sky-600 rounded-md font-medium text-white ease-in duration-100">View</a>
            </td>
          <?php
        endforeach; ?>
          </tr>
      </tbody>
    </table>
    <div class="flex justify-between items-center py-2">
      <div class="flex justify-center items-center font-semibold text-black/60 gap-1 text-sm">
        <span>Page <?= $currentPage ?></span>
        <span>of</span>
        <span><?= $pageCount ?></span>
        <span>(Barang <?= $totalItems ?>)</span>
      </div>
      <div class="flex justify-center items-center gap-2">
        <?php if ($currentPage > 1) : ?>
          <a href="<?= $backPage ?>" class="block py-2 px-3 bg-black/20 hover:bg-black/30 rounded-md font-medium text-black ease-in duration-100 w-max ">Back</a>
        <?php endif; ?>
        <?php if ($currentPage < $pageCount) : ?>
          <a href="<?= $nextPage ?>" class="block py-2 px-3 bg-black hover:bg-black/80 rounded-md font-medium text-white ease-in duration-100 w-max">Next</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>
<?= $this->endSection() ?>