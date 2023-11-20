<?= $this->extend('layout/main') ?>

<?php 
$session = session()->get('sessionData')
?>

<?= $this->section('content'); ?>
<main class="container p-2" id="main">
  <div class="flex justify-between items-center gap-2 flex-wrap mt-2 mb-4">
    <div class="flex justify-center items-center gap-2 w-max">
      <img src="<?= base_url('assets/icons/van-line-purple-1.svg') ?>" alt="van-line" class="w-[30px] h-[30px] object-cover">
      <h2 class="text-2xl text-primary font-semibold">Distribusi</h2>
    </div>
  </div>
  <table class="table border-collapse w-full my-2">
    <thead>
      <tr>
        <td class="border p-2 font-medium text-center bg-primary text-secondary">#</td>
        <td class="border p-2 font-medium text-center bg-primary text-secondary">
          <span class="hidden md:block">Kode</span>
          <span class="block md:hidden">Restok</span>
        </td>
        <td class="border p-2 font-medium text-center bg-primary text-secondary hidden md:table-cell">Status</td>
        <td class="border p-2 font-medium text-center bg-primary text-secondary hidden md:table-cell">
          <span class="hidden lg:block">Pemesan</span>
          <span class="block lg:hidden">Detail</span>
        </td>
        <?php if ($session['role'] == 'admin') : ?>
          <td class="border p-2 font-medium text-center bg-primary text-secondary hidden lg:table-cell">Pengirim</td>
        <?php endif; ?>
        <td class="border p-2 font-medium text-center bg-primary text-secondary hidden lg:table-cell">Tanggal</td>
        <td class="border p-2 font-medium text-center bg-primary text-secondary">Aksi</td>
      </tr>
    </thead>
    <tbody>
      <?php if ($restock) {
        $i = 1;
        foreach ($restock as $list) : ?>
          <?php
          $restockCode = substr($list['restock_code'], 0, 5);
          ?>
          <tr class="group">
            <td class="border p-2 font-medium text-center group-odd:bg-netral group-even:bg-dark text-primary"><?= $i ?></td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center block md:table-cell">
              <div class="flex justify-center items-center gap-2">
                <?= $restockCode . '...' ?>
                <button class="block p-2 border-2 border-primary/10 hover:border-primary/60 active:border-primary bg-netral rounded-md duration-200 ease-in-out" onclick="copyTextToClipboard({copyText: '<?= $list['restock_code'] ?>'})">
                  <img src="<?= base_url('assets/icons/copy-line-1.svg') ?>" alt="copy-line-1" class="w-[20px] h-[20px] object-cover">
                </button>
              </div>
            </td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-dark font-medium block md:table-cell">
              <div class="flex justify-center items-center">
                <?php if ($list['status'] == 1) { ?>
                  <span class="flex justify-center items-center rounded-md relative group/btn">
                    <img src="<?= base_url('assets/icons/send-line-black-1.svg') ?>" alt="status" class="w-[30px] h-[30px] object-cover">
                    <span class="hidden group-hover/btn:block absolute border-2 border-secondary p-2 w-max left-[35px] bg-netral rounded-md shadow-md">Terkirim</span>
                  </span>
                <?php } ?>
                <?php if ($list['status'] == 2) { ?>
                  <span class="flex justify-center items-center rounded-md relative group/btn">
                    <img src="<?= base_url('assets/icons/box-line-black-1.svg') ?>" alt="status" class="w-[30px] h-[30px] object-cover">
                    <span class="hidden group-hover/btn:block absolute border-2 border-secondary p-2 w-max left-[35px] bg-netral rounded-md shadow-md">Dikemas</span>
                  </span>
                <?php } ?>
                <?php if ($list['status'] == 3) { ?>
                  <span class="flex justify-center items-center rounded-md relative group/btn">
                    <img src="<?= base_url('assets/icons/van-line-black-1.svg') ?>" alt="status" class="w-[30px] h-[30px] object-cover">
                    <span class="hidden group-hover/btn:block absolute border-2 border-secondary p-2 w-max left-[35px] bg-netral rounded-md shadow-md">Dikirim</span>
                  </span>
                <?php } ?>
                <?php if ($list['status'] == 4) { ?>
                  <span class="flex justify-center items-center rounded-md relative group/btn">
                    <img src="<?= base_url('assets/icons/check-line-black-1.svg') ?>" alt="status" class="w-[30px] h-[30px] object-cover">
                    <span class="hidden group-hover/btn:block absolute border-2 border-secondary p-2 w-max left-[35px] bg-netral rounded-md shadow-md">Diterima</span>
                  </span>
                <?php } ?>
              </div>
            </td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center inline-block w-1/2 md:block md:w-auto lg:table-cell"><?= $list['request_user_id'] ?></td>
            <?php if ($session['role'] == 'admin') : ?>
              <td class="border p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center inline-block w-1/2 md:block md:w-auto lg:table-cell">
                <?php if (!$list['response_user_id']) { ?>
                  -
                <?php } else { ?>
                  <?= $list['response_user_id'] ?>
                <?php } ?>
              </td>
            <?php endif; ?>
            <td class="border p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center block lg:table-cell">
              <?= $list['created_at'] ?>
            </td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center">
              <div class="flex flex-col lg:flex-row justify-center items-center gap-2 w-full">
                <a href="<?= base_url('distribution/get_restock/') . $list['restock_code'] ?>" class="buttonInfo p-2 font-medium text-white block w-max">
                  <div class="w-[30px] h-[30px] block">
                    <img src="<?= base_url('assets/icons/details-line-white-1.svg') ?>" alt="eye" class="h-full w-full object-cover">
                    <img src="<?= base_url('assets/icons/details-line-blue-1.svg') ?>" alt="eye" class="h-full w-full object-cover">
                  </div>
                </a>
              </div>
            </td>
          </tr>
        <?php $i++;
        endforeach;
      } else { ?>
        <tr>
          <td colspan="7" class="bg-white h-[500px]">
            <div class="flex justify-center items-center">
              <h2 class="text-lg font-semibold">List Distribusi Barang Kosong.</h2>
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="flex justify-between items-center py-2">
    <div class="flex justify-center items-center font-semibold text-primary/60 gap-1 text-sm">
      <?php if ($restock) : ?>
        <span>Page <?= $currentPage ?></span>
        <span>of</span>
        <span><?= $pageCount ?></span>
        <span>(Restock <?= $totalItems ?>)</span>
      <?php endif; ?>
    </div>
    <div class="flex justify-center items-center gap-2">
      <?php if ($currentPage > 1) : ?>
        <a href="<?= $backPage ?>" class="block py-2 px-3 rounded-md font-semibold w-max bg-tersier hover:bg-white border-2 border-transparent hover:border-tersier text-secondary hover:text-tersier effectTrasition">Back</a>
      <?php endif; ?>
      <?php if ($currentPage < $pageCount) : ?>
        <a href="<?= $nextPage ?>" class="block py-2 px-3 rounded-md font-medium w-max bg-primary hover:bg-white border-2 border-transparent hover:border-primary text-secondary hover:text-primary effectTrasition">Next</a>
      <?php endif; ?>
    </div>
  </div>
</main>
<?= $this->endSection(); ?>