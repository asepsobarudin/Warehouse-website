<?php
$list_menu = [
  [
    'title' => 'Dashboard',
    'link' => '/',
    'icons' => 'dashboard'
  ],
  [
    'title' => 'Cashier',
    'link' => 'cashier',
    'icons' => 'cashier'
  ],
  [
    'title' => 'Goods',
    'link' => 'goods',
    'icons' => 'box'
  ],
  [
    'title' => 'Transaction',
    'link' => 'transaction',
    'icons' => 'bill'
  ]
]
?>

<nav class="navbar not_active ease-in-out duration-200" id="navbar">
  <label for="btn_nav" class="w-[30px] h-[30px] p-2 rounded-full bg-white absolute -right-4 top-12 z-10 select-none cursor-pointer border-2">
    <img src="<?= base_url("assets/icons/arrow1.png") ?>" alt="arrow" class="w-full h-full object-cover ease-in-out duration-200 nav_btn_image">
    <input type="checkbox" name="btn_nav" id="btn_nav" class="hidden">
  </label>
  <div class="container py-2 px-4 flex flex-col justify-between items-center h-full w-full">
    <div class="block">
      <div class="flex justify-center items-center gap-2 bg-black/10 p-2 rounded-full profile ease-in-out duration-200">
        <div class="flex justify-center items-center w-[40px] h-[40px] rounded-full overflow-hidden">
          <img src="<?= base_url("assets/images/image1.jpeg") ?>" alt="image1" class="w-full h-full object-cover">
        </div>
        <h2 class="text-sm font-medium tit_company ease-in-out duration-200 delay-500">TB Serba Ada</h2>
      </div>
      <div class="flex flex-col justify-center items-center gap-2 mt-4">
        <?php foreach ($list_menu as $list) : ?>
          <a href="<?= $list['link'] ?>" class="flex justify-start items-center gap-2 rounded-md p-1 hover:bg-black/5 relative ease-in-out duration-200 menu active:bg-transparent active:border-2">
            <div class="w-[30px] h-[30px]">
              <img src="<?= base_url("assets/icons/" . $list['icons'] . ".png") ?>" alt="<?= $list['icons'] ?>" class="w-full h-full object-cover">
            </div>
            <h2 class="text-sm font-medium tit_menu ease-in-out duration-200"><?= $list['title'] ?></h2>
            <?php if ($list['title'] == $title) : ?>
              <span class="block absolute h-[80%] w-[3px] rounded-full bg-black/60 right-0"></span>
            <?php endif; ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="block">
      <span class="flex justify-center items-center bg-yellow-400 hover:bg-yellow-500 rounded-full p-2 gap-1 ease-in-out duration-200 mb-4 btm_menu">
        <div class="w-[30px] h-[30px]">
          <img src="<?= base_url("assets/icons/user.png") ?>" alt="logout" class="w-full h-full object-cover">
        </div>
        <h2 class="text-sm font-semibold text-black btm_title">KASIR</h2>
      </span>
      <a href="#" class="flex justify-center items-center bg-red-600 hover:bg-red-700 rounded-md p-1 gap-1 ease-in-out duration-200 btm_menu">
        <div class="w-[30px] h-[30px]">
          <img src="<?= base_url("assets/icons/logout.png") ?>" alt="logout" class="w-full h-full object-cover">
        </div>
        <h2 class="text-sm font-semibold text-white btm_title">Logout</h2>
      </a>
    </div>
  </div>
</nav>

<!-- Mobile -->
<nav class="navbar_mobile">
  <div class="nav_menu">
    <?php foreach ($list_menu as $menu) : ?>
      <a href="<?= $menu['link'] ?>">
        <img src="<?= base_url("/assets/icons/" . $menu['icons'] . ".png") ?>" alt="<?= base_url($menu['icons']) ?>">
        <?php if ($title == $menu['title']) { ?>
          <span class="active"></span>
        <?php } else { ?>
          <span class="non_active"></span>
        <?php } ?>
      </a>
    <?php endforeach; ?>
  </div>
</nav>