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
  <div class="flex justify-center items-center gap-2 relative w-full rounded-md bg-netral overflow-hidden">
    <img src="<?= base_url('assets/images/form_register.jpg') ?>" alt="form_register" class="h-full w-auto lg:w-[40%] object-cover absolute lg:relative top-0">
    <div class="block p-4 bg-white/80 rounded-md h-full w-full md:w-[60%] lg:w-[50%] relative z-10">
      <?php if ($session['username'] != $users['username'] && !$users['status']) : ?>
        <form action="<?= base_url('users/users_delete') ?>" method="post" class="w-full flex justify-start items-center mb-4" id="form_user_delete">
          <?= csrf_field() ?>
          <input type="hidden" value="<?= $users['username'] ?>" name="username">
          <button type="button" class="buttonDanger py-2 px-3 font-semibold flex justify-center items-center gap-1" onclick="messageConfirmation({ icons: 'user-line-delete-black-1', title: 'Hapus User', text: 'Apakan anda yakin ingin menghapus user \'<?= $users['username'] ?>\'?', form: 'form_user_delete' })">
            <img src="<?= base_url('assets/icons/user-line-delete-white-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
            <img src="<?= base_url('assets/icons/user-line-delete-red-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
            <span>Hapus</span>
          </button>
        </form>
      <?php endif; ?>

      <form action="<?= base_url('users/users_update') ?>" method="post" class="flex flex-col gap-2 w-full" id="form_user_edit">
        <?= csrf_field() ?>
        <label for="username" class="block w-full">
          <div class="flex justify-between items-center w-full flex-wrap gap-2">
            <span class="block font-medium text-primary/80 text-sm">Username</span>
            <?php if (isset($errors['username'])) : ?>
              <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['username'] ?>"</span>
            <?php endif; ?>
          </div>
          <input type="hidden" value="<?= $users['username'] ?>" name="username">
          <input type="text" id="username" class="p-2 rounded-md font-medium border-2 border-black/10 w-full bg-light" value="<?= $users['username'] ?>" disabled>
        </label>
        <div class="block w-full">
          <div class="flex justify-between items-center w-full flex-wrap gap-2">
            <span class="block font-medium text-primary/80 text-sm">Role</span>
            <?php if (isset($errors['role'])) : ?>
              <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['role'] ?>"</span>
            <?php endif; ?>
          </div>
          <select name="role" id="role" class="py-3 px-2 bg-white outline-primary w-full border-2 rounded-md font-medium">
            <option value="0">--Pilih Role--</option>
            <option value="kasir" <?php if ($users['role'] == 'kasir') { ?> selected <?php } ?>>Kasir</option>
            <option value="gudang" <?php if ($users['role'] == 'gudang') { ?> selected <?php } ?>>Gudang</option>
            <option value="admin" <?php if ($users['role'] == 'admin') { ?> selected <?php } ?>>Admin</option>
          </select>
        </div>
        <label for="password" class="block w-full">
          <div class="flex justify-between items-center w-full flex-wrap gap-2">
            <span class="block font-medium text-primary/80 text-sm">Password</span>
            <?php if (isset($errors['password'])) : ?>
              <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['password'] ?>"</span>
            <?php endif; ?>
          </div>
          <input type="text" id="password" class="p-2 rounded-md font-medium outline-primary border-2 border-black/10 peer focus:border-black/30 w-full" name="password">
        </label>
        <label for="passwordConf" class="block w-full">
          <div class="flex justify-between items-center w-full flex-wrap gap-2">
            <span class="block font-medium text-primary/80 text-sm">Konfirmasi Password</span>
            <?php if (isset($errors['passwordConf'])) : ?>
              <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['passwordConf'] ?>"</span>
            <?php endif; ?>
          </div>
          <input type="text" id="passwordConf" class="p-2 rounded-md font-medium outline-primary border-2 border-black/10 peer focus:border-black/30 w-full" name="passwordConf">
        </label>
        <div class="flex justify-end items-center">
          <button type="button" class="buttonWarning py-2 px-3 font-semibold text-black flex justify-center items-center gap-1" onclick="messageConfirmation({ icons : 'user-line-edit-black-1', title: 'Edit User', text: 'Yakin ingin menyimpan perubahan?', form: 'form_user_edit' })">
            <img src="<?= base_url('assets/icons/user-line-edit-white-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
            <img src="<?= base_url('assets/icons/user-line-edit-yellow-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
            <span class="pr-2">Edit</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</main>

<?= $this->endSection(); ?>