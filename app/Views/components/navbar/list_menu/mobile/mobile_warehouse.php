<?php
$menu = [
  [
    'title' => 'Barang',
    'link' => 'goods',
    'icons' => 'box-line-gold-1',
  ],
  [
    'title' => 'Distribusi',
    'link' => 'distribution',
    'icons' => 'van-line-gold-1',
  ]
];
$cout = 0;
$session = session()->get('sessionData');
$role = $session['role'];
?>

<?php
if ($role === "gudang") {
  foreach ($menu as $list) { ?>
    <a href="<?= $list['link'] ?>" class="relative p-2 flex justify-center items-center w-max">
      <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="w-[30px] h-[30px] object-cover">
      <?php if ($list['title'] == $title) { ?>
        <span class="block absolute w-full h-1 bg-secondary rounded-md bottom-0"></span>
      <?php } ?>
    </a>
    <?php $cout++;
    if ($cout >= 3) { ?>
      <a href="<?= base_url('menu') ?>" class="relative p-2 flex justify-center items-center w-max">
        <img src="<?= base_url('assets/icons/menu-line-gold-1.svg') ?>" alt="icons" class="w-[30px] h-[30px] object-cover">
        <?php if ($title == "Menu") { ?>
          <span class="block absolute w-full h-1 bg-secondary rounded-md bottom-0"></span>
        <?php } ?>
      </a>
    <?php break;
    } ?>
<?php }
} ?>