<?php
$menu = [
  [
    'title' => 'Kasir',
    'link' => 'cashier',
    'icons' => 'calculator-line'
  ],
  [
    'title' => 'Cart',
    'link' => '/cart',
    'icons' => 'shopping-cart-line'
  ],
  [
    'title' => 'Transaksi',
    'link' => 'transaction',
    'icons' => 'bill-line'
  ]
];

$session = session()->get('sessionData');
$role = $session['role'];
?>

<?php if ($role === 'kasir') : ?>
  <?php foreach ($menu as $list) : ?>
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
<?php endif; ?>