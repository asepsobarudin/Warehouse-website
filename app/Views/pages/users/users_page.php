<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php
$session = session()->get('sessionData');
?>

<main class="container" id="main">
  <?= $this->include('components/flash_message') ?>
  <header class="flex justify-between items-center flex-wrap gap-2 my-2">
    <div class="flex justify-center items-center gap-2 w-max">
      <img src="<?= base_url('assets/icons/user-line-groups-purple-1.svg') ?>" alt="users-group" class="w-[30px] h-[30px] object-cover">
      <h2 class="text-2xl font-semibold text-primary">Pengguna</h2>
    </div>
  </header>
  <div class="flex justify-end md:justify-between items-center gap-2 w-full flex-wrap-reverse">
    <form action="<?= base_url('users') ?>" method="post" class="flex justify-center md:justify-end items-center min-w-full md:min-w-[350px] gap-2">
      <?= csrf_field() ?>
      <input type="text" name="search_users" id="search_users" class="p-2 w-[90%] bg-netral border-2 border-primary/10 focus:border-primary/30 rounded-md outline-none font-semibold text-primary/80" placeholder="Cari pengguna...">
      <button class="buttonInfo p-1 w-max">
        <img src="<?= base_url('assets/icons/search-line-white-1.svg') ?>" alt="" class="w-[30px] h-[30px] object-cover">
        <img src="<?= base_url('assets/icons/search-line-blue-1.svg') ?>" alt="" class="w-[30px] h-[30px] object-cover">
      </button>
    </form>
    <a href="<?= base_url("users/users_create") ?>" class="p-2 buttonInfo flex justify-center items-center gap-1">
      <img src="<?= base_url('assets/icons/add-line-white-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
      <img src="<?= base_url('assets/icons/add-line-blue-1.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
      <span class="font-medium pr-2">Tambah User</span>
    </a>
  </div>
  <table class="table-auto w-full my-2">
    <thead>
      <tr>
        <td class="p-2 bg-primary text-secondary font-semibold text-center w-[60px]">#</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center">
          <h2 class="hidden md:block">Username</h2>
          <h2 class="block md:hidden">Detail</h2>
        </td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Role</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Status</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Terakhir Online</td>
        <td class="p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Aksi</td>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      if ($user && $user != null) {
        foreach ($user as $list) : ?>
          <tr class="group">
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-black font-medium text-center">
              <?= $i ?>
            </td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center block md:table-cell"><?= $list['username'] ?></td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark font-semibold inline-block w-[50%] md:w-max md:table-cell">
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
            <td class="p-2 group-odd:bg-netral group-even:bg-dark font-medium text-start md:text-center inline-block w-[50%] md:w-max md:table-cell">
              <?php if ($list['status']) { ?>
                <span class="block p-2 bg-success rounded-md text-netral w-max m-auto select-none">Online</span>
              <?php } else { ?>
                <span class="block p-2 bg-primary rounded-md text-netral w-max m-auto select-none">Offline</span>
              <?php } ?>
            </td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center block md:table-cell">
              <?= $list['updated_at'] ?>
            </td>
            <td class="p-2 group-odd:bg-netral group-even:bg-dark block md:table-cell">
              <div class="flex w-full flex-wrap justify-center md:justify-center items-center gap-2">
                <a href="<?= base_url("users/users_edit/" . $list['username']) ?>" class="buttonInfo p-2 w-full md:w-max flex justify-center items-center gap-2">
                  <img src="<?= base_url('assets/icons/user-line-details-white-1.svg') ?>" alt="user-detail" class="w-[30px] h-[30px] object-cover">
                  <img src="<?= base_url('assets/icons/user-line-details-blue-1.svg') ?>" alt="user-detail" class="w-[30px] h-[30px] object-cover">
                  <h2 class="font-semibold block md:hidden">Detail</h2>
                </a>

                <?php if ($list['status'] && $list['username'] != $session['username']) { ?>
                  <form action="<?= base_url('users/remove_access') ?>" method="post" id="form_hak_akses<?= $i ?>" class="w-full md:w-max">
                    <? csrf_field() ?>
                    <input type="hidden" name="username" value="<?= $list['username'] ?>">
                    <button type="button" class="p-2 buttonDanger w-full flex justify-center items-center gap-2" onclick="messageConfirmation({ icons: 'user-line-block-black-1', title: 'Hapus Hak Akses', text: 'Anda yakin ingin menghapus hak akses user <?= $list['username'] ?>?', form: 'form_hak_akses<?= $i ?>' })">
                      <img src="<?= base_url('assets/icons/user-line-block-white-1.svg') ?>" alt="user-block" class="w-[30px] h-[30px] object-cover">
                      <img src="<?= base_url('assets/icons/user-line-block-red-1.svg') ?>" alt="user-block" class="w-[30px] h-[30px] object-cover">
                      <h2 class="font-semibold block md:hidden">Akses</h2>
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
            <div class="table_loading bg-netral">
              <h2>Tabel kosong</h2>
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</main>

<?= $this->endSection(); ?>