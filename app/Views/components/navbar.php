<?php
$list_menu = [
  [
    'title' => 'Dashboard',
    'link' => '/',
    'icons' => 'ti ti-brand-speedtest'
  ],
  [
    'title' => 'Cashier',
    'link' => 'cashier',
    'icons' => 'ti ti-calculator'
  ],
  [
    'title' => 'Goods',
    'link' => 'goods',
    'icons' => 'ti ti-box-seam'
  ],
  [
    'title' => 'Transaction',
    'link' => 'transaction',
    'icons' => 'ti ti-receipt-2'
  ]
]
?>

<nav class="navbar not_active ease-in-out duration-300" id="navbar">
  <label for="btn_nav" class="w-[40px] h-[40px] rounded-full bg-white absolute -right-4 top-4 z-10 select-none cursor-pointer border-4 border-black/5 flex justify-center items-center">
    <i class="ti ti-arrow-badge-right ease-in-out duration-300 nav_btn_image text-[25px]"></i>
    <input type="checkbox" name="btn_nav" id="btn_nav" class="hidden">
  </label>
  <div class="container py-2 px-4 flex flex-col justify-between items-center h-full w-full">
    <div class="block">
      <div class="flex items-center gap-2 rounded-full profile ease-in-out duration-300 overflow-hidden">
        <div class="flex justify-center items-center w-[40px] h-[40px] rounded-full overflow-hidden ">
          <img src="<?= base_url("assets/images/image1.jpeg") ?>" alt="image1" class="w-full h-full object-cover">
        </div>
        <h2 class="text-sm font-medium tit_company ease-in-out duration-300 overflow-hidden whitespace-nowrap">TB Serba</h2>
      </div>
      <span class="block h-[2px] w-full bg-black/20 mt-2"></span>
      <div class="flex flex-col justify-center items-center gap-2 mt-2">
        <?php foreach ($list_menu as $list) : ?>
          <a href="<?= $list['link'] ?>" class="flex justify-start items-center gap-2 rounded-md p-1 hover:bg-black/10 relative ease-in-out duration-300 menu active:bg-transparent active:border-2">
            <div class="w-[30px] h-[30px]">
              <i class="<?= $list['icons'] ?> text-[30px]"></i>
            </div>
            <h2 class="text-sm font-medium tit_menu ease-in-out duration-300 overflow-hidden whitespace-nowrap"><?= $list['title'] ?></h2>
            <?php if ($list['title'] == $title) : ?>
              <span class="block absolute h-[60%] w-[3px] rounded-full bg-black/60 right-0"></span>
            <?php endif; ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="block">
      <span class="flex justify-start items-center bg-black/10 hover:bg-yellow-500 rounded-full p-2 gap-1 ease-in-out duration-300 mb-4 btm_menu">
        <div class="w-[30px] h-[30px]">
          <i class="ti ti-user text-[30px]"></i>
        </div>
        <h2 class="text-sm font-semibold text-black btm_title whitespace-nowrap">KASIR</h2>
      </span>
      <a href="#" class="flex justify-start items-center bg-red-600 hover:bg-red-700 rounded-md p-1 gap-1 ease-in-out duration-300 btm_menu">
        <div class="w-[30px] h-[30px]">
          <i class="ti ti-logout text-[30px] text-white"></i>
        </div>
        <h2 class="text-sm font-semibold text-white  btm_title whitespace-nowrap">Logout</h2>
      </a>
    </div>
  </div>
</nav>

<!-- Mobile -->
<nav class="block lg:hidden w-full fixed bottom-0 p-4">
  <div class="flex justify-evenly items-center h-[60px] bg-white rounded-md">
    <?php foreach ($list_menu as $menu) : ?>
      <a href="<?= $menu['link'] ?>">
        <i class="<?= $menu['icons'] ?> text-[30px]"></i>
        <?php if ($title == $menu['title']) { ?>
          <span class="block w-full h-[2px] bg-black/60 rounded-full"></span>
        <?php } else { ?>
          <span class="non_active"></span>
        <?php } ?>
      </a>
    <?php endforeach; ?>
  </div>
</nav>