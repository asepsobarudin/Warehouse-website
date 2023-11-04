<?= $this->extend('layout/sub_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('_ci_validation_errors')) :
  $errors = session()->getFlashdata('_ci_validation_errors');
endif; ?>

<main class="container mt-2">
  <form action="<?= base_url('users/users_create') ?>" method="post" class="p-2 bg-white rounded-md flex flex-col gap-4">
    <? csrf_field() ?>
    <div class="block w-full">
      <label for="username" class="relative flex justify-start items-center">
        <input type="text" id="username" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full lg:w-[50%]" name="username" value="<?= old('username') ?>" autofocus>
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
        <option value="kasir">Kasir</option>
        <option value="gudang">Gudang</option>
        <option value="admin">Admin</option>
      </select>
      <?php if (isset($errors['role'])) : ?>
        <span class="block text-red-600 text-sm font-medium"><?= $errors['role'] ?></span>
      <?php endif; ?>
    </div>
    <div class="block w-full">
      <label for="password" class="relative flex justify-start items-center">
        <input type="text" id="password" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full lg:w-[50%]" name="password" value="<?= old('password') ?>">
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
        <input type="text" id="passwordConf" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full lg:w-[50%]" name="passwordConf" value="<?= old('passwordConf') ?>">
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
      <button class="py-2 px-3 bg-sky-600 hover:bg-sky-700 font-semibold text-white rounded-md ease-in-out duration-100 flex justify-center items-center gap-1">
        <span>Simpan</span>
        <img src="<?= base_url('assets/icons/save-line.svg') ?>" alt="save" class="w-[30px] h-[30px]">
      </button>
    </div>
  </form>
</main>

<?= $this->endSection(); ?>