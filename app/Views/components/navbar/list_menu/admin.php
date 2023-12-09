<?php
$menu = [
  'admin' => [
    [
      'title' => 'Pengguna',
      'link' => '/users',
      'icons' => 'user-line-groups-gold-1'
    ],
    [
      'title' => 'History',
      'link' => '/history',
      'icons' => 'history-line-gold-1'
    ],[
      'title' => 'Trash',
      'link' => '/trash',
      'icons' => 'trash-line-gold-1'
    ]
  ],
];

$session = session()->get('sessionData');
$role = $session['role'];
?>

<?php if ($role === 'admin') : ?>
  <div class="block my-2">
    <div class="flex justify-between items-center head_menu mb-1 efectTrasition">
      <span class="block font-semibold text-white/80 text-xs efectTrasition">Admin</span>
    </div>
    <div class="flex flex-col justify-start items-center gap-2 lg:gap-1">
      <?php foreach ($menu['admin'] as $list) : ?>
        <?php if ($list['title'] == $title) { ?>
          <a href="<?= site_url() . $list['link'] ?>" class="menu effectTrasition shadow-inner shadow-black">
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