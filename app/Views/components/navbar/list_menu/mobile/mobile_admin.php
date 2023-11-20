<?php
$menu = [
  [
    'title' => 'Pengguna',
    'link' => 'users',
    'icons' => 'user-line-groups-gold-1',
  ],
  [
    'title' => 'Lainya',
    'link' => 'menu',
    'icons' => 'menu-line-gold-1',
  ]
];

$cout = 0;
$session = session()->get('sessionData');
$role = $session['role'];
?>

<?php
if ($role === "admin") {
  foreach ($menu as $list) { ?>
    <a href="<?= $list['link'] ?>" class="relative p-2 flex justify-center items-center w-max">
      <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="w-[30px] h-[30px] object-cover">
      <?php if ($list['title'] == $title) { ?>
        <span class="block absolute w-full h-1 bg-secondary rounded-md bottom-0"></span>
      <?php } ?>
    </a>
    <?php $cout++;
    if ($cout >= 3 || $role == "admin") { ?>
      <a href="<?= base_url('menu') ?>" class="relative p-2 flex justify-center items-center w-max">
        <img src="<?= base_url('assets/icons/menu-line-gold-1.svg') ?>" alt="icons" class="w-[30px] h-[30px] object-cover">
        <?php if ("Menu" == $title) { ?>
          <span class="block absolute w-full h-1 bg-secondary rounded-md bottom-0"></span>
        <?php } ?>
      </a>
    <?php break;
    } ?>
<?php }
} ?>