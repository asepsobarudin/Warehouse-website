<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <div class="block relative">
    <div class="w-full flex justify-between items-center mb-2">
      <h2 class="text-lg font-semibold">Barang</h2>
      <?php if (session()->get('role') === 'gudang' || session()->get('role') === 'admin') { ?>
        <a href="<?= base_url("goods/goods_create") ?>" class="p-2 bg-add hover:bg-addHover rounded-md ease-in duration-100 flex justify-center items-center gap-1 after:block after:w-1">
          <img src="<?= base_url('assets/icons/add-line.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
          <span class="font-medium text-white">Tambah Barang</span>
        </a>
      <?php } ?>
    </div>
    <?php if (session()->getFlashdata('success')) : ?>
      <div class="block w-full bg-green-600/20 p-2">
        <span class="text-base font-medium text-black">
          <?= session()->getFlashdata('success') ?>
        </span>
      </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('failed')) : ?>
      <div class="block w-full p-2 bg-red-600/20">
        <span class="text-base font-medium text-black">
          <?= session()->getFlashdata('failed') ?>
        </span>
      </div>
    <?php endif; ?>
    <table class="table-auto w-full border my-2">
      <thead>
        <tr>
          <td class="border p-2 bg-pallet1 text-white font-semibold text-center w-[230px]">Kode Barang</td>
          <td class="border p-2 bg-pallet1 text-white font-semibold text-center w-[300px]">Nama Barang</td>
          <td class="border p-2 bg-pallet1 text-white font-semibold text-center w-[100px]">Min</td>
          <td class="border p-2 bg-pallet1 text-white font-semibold text-center w-[100px]">Toko</td>
          <td class="border p-2 bg-pallet1 text-white font-semibold text-center w-[100px]">Gudang</td>
          <td class="border p-2 bg-pallet1 text-white font-semibold text-center w-[180px]">Harga</td>
          <td class="border p-2 bg-pallet1 text-white font-semibold text-center">User Update</td>
          <td class="border p-2 bg-pallet1 text-white font-semibold text-center w-[100px]">Action</td>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($goods) {
          foreach ($goods as $list) : ?>
          <?php
            $length = 30;
            $goodsName = substr($list['goods_name'], 0, $length);
            if(strlen($list['goods_name']) > $length ) {
              $goodsName = $goodsName . '...';
            }
            ?>
            <tr>
              <td class="border p-2 bg-white text-black font-medium text-center">
                <?= $list['goods_code'] ?>
              </td>
              <td class="border p-2 bg-white text-black font-medium"><?= $goodsName ?></td>
              <td class="border p-2 bg-white text-black font-medium text-center"><?= $list['goods_min_stok'] ?></td>
              <td class="border p-2 bg-white text-black font-medium text-center"><?= $list['goods_stok_toko'] ?></td>
              <td class="border p-2 bg-white text-black font-medium text-center"><?= $list['goods_stok_gudang'] ?></td>
              <td class="border p-2 bg-white text-green-600 font-semibold">
                Rp <?= number_format($list['goods_price'], 0, ',', '.') ?>
              </td>
              <td class="border p-2 bg-white text-green-600 font-semibold text-center"><?= $list['users_id'] ?></td>
              <td class="border p-2 bg-white">
                <div class="flex justify-center items-center">
                  <a href="<?= base_url("goods/goods_edit/" . $list['goods_code']) ?>" class="p-2 bg-view hover:bg-viewHover rounded-md font-medium text-white ease-in duration-100 block w-max">
                    <div class="w-[30px] h-[30px] block">
                      <img src="<?= base_url('assets/icons/eye-line.svg') ?>" alt="eye" class="h-full w-full object-cover">
                    </div>
                  </a>
                </div>
              </td>
            </tr>
          <?php
          endforeach;
        } else { ?>
          <tr>
            <td colspan="7">
              <div class="loading">
                <h2>Tidak ada barang!</h2>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="flex justify-between items-center py-2">
      <div class="flex justify-center items-center font-semibold text-black/60 gap-1 text-sm">
        <?php if ($goods) : ?>
          <span>Page <?= $currentPage ?></span>
          <span>of</span>
          <span><?= $pageCount ?></span>
          <span>(Barang <?= $totalItems ?>)</span>
        <?php endif; ?>
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