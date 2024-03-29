<?php
$menu = [
  'all' => [
    [
      'title' => 'Dashboard',
      'link' => '/dashboard',
      'icons' => 'dashboard-line-gold-1',
    ],
    [
      'title' => 'Barang',
      'link' => '/goods',
      'icons' => 'box-line-gold-1',
    ],
    [
      'title' => 'Pengiriman',
      'link' => '/restock',
      'icons' => 'van-line-gold-1'
    ],
  ],

  'kasir' => [
    [
      'title' => 'Buat Pesanan',
      'link' => '/restock/create',
      'icons' => 'box-line-add-gold-1',
    ],
  ],

  'gudang' => [
    [
      'title' => 'Tambah Stok',
      'link' => '/goods/add_stock',
      'icons' => 'box-line-add-gold-1',
    ],
  ],

  'admin' => [
    [
      'title' => 'Pengguna',
      'link' => '/users',
      'icons' => 'user-line-groups-gold-1'
    ],
    [
      'title' => 'History',
      'link' => '/history',
      'icons' => 'history-line-gold-1'
    ], [
      'title' => 'Trash',
      'link' => '/trash',
      'icons' => 'trash-line-gold-1'
    ]
  ],
];

$session = session()->get('sessionData');
$role = $session['role'];
?>

