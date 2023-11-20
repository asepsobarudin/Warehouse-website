<?php
$menu = [
  'admin' => [
    [
      'title' => 'Pengguna',
      'link' => 'users',
      'icons' => 'user-line-groups-gold-1'
    ],
  ],
  'gudang' => [
    [
      'title' => 'Barang',
      'link' => 'goods',
      'icons' => 'box-line-gold-1'
    ],
    [
      'title' => 'Distribusi',
      'link' => 'distribution',
      'icons' => 'van-line-gold-1'
    ],
  ],
  'kasir' => [
    [
      'title' => 'Kasir',
      'link' => 'cashier',
      'icons' => 'cashier-line-1'
    ],
    [
      'title' => 'Transaksi',
      'link' => 'transaction',
      'icons' => 'bill-line-gold-1'
    ],
    [
      'title' => 'Restock',
      'link' => 'restock',
      'icons' => 'restock-line-gold-1'
    ]
  ]
];

$session = session()->get('sessionData');
$role = $session['role'];
?>

<?php if ($role === 'admin') : ?>
  <div class="block my-2">
    <div class="flex justify-between items-center head_menu mb-1 efectTrasition">
      <span class="block font-semibold text-netral/80 text-xs efectTrasition">Admin</span>
    </div>
    <div class="flex flex-col justify-start items-center gap-1">
      <?php foreach ($menu['admin'] as $list) : ?>
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
  <div class="block my-2">
    <div class="flex justify-between items-center head_menu mb-1 efectTrasition">
      <span class="block font-semibold text-netral/80 text-xs efectTrasition">Gudang</span>
    </div>
    <div class="flex flex-col justify-start items-center gap-1">
      <?php foreach ($menu['gudang'] as $list) : ?>
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
  <div class="block my-2">
    <div class="flex justify-between items-center head_menu mb-1 efectTrasition">
      <span class="block font-semibold text-netral/80 text-xs efectTrasition">Kasir</span>
    </div>
    <div class="flex flex-col justify-start items-center gap-1">
      <?php foreach ($menu['kasir'] as $list) : ?>
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
<?php endif; ?>