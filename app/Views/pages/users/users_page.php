<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php
$session = session()->get('sessionData');
?>

<main class="container" id="main">
  <header class="flex justify-between items-center flex-wrap gap-2">
    <h2 class="text-2xl font-semibold text-primary">Daftar Pengguna</h2>
    <a href="<?= base_url("users/users_create") ?>" class="flex justify-center items-center gap-1 buttonInfo p-2">
      <img src="<?= base_url('assets/icons/add-line-white-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
      <img src="<?= base_url('assets/icons/add-line-blue-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
      <span class="font-medium pr-2">Tambah User</span>
    </a>
  </header>
  <?= $this->include('components/flash_message') ?>
  <table class="table-auto w-full my-2">
    <thead>
      <tr>
        <td class="border p-2 bg-primary text-secondary font-semibold text-center w-[60px]">No</td>
        <td class="border p-2 bg-primary text-secondary font-semibold text-center">
          <h2 class="hidden md:block">Username</h2>
          <h2 class="block md:hidden">Detail</h2>
        </td>
        <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Role</td>
        <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Status</td>
        <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Terakhir Online</td>
        <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Aksi</td>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      if ($user) {
        foreach ($user as $list) : ?>
          <tr class="group">
            <td class="border p-2 group-odd:bg-netral group-even:bg-light text-black font-medium text-center">
              <?= $i ?>
            </td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-light text-primary font-medium text-center block md:table-cell"><?= $list['username'] ?></td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-light font-semibold inline-block w-[50%] md:w-max md:table-cell">
              <?php if ($list['role'] == 'admin') { ?>
                <span class="block bg-danger p-2 w-max rounded-md text-netral m-auto select-none">
                  <?= $list['role'] ?>
                </span>
              <?php } ?>
              <?php if ($list['role'] == 'gudang') { ?>
                <span class="block bg-success p-2 w-max rounded-md text-netral m-auto select-none">
                  <?= $list['role'] ?>
                </span>
              <?php } ?>
              <?php if ($list['role'] == 'kasir') { ?>
                <span class="block bg-info p-2 w-max rounded-md text-netral m-auto select-none">
                  <?= $list['role'] ?>
                </span>
              <?php } ?>
            </td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-light font-medium text-start md:text-center inline-block w-[50%] md:w-max md:table-cell">
              <?php if ($list['status']) { ?>
                <span class="block p-2 bg-success rounded-md text-netral w-max m-auto select-none">Online</span>
              <?php } else { ?>
                <span class="block p-2 bg-primary rounded-md text-netral w-max m-auto select-none">Offline</span>
              <?php } ?>
            </td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-light text-primary font-medium text-center block md:table-cell">
              <?= $list['updated_at'] ?>
            </td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-light block md:table-cell">
              <div class="flex w-full justify-center md:justify-center items-center gap-2">
                <a href="<?= base_url("users/users_edit/" . $list['username']) ?>" class="buttonInfo p-2 font-medium text-netral block w-max">
                  <img src="<?= base_url('assets/icons/user-line-details-white-1.svg') ?>" alt="user-detail" class="w-[30px] h-[30px] object-cover">
                  <img src="<?= base_url('assets/icons/user-line-details-blue-1.svg') ?>" alt="user-detail" class="w-[30px] h-[30px] object-cover">
                </a>

                <?php if ($list['status'] && $list['username'] != $session['username']) { ?>
                  <form action="<?= base_url('users/remove_access') ?>" method="post" id="form_hak_akses<?= $i ?>">
                    <? csrf_field() ?>
                    <input type="hidden" name="username" value="<?= $list['username'] ?>">
                    <button type="button" class="p-2 buttonDanger" onclick="messageConfirmation({ icons: 'user-line-block-black-1', title: 'Hapus Hak Akses', text: 'Anda yakin ingin menghapus hak akses user <?= $list['username'] ?>?', form: 'form_hak_akses<?= $i ?>' })">
                      <img src="<?= base_url('assets/icons/user-line-block-white-1.svg') ?>" alt="user-block" class="w-[30px] h-[30px] object-cover">
                      <img src="<?= base_url('assets/icons/user-line-block-red-1.svg') ?>" alt="user-block" class="w-[30px] h-[30px] object-cover">
                    </button>
                  </form>
                <?php } ?>
              </div>
            </td>
          </tr>
        <?php
          $i++;
        endforeach;
      } else { ?>
        <tr>
          <td colspan="7">
            <div class="loading">
              <h2>Tidak ada user!</h2>
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</main>

<?= $this->endSection(); ?>