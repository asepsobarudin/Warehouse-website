<?php
$menu = [
  [
    'title' => 'Kasir',
    'link' => '/cashier',
    'icons' => 'cashier-line-1'
  ],
  [
    'title' => 'Transaksi',
    'link' => '/transaction',
    'icons' => 'bill-line-gold-1'
  ],
];

$session = session()->get('sessionData');
$role = $session['role'];
?>

<?php if ($role === 'kasir' || $role === 'admin') : ?>
  <div class="block my-2">
    <div class="w-full flex justify-between items-center head_menu mb-1">
      <span class="block font-semibold text-netral/80 text-xs">Kasir</span>
    </div>
    <div class="flex flex-col justify-start items-center gap-1">
      <?php foreach ($menu as $list) : ?>
        <?php if ($list['title'] == $title) { ?>
          <a href="<?= site_url() . $list['link'] ?>" class="menu effectTrasition shadow-inner shadow-black active">
            <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="block w-[30px] h-[30px] object-cover">
            <h2 class="tit_menu effectTrasition"><?= $list['title'] ?></h2>
            <span class="checkActive effectTrasition"></span>
          </a>
        <?php } else { ?>
          <a href="<?= site_url() . $list['link'] ?>" class="menu effectTrasition not_active">
            <img src="<?= base_url('assets/icons/' . $list['icons'] . '.svg') ?>" alt="icons" class="block w-[30px] h-[30px] object-cover">
            <h2 class="tit_menu effectTrasition"><?= $list['title'] ?></h2>
          </a>
        <?php } ?>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>