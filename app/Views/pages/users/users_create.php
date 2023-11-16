<?= $this->extend('layout/sub_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('_ci_validation_errors')) :
  $errors = session()->getFlashdata('_ci_validation_errors');
endif; ?>
<?php
$session = session()->get('sessionData');
?>

<main class="container mt-2 p-2">
  <?= $this->include('components/flash_message') ?>
  <div class="flex justify-center items-center gap-2 bg-netral rounded-md overflow-hidden relative">
    <img src="<?= base_url('assets/images/form_register.jpg') ?>" alt="form_register" class=" h-full w-auto lg:w-[40%] object-cover absolute lg:relative top-0">
    <form action="<?= base_url('users/users_create') ?>" method="post" class="p-4 bg-white/80 rounded-md flex flex-col gap-2 h-full w-full md:w-[60%] lg:w-[50%] relative z-10">
      <?= csrf_field() ?>
      <label for="username" class="relative block w-full">
        <div class="flex justify-between items-center w-full flex-wrap gap-2">
          <span class="block font-medium text-primary/80 text-sm">Username</span>
          <?php if (isset($errors['username'])) : ?>
            <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['username'] ?>"</span>
          <?php endif; ?>
        </div>
        <input type="text" id="username" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" name="username" value="<?= old('username') ?>" placeholder="Masukan username" autofocus>
      </label>
      <div class="block w-full">
        <div class="flex justify-between items-center w-full flex-wrap gap-2">
          <span class="block font-medium text-primary/80 text-sm">Role</span>
          <?php if (isset($errors['role'])) : ?>
            <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['role'] ?>"</span>
          <?php endif; ?>
        </div>
        <select name="role" id="role" class="py-3 px-2 bg-white outline-none w-full border-2 rounded-md font-medium">
          <option value="0">--Pilih Role--</option>
          <option value="kasir">Kasir</option>
          <option value="gudang">Gudang</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <label for="password" class="block">
        <div class="flex justify-between items-center w-full flex-wrap gap-2">
          <span class="block font-medium text-primary/80 text-sm">Password</span>
          <?php if (isset($errors['password'])) : ?>
            <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['password'] ?>"</span>
          <?php endif; ?>
        </div>
        <input type="text" id="password" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" name="password" value="<?= old('password') ?>" placeholder="Masukan password">
      </label>
      <label for="passwordConf" class="block w-full">
        <div class="flex justify-between items-center w-full flex-wrap gap-2">
          <span class="block font-medium text-primary/80 text-sm">Konfirmasi Password</span>
          <?php if (isset($errors['passwordConf'])) : ?>
            <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['passwordConf'] ?>"</span>
          <?php endif; ?>
        </div>
        <input type="text" id="passwordConf" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" name="passwordConf" value="<?= old('passwordConf') ?>" placeholder="Konfirmasi password">
      </label>
      <div class="flex justify-end items-center mt-4">
        <button class="buttonSuccess py-2 px-3 font-semibold flex justify-center items-center gap-1">
          <img src="<?= base_url('assets/icons/user-line-add-white-1.svg') ?>" alt="user-add" class="w-[30px] h-[30px]">
          <img src="<?= base_url('assets/icons/user-line-add-green-1.svg') ?>" alt="user-add" class="w-[30px] h-[30px]">
          <span>Simpan</span>
        </button>
      </div>
    </form>
  </div>
</main>

<?= $this->endSection(); ?>