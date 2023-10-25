<?= $this->extend('layout/sub_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('_ci_validation_errors')) :
  $errors = session()->getFlashdata('_ci_validation_errors');
endif; ?>

<main class="container mt-2">
  <div class="flex flex-col gap-2 bg-white rounded-md p-2">
    <form action="<?= base_url('users/users_delete') ?>" method="post" class="w-full flex justify-end items-center">
      <input type="hidden" value="<?= $users['username'] ?>" name="username">
      <button type="submit" class="py-2 px-3 bg-delete hover:bg-deleteHover font-semibold text-white rounded-md ease-in-out duration-100 flex justify-center items-center gap-1" onclick="return confirm(`Apakah yakin ingin menghapus user <?= $users['username'] ?>`)">
        <img src="<?= base_url('assets/icons/delete-bin-line.svg') ?>" alt="save" class="w-[30px] h-[30px]">
        <span>Hapus</span>
      </button>
    </form>

    <form action="<?= base_url('users/users_update') ?>" method="post" class="flex flex-col gap-4">
      <?php if (session()->getFlashdata('failed')) { ?>
        <div class="block w-full p-2 bg-red-600/20">
          <h2 class="font-medium text-black/80"><?= session()->getFlashdata('failed') ?></h2>
        </div>
      <?php } ?>
      <div class="block w-full">
        <label for="username" class="relative flex justify-start items-center">
          <input type="hidden" value="<?= $users['username'] ?>" name="username">
          <input type="text" id="username" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full lg:w-[50%]" value="<?= $users['username'] ?>" disabled>
          <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white/10 ease-out duration-100 peer-focus:text-black/60">
            <span class="block w-full h-[3px] bg-white absolute top-[9px] z-0"></span>
            <span class="block relative z-10">Username</span>
          </span>
        </label>
        <?php if (isset($errors['username'])) : ?>
          <span class="block text-red-600 text-sm font-medium"><?= $errors['username'] ?></span>
        <?php endif; ?>
      </div>
      <div class="block w-full">
        <select name="role" id="role" class="py-3 px-2 bg-white outline-none w-full lg:w-[50%] border-2 rounded-md">
          <option value="0">--Pilih Role--</option>
          <option value="kasir" <?php if ($users['role'] == 'kasir') { ?> selected <?php } ?>>Kasir</option>
          <option value="gudang" <?php if ($users['role'] == 'gudang') { ?> selected <?php } ?>>Gudang</option>
          <option value="admin" <?php if ($users['role'] == 'admin') { ?> selected <?php } ?>>Admin</option>
        </select>
        <?php if (isset($errors['role'])) : ?>
          <span class="block text-red-600 text-sm font-medium"><?= $errors['role'] ?></span>
        <?php endif; ?>
      </div>
      <div class="block w-full">
        <label for="password" class="relative flex justify-start items-center">
          <input type="text" id="password" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full lg:w-[50%]" name="password">
          <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white/10 ease-out duration-100 peer-focus:text-black/60">
            <span class="block w-full h-[3px] bg-white absolute top-[9px] z-0"></span>
            <span class="block relative z-10">Password</span>
          </span>
        </label>
        <?php if (isset($errors['password'])) : ?>
          <span class="block text-red-600 text-sm font-medium"><?= $errors['password'] ?></span>
        <?php endif; ?>
      </div>
      <div class="block w-full">
        <label for="passwordConf" class="relative flex justify-start items-center">
          <input type="text" id="passwordConf" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full lg:w-[50%]" name="passwordConf">
          <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white/10 ease-out duration-100 peer-focus:text-black/60">
            <span class="block w-full h-[3px] bg-white absolute top-[9px] z-0"></span>
            <span class="block relative z-10">Password Konfirmasi</span>
          </span>
        </label>
        <?php if (isset($errors['passwordConf'])) : ?>
          <span class="block text-red-600 text-sm font-medium"><?= $errors['passwordConf'] ?></span>
        <?php endif; ?>
      </div>
      <div class="flex justify-end items-center">
        <button class="py-2 px-3 bg-edit hover:bg-editHover font-semibold text-black rounded-md ease-in-out duration-100 flex justify-center items-center gap-1" onclick="return confirm(`Apakah yakin ingin mengubah user <?= $users['username'] ?>?`)">
          <img src="<?= base_url('assets/icons/file-edit-line.svg') ?>" alt="save" class="w-[30px] h-[30px]">
          <span class="pr-2">Simpan</span>
        </button>
      </div>
    </form>
  </div>
</main>

<?= $this->endSection(); ?>