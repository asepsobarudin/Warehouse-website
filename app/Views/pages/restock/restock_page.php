<?= $this->extend('layout/main') ?>

<?php
$session = session()->get('sessionData');
$role = $session['role'];
?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <?= $this->include('components/flash_message') ?>
  <div class="flex w-full justify-between items-center mb-2">
    <div class="flex justify-center items-center gap-2 w-max">
      <img src="<?= base_url('assets/icons/restock-line-purple-1.svg') ?>" alt="van-line" class="w-[30px] h-[30px] object-cover">
      <h2 class="text-2xl text-primary font-semibold w-max">Restock</h2>
    </div>
  </div>
  <div class="flex justify-end md:justify-between items-center gap-2 flex-wrap-reverse">
    <form action="<?= base_url('goods') ?>" method="post" class="flex justify-center md:justify-end items-center min-w-full md:min-w-[350px] gap-2">
      <?= csrf_field() ?>
      <input type="text" name="search_goods" id="search_goods" class="p-2 w-[90%] bg-netral border-2 border-primary/10 focus:border-primary/30 rounded-md outline-none font-semibold text-primary/80" placeholder="restock code...">
      <button type="submit" class="buttonInfo p-1 w-max">
        <img src="<?= base_url('assets/icons/search-line-white-1.svg') ?>" alt="" class="w-[30px] h-[30px] object-cover">
        <img src="<?= base_url('assets/icons/search-line-blue-1.svg') ?>" alt="" class="w-[30px] h-[30px] object-cover">
      </button>
    </form>
    <?php if ($role === 'kasir' || $role === 'admin') { ?>
      <a href="<?= site_url() ?>/restock/create" class="buttonInfo p-2 flex justify-center items-center gap-1">
        <img src="<?= base_url('assets/icons/add-line-white-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
        <img src="<?= base_url('assets/icons/add-line-blue-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
        <span class="font-semibold pr-2">Buat Permintaan</span>
      </a>
    <?php } ?>
  </div>
  <table class="table w-full my-2">
    <thead>
      <tr>
        <td class="p-2 font-medium text-center bg-primary text-secondary">#</td>
        <td class="p-2 font-medium text-center bg-primary text-secondary">
          <span class="hidden md:block">Kode</span>
          <span class="block md:hidden">Restock</span>
        </td>
        <td class="p-2 font-medium text-center bg-primary text-secondary hidden md:table-cell">Status</td>
        <?php if ($role == 'gudang' || $role == 'admin') : ?>
          <td class="p-2 font-medium text-center bg-primary text-secondary hidden md:table-cell">
            <span class="hidden lg:block">Pemesan / Penerima</span>
            <span class="block lg:hidden">Detail</span>
          </td>
        <?php endif; ?>
        <?php if ($role == 'kasir' || $role == 'admin') : ?>
          <td class="p-2 font-medium text-center bg-primary text-secondary hidden lg:table-cell">Pengirim</td>
        <?php endif; ?>
        <td class="p-2 font-medium text-center bg-primary text-secondary hidden lg:table-cell">Tanggal</td>
        <td class="p-2 font-medium text-center bg-primary text-secondary hidden lg:table-cell">Aksi</td>
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
            <td class="p-2 font-medium text-center group-odd:bg-netral group-even:bg-dark text-primary"><?= $no ?></td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center block md:table-cell">
              <div class="flex justify-center items-center gap-2">
                <?= $restockCode . '...' ?>
                <button class="block p-2 border-2 border-primary/10 hover:border-primary/60 active:border-primary bg-netral rounded-md duration-200 ease-in-out" onclick="copyTextToClipboard({copyText: '<?= $list['restock_code'] ?>'})">
                  <img src="<?= base_url('assets/icons/copy-line-1.svg') ?>" alt="copy-line-1" class="w-[20px] h-[20px] object-cover">
                </button>
              </div>
            </td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark font-medium block md:table-cell">
              <div class="flex justify-center items-center">
                <?php if ($list['status'] == 0) { ?>
                  <span class="flex justify-center items-center rounded-md relative group/btn">
                    <img src="<?= base_url('assets/icons/edit-line-black-1.svg') ?>" alt="edit-line" class="w-[30px] h-[30px] object-cover">
                    <span class="hidden group-hover/btn:block absolute border-2 border-secondary p-2 w-max left-[35px] bg-netral rounded-md shadow-md">Belum Selesai</span>
                  </span>
                <?php } ?>
                <?php if ($list['status'] == 1) { ?>
                  <span class="flex justify-center items-center rounded-md relative group/btn">
                    <img src="<?= base_url('assets/icons/send-line-black-1.svg') ?>" alt="edit-line" class="w-[30px] h-[30px] object-cover">
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
                    <img src="<?= base_url('assets/icons/van-line-black-1.svg') ?>" alt="edit-line" class="w-[30px] h-[30px] object-cover">
                    <span class="hidden group-hover/btn:block absolute border-2 border-secondary p-2 w-max left-[35px] bg-netral rounded-md shadow-md">Dikirim</span>
                  </span>
                <?php } ?>
                <?php if ($list['status'] == 4) { ?>
                  <span class="flex justify-center items-center rounded-md relative group/btn">
                    <img src="<?= base_url('assets/icons/check-line-black-1.svg') ?>" alt="edit-line" class="w-[30px] h-[30px] object-cover">
                    <span class="hidden group-hover/btn:block absolute border-2 border-secondary p-2 w-max left-[35px] bg-netral rounded-md shadow-md">Diterima</span>
                  </span>
                <?php } ?>
              </div>
            </td>
            <?php if ($role == 'gudang' || $role == 'admin') : ?>
              <td class="p-2 group-odd:bg-netral group-even:bg-dark text-danger font-semibold text-center inline-block w-1/2 md:block md:w-auto lg:table-cell"><?= $list['request_user_id'] ?></td>
            <?php endif; ?>
            <?php if ($role == 'kasir' || $role == 'admin') : ?>
              <td class="p-2 group-odd:bg-netral group-even:bg-dark text-success font-semibold text-center inline-block w-1/2 md:block md:w-auto lg:table-cell">
                <?php if (!$list['response_user_id']) { ?>
                  -
                <?php } else { ?>
                  <?= $list['response_user_id'] ?>
                <?php } ?>
              </td>
            <?php endif ?>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center block lg:table-cell">
              <?= $list['created_at'] ?>
            </td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center block lg:table-cell">
              <div class="flex justify-center items-center gap-2 w-full">
                <?php if ($list['status'] == 0 && ($role === 'kasir' || $role === 'admin')) : ?>
                  <a href="<?= site_url('/restock/edit/') . $list['restock_code'] ?>" class="buttonWarning p-2 font-medium text-white block w-max">
                    <div class="w-[30px] h-[30px] block">
                      <img src="<?= base_url('assets/icons/edit-line-white-1.svg') ?>" alt="details-line" class="h-full w-full object-cover">
                      <img src="<?= base_url('assets/icons/edit-line-yellow-1.svg') ?>" alt="details-line" class="h-full w-full object-cover">
                    </div>
                  </a>
                <?php endif; ?>
                <?php if ($list['status'] >= 1 && ($role === 'kasir' || $role === 'admin')) : ?>
                  <a href="<?= site_url('/restock/details/') . $list['restock_code'] ?>" class="buttonInfo p-2 font-medium text-white block w-max">
                    <div class="w-[30px] h-[30px] block">
                      <img src="<?= base_url('assets/icons/details-line-white-1.svg') ?>" alt="details-line" class="h-full w-full object-cover">
                      <img src="<?= base_url('assets/icons/details-line-blue-1.svg') ?>" alt="details-line" class="h-full w-full object-cover">
                    </div>
                  </a>
                <?php endif; ?>
                <?php if ($list['status'] == 1 && ($role === 'kasir' || $role === 'admin')) : ?>
                  <form action="<?= site_url() ?>/restock/cancle" method="post" id="form_restock_cancle<?= $no ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" value="<?= $list['restock_code'] ?>" name="restock">
                    <button type="button" class="buttonWarning block p-2" onclick="messageConfirmation({ title: 'Batalkan Permintaan', text: 'Apakah yakin ingin membatalkan permintaan restock?', form: 'form_restock_cancle<?= $no ?>' })">
                      <img src="<?= base_url('assets/icons/send-line-cancle-white-1.svg') ?>" alt="send-line-1" class="w-[30px] h-[30px] object-cover">
                      <img src="<?= base_url('assets/icons/send-line-cancle-yellow-1.svg') ?>" alt="send-line-1" class="w-[30px] h-[30px] object-cover">
                    </button>
                  </form>
                <?php endif; ?>
                <?php if ($list['status'] >= 1 && ($role === 'gudang' || $role === 'admin')) : ?>
                  <a href="<?= base_url('restock/get_restock/') . $list['restock_code'] ?>" class="buttonSuccess p-2 font-medium text-white block w-max">
                    <div class="w-[30px] h-[30px] block">
                      <img src="<?= base_url('assets/icons/van-line-white-1.svg') ?>" alt="eye" class="h-full w-full object-cover">
                      <img src="<?= base_url('assets/icons/van-line-green-1.svg') ?>" alt="eye" class="h-full w-full object-cover">
                    </div>
                  </a>
                <?php endif ?>
                <?php if (($list['status'] < 1 || $list['status'] == 5) || $session['role'] == 'admin') : ?>
                  <form action="<?= site_url() ?>/restock/delete" method="post" id="form_restock_delete<?= $no ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" value="<?= $list['restock_code'] ?>" name="restock">
                    <button type="button" class="buttonDanger block p-2" onclick="messageConfirmation({ title: 'Hapus Permintaan', text: 'Apakah yakin ingin menghapus permintaan restock?', form: 'form_restock_delete<?= $no ?>' })">
                      <img src="<?= base_url('assets/icons/trash-line-white-1.svg') ?>" alt="trash-line-1" class="w-[30px] h-[30px] object-cover">
                      <img src="<?= base_url('assets/icons/trash-line-red-1.svg') ?>" alt="trash-line-1" class="w-[30px] h-[30px] object-cover">
                    </button>
                  </form>
                <?php endif; ?>
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