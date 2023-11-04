<?php
$menu = [
  [
    'title' => 'Stok',
    'link' => 'stock',
    'icons' => 'dropbox-line'
  ],
  [
    'title' => 'Barang',
    'link' => 'goods',
    'icons' => 'archive-2-line'
  ],
];

$role = session()->get('role');
?>

<?php if ($role === 'gudang') : ?>
  <?php foreach ($menu as $list) : ?>
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
<?php endif; ?>