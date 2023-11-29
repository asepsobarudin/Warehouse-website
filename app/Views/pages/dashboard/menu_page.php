<?= $this->extend('layout/main') ?>

<?php
$session = session()->get('sessionData');
$role = $session['role'];

$menu = [
  'cashier' => [
    [
      'title' => 'Kasir',
      'link' => '/cashier',
      'icons' => 'cashier-line-1'
    ],
    [
      'title' => 'Restock',
      'link' => '/restock',
      'icons' => 'restock-line-gold-1'
    ],
    [
      'title' => 'Transaksi',
      'link' => '/transaction',
      'icons' => 'bill-line-gold-1'
    ],
  ],
  'warehouse' => [
    [
      'title' => 'Distribusi',
      'link' => '/distribution',
      'icons' => 'van-line-gold-1',
    ]
  ]
];
?>

<?= $this->section('content') ?>
<main class="container p-2 min-h-screen" id="main">
  <h2 class="w-full font-semibold text-start text-2xl text-primary py-2">Menu Lainnya</h2>
  <div class="flex justify-center items-center flex-col gap-4 w-full md:w-1/2 mt-2">
    <div class="block lg:hidden w-full">
      <?php $i = 1;
      foreach ($menu['cashier'] as $list) { ?>
        <?php if ($role == 'kasir' && $i >= 3) { ?>
          <a href="<?= site_url() . $list['link'] ?>" class="flex justify-start items-center p-2 gap-2 bg-transparent border-b-4 border-transparent hover:bg-primary/10 rounded-t-md hover:border-primary w-full ease-out duration-200 transition-all">
            <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="trash-line" class="block w-[30px] h-[30px]">
            <h2 class="font-semibold text-primary text-base"><?= $list['title'] ?></h2>
          </a>
        <?php } ?>
        <?php if ($role == "admin") { ?>
          <a href="<?= site_url() . $list['link'] ?>" class="flex justify-start items-center p-2 gap-2 bg-transparent border-b-4 border-transparent hover:bg-primary/10 rounded-t-md hover:border-primary w-full ease-out duration-200 transition-all">
            <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="trash-line" class="block w-[30px] h-[30px]">
            <h2 class="font-semibold text-primary text-base"><?= $list['title'] ?></h2>
          </a>
        <?php } ?>
        <?php $i++; ?>
      <?php } ?>
      <?php foreach ($menu['warehouse'] as $list) { ?>
        <?php if ($role == 'gudang' && $i >= 3) { ?>
          <a href="<?= site_url() . $list['link'] ?>" class="flex justify-start items-center p-2 gap-2 bg-transparent border-b-4 border-transparent hover:bg-primary/10 rounded-t-md hover:border-primary w-full ease-out duration-200 transition-all">
            <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="trash-line" class="block w-[30px] h-[30px]">
            <h2 class="font-semibold text-primary text-base"><?= $list['title'] ?></h2>
          </a>
        <?php } ?>
        <?php if ($role == 'admin') { ?>
          <a href="<?= site_url() . $list['link'] ?>" class="flex justify-start items-center p-2 gap-2 bg-transparent border-b-4 border-transparent hover:bg-primary/10 rounded-t-md hover:border-primary w-full ease-out duration-200 transition-all">
            <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="trash-line" class="block w-[30px] h-[30px]">
            <h2 class="font-semibold text-primary text-base"><?= $list['title'] ?></h2>
          </a>
        <?php } ?>
      <?php } ?>
    </div>
    <?php if ($role === "admin" || $role === "gudang") : ?>
      <a href="<?= site_url() ?>/goods/trash" class="flex justify-start items-center p-2 gap-2 bg-transparent border-b-4 border-transparent hover:bg-primary/10 rounded-t-md hover:border-primary w-full ease-out duration-200 transition-all">
        <img src="<?= base_url('assets/icons/trash-line-black-1.svg') ?>" alt="trash-line" class="block w-[30px] h-[30px]">
        <h2 class="font-semibold text-primary text-base">Trash Barang</h2>
      </a>
      <a href="<?= site_url() ?>/restock/trash" class="flex justify-start items-center p-2 gap-2 bg-transparent border-b-4 border-transparent hover:bg-primary/10 rounded-t-md hover:border-primary w-full ease-out duration-200 transition-all">
        <img src="<?= base_url('assets/icons/trash-line-black-1.svg') ?>" alt="trash-line" class="block w-[30px] h-[30px]">
        <h2 class="font-semibold text-primary text-base">Trash Restock</h2>
      </a>
    <?php endif; ?>
    <form action="<?= site_url() ?>/logout" method="post" class="block lg:hidden w-full effectTrasition" id="form_logout">
      <?= csrf_field() ?>
      <input type="hidden" name="username" value="<?= $session['username'] ?>">
      <button type="button" class="flex justify-start items-center gap-1 buttonDanger p-2 w-full" onclick="messageConfirmation({ icons: 'log-out-line-black-1', title: 'Log Out', text: 'Apakah anda yakin ingin keluar?', form: 'form_logout' })">
        <img src="<?= base_url("assets/icons/log-out-line-white-1.svg") ?>" alt="logout" class="w-[30px] h-[30px] object-cover block group-hover:hidden">
        <img src="<?= base_url("assets/icons/log-out-line-red-1.svg") ?>" alt="logout" class="w-[30px] h-[30px] object-cover hidden group-hover:block">
        <h2 class="font-semibold">Logout</h2>
      </button>
    </form>
  </div>
</main>
<?= $this->endSection(); ?>