<?php
$list_menu = [
  'all' => [
    [
      'title' => 'Dashboard',
      'link' => '/dashboard',
      'icons' => 'dashboard-line-1'
    ],
  ],
];

$role = session()->get('role');
?>

<nav class="navbar active effectTrasition" id="navbar">
  <?= $this->include('components/flash_message') ?>
  <label for="btn_nav" id="btn_nav_label" class="w-[40px] h-[40px] rounded-full bg-primary hover:bg-secondary absolute -right-4 top-4 z-10 select-none cursor-pointer border-4 border-light flex justify-center items-center p-1 effectTrasition group">
    <img src="<?= base_url('assets/icons/arrow-line-1.svg') ?>" alt="arrow" class="w-full h-full object-contain block group-hover:hidden">
    <img src="<?= base_url('assets/icons/arrow-line-2.svg') ?>" alt="arrow" class="w-full h-full object-contain hidden group-hover:block">
    <input type="checkbox" name="btn_nav" id="btn_nav" class="hidden">
  </label>
  <div class="container py-2 px-4 flex flex-col justify-between items-center h-full w-full overflow-hidden">
    <div class="block">
      <div class="profile flex justify-start items-center gap-2 rounded-full overflow-hidden h-[55px] effectTrasition">
        <div class="w-[40px] h-[40px] rounded-full overflow-hidden">
          <img src="<?= base_url("assets/images/icons.png") ?>" alt="image1" class="w-full h-full object-cover">
        </div>
        <h2 class="tit_company text-sm font-medium overflow-hidden text-secondary effectTrasition">TB SALUYU MEKAR</h2>
      </div>
      <div class="my-2">
        <div class="block">
          <div class="flex flex-col justify-start items-center gap-1">
            <?php foreach ($list_menu['all'] as $list) : ?>
              <a href="<?= $list['link'] ?>" class="menu effectTrasition">
                <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="block w-[30px] h-[30px] object-cover">
                <h2 class="tit_menu effectTrasition"><?= $list['title'] ?></h2>
                <?php if ($list['title'] == $title) : ?>
                  <span class="checkActive effectTrasition"></span>
                <?php endif; ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?= $this->include('components/navbar/list_menu/desktop/admin') ?>
        <?= $this->include('components/navbar/list_menu/desktop/warehouse') ?>
        <?= $this->include('components/navbar/list_menu/desktop/cashier') ?>
      </div>
    </div>

    <div class="block">
      <?php $session = session()->get('sessionData') ?>
      <form action="<?= site_url('/logout') ?>" method="post" class="bg-danger hover:bg-primary border-2 border-transparent hover:border-danger rounded-md flex justify-start items-center p-2 gap-1 btm_menu relative group effectTrasition" id="form_logout">
        <?= csrf_field() ?>
        <input type="hidden" name="username" value="<?= $session['username'] ?>">
        <button type="button" class="flex justify-start items-center gap-1" onclick="messageConfirmation({ icons: 'log-out-line-black-1', title: 'Log Out', text: 'Apakah anda yakin ingin keluar?', form: 'form_logout' })">
          <img src="<?= base_url("assets/icons/log-out-line-white-1.svg") ?>" alt="logout" class="w-[30px] h-[30px] object-cover block group-hover:hidden">
          <img src="<?= base_url("assets/icons/log-out-line-red-1.svg") ?>" alt="logout" class="w-[30px] h-[30px] object-cover hidden group-hover:block">
          <h2 class="text-sm font-semibold btm_title whitespace-nowrap text-start text-netral group-hover:text-danger">Logout</h2>
        </button>
      </form>
    </div>
  </div>
</nav>

<!-- Mobile -->
<nav class="block lg:hidden w-full fixed bottom-0 z-10">
  <div class="flex justify-evenly items-center h-[60px] bg-white rounded-md pb-4">
    <?php foreach ($list_menu['all'] as $list) : ?>
      <a href="<?= $list['link'] ?>">
        <div class="w-[30px] h-[30px]">
          <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="w-full h-full object-cover">
        </div>
        <?php if ($title == $list['title']) { ?>
          <span class="block w-full h-[2px] bg-white rounded-full mt-1"></span>
        <?php } else { ?>
          <span class="block mt-1"></span>
        <?php } ?>
      </a>
    <?php endforeach; ?>
    <?= $this->include('components/navbar/list_menu/mobile/mobile_admin') ?>
    <?= $this->include('components/navbar/list_menu/mobile/mobile_cashier') ?>
    <?= $this->include('components/navbar/list_menu/mobile/mobile_warehouse') ?>
  </div>
</nav>