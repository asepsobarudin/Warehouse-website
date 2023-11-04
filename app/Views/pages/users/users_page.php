<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<main class="container p-2" id="main">
  <header class="flex justify-between items-center">
    <h2 class="text-lg font-semibold">Daftar Pengguna</h2>
    <a href="<?= base_url("users/users_create") ?>" class="p-2 bg-add hover:bg-addHover rounded-md ease-in duration-100 flex justify-center items-center gap-1">
      <img src="<?= base_url('assets/icons/add-line.svg') ?>" alt="add" class="w-[30px] h-[30px] object-cover">
      <span class="font-medium text-white pr-2">Tambah User</span>
    </a>
  </header>
  <?php if (session()->getFlashdata('success')) : ?>
    <div class="block w-full p-2 bg-green-600/20 mt-2">
      <span class="text-lg font-semibold text-black/80 rounded-md">
        <?= session()->getFlashdata('success') ?>
      </span>
    </div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('failed')) : ?>
    <div class="block w-full p-2 bg-red-600/20 mt-2">
      <span class="text-lg font-semibold text-black/80 rounded-md">
        <?= session()->getFlashdata('failed') ?>
      </span>
    </div>
  <?php endif; ?>
  <table class="table-auto w-full border my-2">
    <thead>
      <tr>
        <td class="border p-2 bg-pallet1 text-white font-semibold text-center w-[60px]">No</td>
        <td class="border p-2 bg-pallet1 text-white font-semibold text-center">Username</td>
        <td class="border p-2 bg-pallet1 text-white font-semibold text-center hidden md:table-cell">Role</td>
        <td class="border p-2 bg-pallet1 text-white font-semibold text-center">Status</td>
        <td class="border p-2 bg-pallet1 text-white font-semibold text-center hidden md:table-cell">Update</td>
        <td class="border p-2 bg-pallet1 text-white font-semibold text-center">Action</td>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      if ($user) {
        foreach ($user as $list) : ?>
          <tr>
            <td class="border p-2 bg-white text-black font-medium text-center">
              <?= $i ?>
            </td>
            <td class="border p-2 bg-white text-black font-medium"><?= $list['username'] ?></td>
            <td class="border p-2 bg-white text-black font-medium text-center hidden md:table-cell"><?= $list['role'] ?></td>
            <?php if ($list['status']) { ?>
              <td class="border p-2 bg-white font-medium text-center">
                <span class="block p-2 bg-green-600 rounded-md text-white w-max m-auto">Online</span>
              </td>
            <?php } else { ?>
              <td class="border p-2 bg-white font-medium text-center">
                <span class="block p-2 bg-red-600 rounded-md text-white w-max m-auto">Offline</span>
              </td>
            <?php } ?>
            <td class="border p-2 bg-white text-black font-medium text-center hidden md:table-cell">
              <?= $list['updated_at'] ?>
            </td>
            <td class="border p-2 bg-white">
              <div class="flex w-full justify-center items-center gap-2">
                <a href="<?= base_url("users/users_edit/" . $list['username']) ?>" class="p-2 bg-view hover:bg-viewHover rounded-md font-medium text-white ease-in duration-100 block w-max">
                  <div class="w-[30px] h-[30px] block">
                    <img src="<?= base_url('assets/icons/eye-line.svg') ?>" alt="eye" class="h-full w-full object-cover">
                  </div>
                </a>

                <?php if ($list['status']) { ?>
                  <form action="<?= base_url('users/remove_access') ?>" method="post">
                    <? csrf_field() ?>
                    <input type="hidden" name="username" value="<?= $list['username'] ?>">
                    <button type="submit" class="p-2 bg-red-600 hover:bg-deleteHover rounded-md" onclick="return confirm(`Apakah yakin ingin memotong akses <?= $list['username'] ?> ?`)">
                      <div class="w-[30px] h-[30px] block">
                        <img src="<?= base_url('assets/icons/user-forbid-line.svg') ?>" alt="eye" class="h-full w-full object-cover">
                      </div>
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