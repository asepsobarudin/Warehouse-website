<?= $this->extend('layout/sub_layout') ?>

<?= $this->section('content'); ?>
<main class="container px-2 py-4 block">
  <?= $this->include('components/flash_message') ?>
  <?php if ($goods) : ?>
    <div class="flex justify-end items-center w-full mb-2">
      <form action="<?= site_url() ?>/goods/delete_all_trash" method="post" id="form_goods_delete_trash">
        <?= csrf_field() ?>
        <button type="button" class="p-2 buttonDanger flex justify-center items-center gap-1" onclick="messageConfirmation({ title: 'Hapus Semua', text: 'Apakah yakin ingin menghapus semua data barang secara permanen?', form: 'form_goods_delete_trash' })">
          <img src="<?= base_url() ?>/assets/icons/trash-line-x-white-1.svg" alt="restore" class="w-[30px] h-[30px] object-cover">
          <img src="<?= base_url() ?>/assets/icons/trash-line-x-red-1.svg" alt="restore" class="w-[30px] h-[30px] object-cover">
          <h2 class="font-semibold">Hapus Semua</h2>
        </button>
      </form>
    </div>
  <?php endif; ?>
  <table class="table w-full">
    <thead>
      <tr>
        <td class="p-2 bg-primary text-secondary font-semibold text-center">#</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center">
          <span class="hidden md:block">Kode</span>
          <span class="block md:hidden">Detail</span>
        </td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Nama barang</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Oleh</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Tanggal</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Aksi</td>
      </tr>
    </thead>
    <tbody>
      <?php if ($goods) {
        $no = 1;
        foreach ($goods as $list) : ?>
          <tr class="group">
            <td class="p-2 group-odd:bg-white group-even:bg-dark text-primary font-medium text-center max-w-[60px]"><?= $no ?></td>
            <td class="p-2 group-odd:bg-white group-even:bg-dark text-primary font-medium text-start md:text-center block md:table-cell md:max-w-[200px]"><?= $list['goods_code'] ?></td>
            <td class="p-2 group-odd:bg-white group-even:bg-dark text-primary font-medium text-start block md:table-cell md:max-w-[200px]"><?= $list['goods_name'] ?></td>
            <td class="p-2 group-odd:bg-white group-even:bg-dark text-primary font-medium text-start md:text-center block md:table-cell md:max-w-[100px]"><?= $list['users_id'] ?></td>
            <td class="p-2 group-odd:bg-white group-even:bg-dark text-primary font-medium text-start md:text-center block md:table-cell"><?= $list['deleted_at'] ?></td>
            <td class="p-2 group-odd:bg-white group-even:bg-dark text-primary font-medium text-center block md:table-cell">
              <div class="flex justify-center items-center gap-2">
                <form action="<?= site_url() ?>/goods/restore" method="post" id="form_goods_restore<?= $no ?>">
                  <?= csrf_field() ?>
                  <input type="hidden" name="goods_code" value="<?= $list['goods_code'] ?>">
                  <button type="button" class="p-2 buttonInfo flex justify-center items-center gap-1" onclick="messageConfirmation({ title: 'Restore Barang', text: 'Apakah yakin ingin merestore barang?', form: 'form_goods_restore<?= $no ?>' })">
                    <img src="<?= base_url() ?>/assets/icons/restore-line-white-1.svg" alt="restore" class="w-[30px] h-[30px] object-cover">
                    <img src="<?= base_url() ?>/assets/icons/restore-line-blue-1.svg" alt="restore" class="w-[30px] h-[30px] object-cover">
                    <h2 class="font-semibold block md:hidden">Restore</h2>
                  </button>
                </form>
                <form action="<?= site_url() ?>/goods/delete_trash" method="post" id="form_goods_delete_trash<?= $no ?>">
                  <?= csrf_field() ?>
                  <input type="hidden" name="goods_code" value="<?= $list['goods_code'] ?>">
                  <button type="button" class="p-2 buttonDanger flex justify-center items-center gap-1" onclick="messageConfirmation({ title: 'Hapus Permanen', text: 'Apakah yakin ingin menghapus barang secara permanen?', form: 'form_goods_delete_trash<?= $no ?>' })">
                    <img src="<?= base_url() ?>/assets/icons/trash-line-x-white-1.svg" alt="restore" class="w-[30px] h-[30px] object-cover">
                    <img src="<?= base_url() ?>/assets/icons/trash-line-x-red-1.svg" alt="restore" class="w-[30px] h-[30px] object-cover">
                    <h2 class="font-semibold block md:hidden">Hapus</h2>
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
</main>

<?= $this->endSection(); ?>