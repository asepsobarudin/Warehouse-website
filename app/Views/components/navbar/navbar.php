<?php
$list_menu = [
  'all' => [
    [
      'title' => 'Dashboard',
      'link' => '/dashboard',
      'icons' => 'dashboard-line'
    ],
  ],
];

$role = session()->get('role');
?>

<nav class="navbar not_active ease-in-out duration-300" id="navbar">
  <label for="btn_nav" id="btn_nav_label" class="w-[40px] h-[40px] rounded-full bg-pallet3 hover:bg-[#D6D46D] absolute -right-4 top-4 z-10 select-none cursor-pointer border-4 border-[#F6F1EE] flex justify-center items-center ease-in-out duration-200">
    <img src="<?= base_url('assets/icons/arrow-right-s-line.svg') ?>" alt="arrow" class="w-full h-full object-contain">
    <input type="checkbox" name="btn_nav" id="btn_nav" class="hidden">
  </label>
  <div class="container py-2 px-4 flex flex-col justify-between items-center h-full w-full">
    <div class="block">
      <div class="flex justify-start items-center gap-2 rounded-full profile overflow-hidden transition-all duration-300 ease-in-out h-[55px]">
        <div class="w-[40px] h-[40px] rounded-full overflow-hidden">
          <img src="<?= base_url("assets/images/icons.png") ?>" alt="image1" class="w-full h-full object-cover">
        </div>
        <h2 class="text-sm font-medium tit_company overflow-hidden transition-all duration-300 ease-in-out">TB SALUYU MEKAR</h2>
      </div>
      <div class="my-2">
        <div class="block">
          <div class="flex flex-col justify-start items-center gap-1">
            <?php foreach ($list_menu['all'] as $list) : ?>
              <a href="<?= $list['link'] ?>" class="flex justify-start items-center gap-2 rounded-md p-1 hover:bg-primay1/80 relative ease-in-out duration-100 menu">
                <div class="w-[30px] h-[30px]">
                  <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="w-full h-full object-cover">
                </div>
                <h2 class="text-sm font-medium tit_menu ease-in-out duration-300 overflow-hidden whitespace-nowrap"><?= $list['title'] ?></h2>
                <?php if ($list['title'] == $title) : ?>
                  <span class="block absolute h-[60%] w-[3px] rounded-full bg-pallet1 right-0"></span>
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
      <div class="flex justify-start items-center bg-delete hover:bg-deleteHover rounded-md p-2 gap-1 ease-in-out duration-100 btm_menu relative">
        <a href="<?= site_url('/logout') ?>" class="flex justify-start items-center gap-1">
          <div class="w-[30px] h-[30px]">
            <img src="<?= base_url("assets/icons/logout-box-line.svg") ?>" alt="logout" class="w-full h-full object-cover">
          </div>
          <h2 class="text-sm font-semibold text-white btm_title whitespace-nowrap ease-in-out duration-300 text-start">Logout</h2>
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- Mobile -->
<nav class="block lg:hidden w-full fixed bottom-0 z-10">
  <div class="flex justify-evenly items-center h-[60px] bg-primay1 rounded-md pb-4">
    <?php foreach ($list_menu['all'] as $list) : ?>
      <a href="<?= $list['link'] ?>">
        <div class="w-[30px] h-[30px]">
          <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="w-full h-full object-cover">
        </div>
        <?php if ($title == $list['title']) { ?>
          <span class="block w-full h-[2px] bg-pallet1 rounded-full mt-1"></span>
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