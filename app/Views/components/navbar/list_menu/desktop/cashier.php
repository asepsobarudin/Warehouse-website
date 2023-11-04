<?php
$menu = [
  [
    'title' => 'Kasir',
    'link' => 'cashier',
    'icons' => 'calculator-line'
  ],
  [
    'title' => 'Transaksi',
    'link' => 'transaction',
    'icons' => 'bill-line'
  ],
  [
    'title' => 'Barang',
    'link' => 'goods',
    'icons' => 'archive-2-line'
  ],
];

$role = session()->get('role');
?>

<?php if ($role === 'kasir' || $role === 'admin') : ?>
  <div class="block my-2">
    <div class="w-full flex justify-between items-center head_menu mb-1">
      <span class="block font-medium text-black/70 text-xs ease-in-out duration-200">Kasir</span>
    </div>
    <div class="flex flex-col justify-start items-center gap-1">
      <?php foreach ($menu as $list) : ?>
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
<?php endif; ?>