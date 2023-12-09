<?= $this->extend('layout/main') ?>

<?php
$session = session()->get('sessionData');
$role = $session['role'];
?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <?= $this->include('components/flash_message') ?>
  <div class="flex w-full justify-between items-center my-2">
    <div class="flex justify-center items-center gap-2 w-max">
      <img src="<?= base_url('assets/icons/restock-line-purple-1.svg') ?>" alt="van-line" class="w-[30px] h-[30px] object-cover">
      <h2 class="text-2xl text-primary font-semibold w-max">Restock</h2>
    </div>
    <div class="flex justify-end items-center gap-2">
      <div class="flex justify-center items-center w-max md:w-max gap-2">
        <?php if ($role === 'gudang' || $role === 'admin') { ?>
          <a href="<?= site_url() ?>/restock/create" class="buttonInfo p-1 lg:py-2 lg:pl-4 lg:pr-2 flex justify-center items-center gap-1">
            <img src="<?= base_url('assets/icons/van-line-white-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
            <img src="<?= base_url('assets/icons/van-line-blue-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
            <span class="font-semibold pr-2 hidden lg:block">Kirim Barang</span>
          </a>
        <?php } ?>
      </div>
      <button class="p-2 flex lg:hidden group hover:bg-black/10 rounded-md effectTrasition" onclick="navMobile()">
        <img src="<?= base_url() ?>assets/icons/menu-line-black-1.svg" alt="menu" class="w-[30px] h-[30px] object-cover">
      </button>
    </div>
  </div>
  <div class="block w-full min-h-[65vh]">
    <table class="table w-full my-2">
      <thead>
        <tr>
          <td class="p-2 font-semibold text-center bg-primary text-secondary">#</td>
          <td class="p-2 font-semibold text-center bg-primary text-secondary">
            <span class="hidden md:block">Tanggal</span>
            <span class="block md:hidden">Restock</span>
          </td>
          <td class="p-2 font-semibold text-center bg-primary text-secondary hidden md:table-cell">
            Kode
          </td>
          <td class="p-2 font-semibold text-center bg-primary text-secondary hidden md:table-cell">Status</td>
          <?php if ($role == 'admin') : ?>
            <td class="p-2 font-semibold text-center bg-primary text-secondary hidden md:table-cell">
              <span class="hidden lg:block">Pengirim</span>
              <span class="block lg:hidden">Detail</span>
            </td>
          <?php endif; ?>
          <td class="p-2 font-semibold text-center bg-primary text-secondary hidden lg:table-cell">Jumlah</td>
          <td class="p-2 font-semibold text-center bg-primary text-secondary">Aksi</td>
        </tr>
      </thead>
      <tbody>
        <?php if ($restock) {
          $no = 1;
          foreach ($restock as $list) : ?>
            <?php
            $restockCode = substr($list['restock_code'], 0, 5);
            ?>
            <tr class="group">
              <td class="p-2 font-medium text-center group-odd:bg-white group-even:bg-dark text-primary"><?= $no ?></td>
              <td class="p-2 group-odd:bg-white group-even:bg-dark text-primary font-medium text-center block md:table-cell">
                <?= $list['created_at'] ?>
              </td>
              <td class="p-2 group-odd:bg-white group-even:bg-dark text-primary font-medium text-center block md:table-cell">
                <div class="flex justify-center items-center gap-2">
                  <?= $restockCode . '...' ?>
                  <button class="block p-2 border-2 border-primary/10 hover:border-primary/60 active:border-primary bg-white rounded-md duration-200 ease-in-out" onclick="copyTextToClipboard({copyText: '<?= $list['restock_code'] ?>'})">
                    <img src="<?= base_url('assets/icons/copy-line-1.svg') ?>" alt="copy-line-1" class="w-[20px] h-[20px] object-cover">
                  </button>
                </div>
              </td>
              <td class="p-2 group-odd:bg-white group-even:bg-dark font-medium block md:table-cell">
                <div class="flex justify-center items-center">
                  <?php if ($list['status'] == 0) { ?>
                    <span class="flex justify-center items-center rounded-md relative group/btn">
                      <img src="<?= base_url('assets/icons/edit-line-black-1.svg') ?>" alt="edit-line" class="w-[30px] h-[30px] object-cover">
                      <span class="hidden group-hover/btn:block absolute border-2 border-secondary p-2 w-max left-[35px] bg-white rounded-md shadow-md">Belum Selesai</span>
                    </span>
                  <?php } ?>
                  <?php if ($list['status'] == 1) { ?>
                    <span class="flex justify-center items-center rounded-md relative group/btn">
                      <img src="<?= base_url('assets/icons/van-line-black-1.svg') ?>" alt="edit-line" class="w-[30px] h-[30px] object-cover">
                      <span class="hidden group-hover/btn:block absolute border-2 border-secondary p-2 w-max left-[35px] bg-white rounded-md shadow-md">Terkirim</span>
                    </span>
                  <?php } ?>
                </div>
              </td>
              <?php if ($role == 'admin') : ?>
                <td class="p-2 group-odd:bg-white group-even:bg-dark font-medium text-center block md:w-auto lg:table-cell">
                  <div class="flex justify-center items-center">
                    <span class="block lg:hidden">User : </span>
                    <span class="block">
                      <?php if (!$list['user_id']) { ?>
                        -
                      <?php } else { ?>
                        <?= $list['user_id'] ?>
                      <?php } ?>
                    </span>
                  </div>
                </td>
              <?php endif ?>
              <td class="p-2 group-odd:bg-white group-even:bg-dark text-primary font-medium text-center block lg:table-cell">
                <div class="flex justify-center items-center">
                  <span class="block lg:hidden">Jumlah : </span>
                  <span class="block"><?= $list['qty'] ?></span>
                </div>
              </td>
              <td class="p-2 group-odd:bg-white group-even:bg-dark text-primary font-medium text-center">
                <div class="flex flex-col lg:flex-row justify-center items-center gap-2 w-full">
                  <?php if ($list['status'] == 0) : ?>
                    <a href="<?= site_url('/restock/edit/') . $list['restock_code'] ?>" class="buttonWarning p-1 lg:p-2 font-medium text-white block w-max">
                      <div class="w-[30px] h-[30px] block">
                        <img src="<?= base_url('assets/icons/edit-line-white-1.svg') ?>" alt="details-line" class="h-full w-full object-cover">
                        <img src="<?= base_url('assets/icons/edit-line-yellow-1.svg') ?>" alt="details-line" class="h-full w-full object-cover">
                      </div>
                    </a>
                  <?php endif; ?>
                  <?php if ($list['status'] >= 1) : ?>
                    <a href="<?= site_url('/restock/details/') . $list['restock_code'] ?>" class="buttonInfo p-1 lg:p-2 font-medium text-white block w-max">
                      <div class="w-[30px] h-[30px] block">
                        <img src="<?= base_url('assets/icons/details-line-white-1.svg') ?>" alt="details-line" class="h-full w-full object-cover">
                        <img src="<?= base_url('assets/icons/details-line-blue-1.svg') ?>" alt="details-line" class="h-full w-full object-cover">
                      </div>
                    </a>
                  <?php endif; ?>
                  <form action="<?= site_url() ?>/restock/delete" method="post" id="form_restock_delete<?= $no ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" value="<?= $list['restock_code'] ?>" name="restock">
                    <button type="button" class="buttonDanger block p-1 lg:p-2" onclick="messageConfirmation({ title: 'Hapus Permintaan', text: 'Apakah yakin ingin menghapus permintaan restock?', form: 'form_restock_delete<?= $no ?>' })">
                      <img src="<?= base_url('assets/icons/trash-line-white-1.svg') ?>" alt="trash-line-1" class="w-[30px] h-[30px] object-cover">
                      <img src="<?= base_url('assets/icons/trash-line-red-1.svg') ?>" alt="trash-line-1" class="w-[30px] h-[30px] object-cover">
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php $no++;
          endforeach;
        } else { ?>
          <tr>
            <td colspan="7" class="bg-white h-[500px]">
              <div class="flex justify-center items-center">
                <h2 class="text-lg font-medium">Tabel kosong</h2>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
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
<?= $this->endSection() ?>