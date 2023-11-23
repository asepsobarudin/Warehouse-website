<?= $this->extend('layout/main') ?>

<?php
$session = session()->get('sessionData');
$role = $session['role'];
?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <?= $this->include('components/flash_message') ?>
  <div class="w-full flex justify-between items-center my-2 gap-2 flex-wrap">
    <div class="flex justify-center items-center gap-2 w-max">
      <img src="<?= base_url('assets/icons/box-line-purple-1.svg') ?>" alt="box-line" class="w-[30px] h-[30px] object-cover">
      <h2 class="text-2xl text-primary font-semibold">Barang</h2>
    </div>
  </div>
  <div class="flex justify-end md:justify-between items-center gap-2 flex-wrap-reverse">
    <form action="<?= base_url('goods') ?>" method="post" class="flex justify-center md:justify-end items-center min-w-full md:min-w-[350px] gap-2">
      <?= csrf_field() ?>
      <input type="text" name="search_goods" id="search_goods" class="p-2 w-[90%] bg-netral border-2 border-primary/10 focus:border-primary/30 rounded-md outline-none font-semibold text-primary/80" placeholder="Cari barang...">
      <button type="submit" class="buttonInfo p-1 w-max">
        <img src="<?= base_url('assets/icons/search-line-white-1.svg') ?>" alt="" class="w-[30px] h-[30px] object-cover">
        <img src="<?= base_url('assets/icons/search-line-blue-1.svg') ?>" alt="" class="w-[30px] h-[30px] object-cover">
      </button>
    </form>
    <?php if ($role === 'gudang' || $role === 'admin') { ?>
      <a href="<?= base_url("goods/goods_create") ?>" class="p-2 buttonInfo flex justify-center items-center gap-1">
        <img src="<?= base_url('assets/icons/add-line-white-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
        <img src="<?= base_url('assets/icons/add-line-blue-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
        <span class="font-medium">Tambah Barang</span>
      </a>
    <?php } ?>
  </div>
  <table class="table-auto w-full my-2">
    <thead>
      <tr>
        <td class="p-2 bg-primary text-secondary font-semibold text-center">#</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center">
          <span class="hidden md:block">Kode</span>
          <span class="block md:hidden">Detail</span>
        </td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Nama</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">
          <span class="hidden lg:block">Min</span>
          <span class="block lg:hidden">Stok</span>
        </td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden lg:table-cell">Toko</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden lg:table-cell">Gudang</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Detail</td>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($goods) {
        $no = 1;
        foreach ($goods as $list) : ?>
          <?php
          $goodsCode = substr($list['goods_code'], 0, 8);
          ?>
          <tr class="group">
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center"><?= $no ?></td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center block md:table-cell md:max-w-[100px]">
              <div class="flex justify-start md:justify-center items-center gap-2">
                <?= $goodsCode . '...' ?>
                <button class="block p-2 border-2 border-primary/10 hover:border-primary/60 active:border-primary bg-netral rounded-md duration-200 ease-in-out" onclick="copyTextToClipboard({copyText: '<?= $list['goods_code'] ?>'})">
                  <img src="<?= base_url('assets/icons/copy-line-1.svg') ?>" alt="copy-line-1" class="w-[20px] h-[20px] object-cover">
                </button>
              </div>
            </td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium block md:table-cell md:max-w-[200px]">
              <?= $list['goods_name'] ?>
            </td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center flex gap-2 lg:table-cell">
              <span class="block whitespace-nowrap lg:hidden">Min : </span>
              <span class="block whitespace-nowrap"><?= $list['goods_min_stock'] ?></span>
            </td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center flex gap-2 lg:table-cell">
              <span class="block whitespace-nowrap lg:hidden">Toko : </span>
              <span class="block whitespace-nowrap"><?= $list['goods_stock_shop'] ?></span>
            </td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center flex gap-2 lg:table-cell">
              <span class="block whitespace-nowrap lg:hidden">Gudang : </span>
              <span class="block whitespace-nowrap"><?= $list['goods_stock_warehouse'] ?></span>
            </td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark block md:table-cell">
              <div class="flex justify-center items-center">
                <a href="<?= base_url("goods/goods_edit/" . $list['goods_code']) ?>" class="buttonInfo p-2 font-medium w-full md:w-max flex justify-center items-center gap-2">
                  <img src="<?= base_url('assets/icons/details-line-white-1.svg') ?>" alt="eye" class="w-[30px] h-[30px] object-cover">
                  <img src="<?= base_url('assets/icons/details-line-blue-1.svg') ?>" alt="eye" class="w-[30px] h-[30px] object-cover">
                  <h2 class="font-semibold block md:hidden">Detail</h2>
                </a>
              </div>
            </td>
          </tr>
        <?php $no++;
        endforeach;
      } else { ?>
        <tr>
          <td colspan="7" class="bg-white h-[400px]">
            <div class="flex justify-center items-center">
              <h2 class="text-lg font-medium">Tabel kosong</h2>
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="flex justify-between items-center py-2">
    <div class="flex justify-center items-center font-semibold text-primary/60 gap-1 text-sm">
      <?php if ($goods) : ?>
        <?php if (isset($currentPage)) : ?>
          <span>Page <?= $currentPage ?></span>
          <span>of</span>
          <span><?= $pageCount ?></span>
          <span>(Barang <?= $totalItems ?>)</span>
        <?php endif ?>
      <?php endif; ?>
    </div>
    <div class="flex justify-center items-center gap-2 px-2">
      <?php if (isset($currentPage) && $currentPage > 1) : ?>
        <a href="<?= $backPage ?>" class="block py-2 px-3 rounded-md font-semibold w-max bg-tersier hover:bg-white border-2 border-transparent hover:border-tersier text-secondary hover:text-tersier effectTrasition">Back</a>
      <?php endif; ?>
      <?php if (isset($currentPage) && $currentPage < $pageCount) : ?>
        <a href="<?= $nextPage ?>" class="block py-2 px-3 rounded-md font-medium w-max bg-primary hover:bg-white border-2 border-transparent hover:border-primary text-secondary hover:text-primary effectTrasition">Next</a>
      <?php endif; ?>
    </div>
  </div>
</main>
<?= $this->endSection() ?>