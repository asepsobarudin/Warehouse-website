<?php
$menu = [
  [
    'title' => 'Barang',
    'link' => 'goods',
    'icons' => 'box-line-1'
  ],
  [
    'title' => 'Distribusi',
    'link' => 'distribution',
    'icons' => 'car-line-1'
  ]
];

$session = session()->get('sessionData');
$role = $session['role'];
?>

<?php if ($role === 'gudang' || $role === 'admin') : ?>
  <div class="block my-2">
    <div class="w-full flex justify-between items-center head_menu mb-1">
      <span class="block font-semibold text-netral/80 text-xs ease-in-out duration-200">Gudang</span>
    </div>
    <div class="flex flex-col justify-start items-center gap-1">
      <?php foreach ($menu as $list) : ?>
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