<nav class="navbar active effectTrasition" id="navbar">
  <?= $this->include('components/flash_message') ?>
  <label for="btn_nav" id="btn_nav_label" class="group w-[40px] h-[40px] rounded-full bg-primary hover:bg-secondary absolute -right-4 top-4 z-10 select-none cursor-pointer border-4 border-white hidden lg:flex justify-center items-center p-1 shadow-inner btn_nav_label effectTrasition">
    <img src="<?= base_url() ?>/assets/icons/arrow-line-1.svg" alt="arrow" class="w-full h-full object-contain block group-hover:hidden effectTrasition">
    <img src="<?= base_url() ?>/assets/icons/arrow-line-2.svg" alt="arrow" class="w-full h-full object-contain hidden group-hover:block effectTrasition">
    <input type="checkbox" name="btn_nav" id="btn_nav" class="hidden">
  </label>
  <div class="container py-2 px-4 flex flex-col justify-between items-center h-full w-full">
    <div class="flex flex-col justify-between items-center w-full h-full overflow-hidden">
      <div class="block w-full">
        <div class="flex justify-between items-center gap-2 my-2 lg:my-0">
          <div class="profile flex justify-start items-center gap-2 rounded-full overflow-hidden h-[55px] relative select-none">
            <img src="<?= base_url() ?>/assets/images/icons.png" alt="image1" class="w-[40px] h-[40px] object-cover rounded-full overflow-hidden block shadow-md">
            <h2 class="tit_company text-base lg:text-sm font-semibold overflow-hidden text-secondary max-w-[150px] lg:max-w-none">TB SALUYU MEKAR</h2>
          </div>
          <button class="p-2 flex lg:hidden group hover:bg-white/10 rounded-md" onclick="navMobile()">
            <img src="<?= base_url() ?>assets/icons/menu-line-gold-2.svg" alt="menu" class="w-[30px] h-[30px] object-cover">
          </button>
        </div>
        <div class="mb-2 mt-4 block w-full">
          <div class="block w-full">
            <div class="flex flex-col justify-start items-center gap-2 lg:gap-1 w-full">
              <?php foreach ($menu['all'] as $list) : ?>
                <?php if ($list['title'] == $title) { ?>
                  <a href="<?= site_url() . $list['link'] ?>" class="menu shadow-black shadow-inner">
                    <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="block w-[30px] h-[30px] object-cover">
                    <h2 class="tit_menu"><?= $list['title'] ?></h2>
                    <span class="checkActive"></span>
                  </a>
                <?php } else { ?>
                  <a href="<?= site_url() . $list['link'] ?>" class="menu not_active">
                    <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="block w-[30px] h-[30px] object-cover">
                    <h2 class="tit_menu"><?= $list['title'] ?></h2>
                  </a>
                <?php } ?>
              <?php endforeach; ?>

              <?php if ($role == 'kasir' || $role == 'admin') { ?>
                <?php foreach ($menu['kasir'] as $list) : ?>
                  <?php if ($list['title'] == $title) { ?>
                    <a href="<?= site_url() . $list['link'] ?>" class="menu shadow-black shadow-inner">
                      <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="block w-[30px] h-[30px] object-cover">
                      <h2 class="tit_menu"><?= $list['title'] ?></h2>
                      <span class="checkActive"></span>
                    </a>
                  <?php } else { ?>
                    <a href="<?= site_url() . $list['link'] ?>" class="menu not_active">
                      <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="block w-[30px] h-[30px] object-cover">
                      <h2 class="tit_menu"><?= $list['title'] ?></h2>
                    </a>
                  <?php } ?>
                <?php endforeach; ?>
              <?php } ?>

              <?php if ($role == 'gudang' || $role == 'admin') { ?>
                <?php foreach ($menu['gudang'] as $list) : ?>
                  <?php if ($list['title'] == $title) { ?>
                    <a href="<?= site_url() . $list['link'] ?>" class="menu shadow-black shadow-inner">
                      <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="block w-[30px] h-[30px] object-cover">
                      <h2 class="tit_menu"><?= $list['title'] ?></h2>
                      <span class="checkActive"></span>
                    </a>
                  <?php } else { ?>
                    <a href="<?= site_url() . $list['link'] ?>" class="menu not_active">
                      <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="block w-[30px] h-[30px] object-cover">
                      <h2 class="tit_menu"><?= $list['title'] ?></h2>
                    </a>
                  <?php } ?>
                <?php endforeach; ?>
              <?php } ?>

              <?php if ($role === 'admin') : ?>
                <div class="block my-2 w-full">
                  <div class="flex justify-between items-center head_menu mb-1">
                    <span class="block font-semibold text-white/80 text-xs">Admin</span>
                  </div>
                  <div class="flex flex-col justify-start items-center gap-2 lg:gap-1">
                    <?php foreach ($menu['admin'] as $list) : ?>
                      <?php if ($list['title'] == $title) { ?>
                        <a href="<?= site_url() . $list['link'] ?>" class="menu shadow-inner shadow-black">
                          <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="block w-[30px] h-[30px] object-cover">
                          <h2 class="tit_menu"><?= $list['title'] ?></h2>
                          <span class="checkActive"></span>
                        </a>
                      <?php } else { ?>
                        <a href="<?= site_url() . $list['link'] ?>" class="menu not_active">
                          <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="block w-[30px] h-[30px] object-cover">
                          <h2 class="tit_menu"><?= $list['title'] ?></h2>
                        </a>
                      <?php } ?>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="flex flex-col justify-center items-center w-full gap-2 lg:gap-1 mb-2">
        <form action="<?= site_url() ?>/logout" method="post" class="bg-primary hover:bg-danger border-2 border-danger hover:border-transparent rounded-md flex justify-start items-center w-full p-2 gap-1 btm_menu relative group" id="form_logout">
          <?= csrf_field() ?>
          <input type="hidden" name="username" value="<?= $session['username'] ?>">
          <button type="button" class="flex justify-start items-center gap-1" onclick="messageConfirmation({ icons: 'log-out-line-black-1', title: 'Log Out', text: 'Apakah anda yakin ingin keluar?', form: 'form_logout' })">
            <img src="<?= base_url("assets/icons/log-out-line-white-1.svg") ?>" alt="logout" class="w-[30px] h-[30px] object-cover hidden group-hover:block">
            <img src="<?= base_url("assets/icons/log-out-line-red-1.svg") ?>" alt="logout" class="w-[30px] h-[30px] object-cover block group-hover:hidden">
            <h2 class="text-sm font-semibold btm_title whitespace-nowrap text-start text-danger group-hover:text-white">Logout</h2>
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>