<?= $this->extend('layout/sub_layout') ?>

<?php if (session()->getFlashdata('_ci_validation_errors')) :
  $errors = session()->getFlashdata('_ci_validation_errors');
endif; ?>

<?= $this->section('content') ?>
<main class="container my-2">
  <? csrf_field() ?>
  <div class="w-full bg-red-600/20  p-2 mb-2 hidden">
    <h2 class="font-medium">invalid</h2>
  </div>
  <div class="flex justify-center items-start gap-2 w-full">
    <div class="w-full lg:w-[69%]">
      <table class="table border-collapse rounded-md w-full table-auto">
        <thead>
          <tr>
            <td class="bg-[#186F65] text-white font-medium p-2 text-center border">No</td>
            <td class="bg-[#186F65] text-white font-medium p-2 text-center border">Nama</td>
            <td class="bg-[#186F65] text-white font-medium p-2 text-center border">Min</td>
            <td class="bg-[#186F65] text-white font-medium p-2 text-center border">Stok Toko</td>
            <td class="bg-[#186F65] text-white font-medium p-2 text-center border">Stok Gudang</td>
            <td class="bg-[#186F65] text-white font-medium p-2 text-center border">Action</td>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1;
          foreach ($goods->getResult() as $list) : ?>
            <?php
            $length = 30;
            $goodsName = substr($list->goods_name, 0, $length);
            if (strlen($list->goods_name) > $length) {
              $goodsName = $goodsName . '...';
            }
            ?>
            <tr>
              <td class="border p-2 bg-white text-black font-medium text-center"><?= $i ?></td>
              <td class="border p-2 bg-white text-black font-medium"><?= $goodsName ?></td>
              <td class="border p-2 bg-white text-black font-medium text-center"><?= $list->goods_min_stok ?></td>
              <td class="border p-2 bg-white text-black font-medium text-center"><?= $list->goods_stok_toko ?></td>
              <td class="border p-2 bg-white text-black font-medium text-center"><?= $list->goods_stok_gudang ?></td>
              <td class="border p-2 bg-white text-black font-medium text-center">

                <button class="flex justify-center items-center p-2 bg-add hover:bg-addHover rounded-md ease-in-out duration-200 w-max after:block after:w-2 m-auto" onclick="postRestock({restock: '<?= $noRes ?>', goods:'<?= $list->goods_code ?>', qty: '1' })">
                  <img src="<?= base_url('assets/icons/add-line.svg') ?>" alt="add-line" class="h-[30px] w-[30px] object-cover">
                  <h2 class="text-white font-semibold">Add</h2>
                </button>
              </td>
            </tr>
          <?php $i++;
          endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="absolute lg:relative top-0 right-0 ease-in-out duration-100 transition-all restock_cart nonActive" id="restock_cart">
      <?= $this->include('components/restock_cart') ?>
    </div>
  </div>
</main>
<?= $this->endSection(); ?>