<?php
$menu = [
  [
    'title' => 'User',
    'link' => 'users',
    'icons' => 'user-line'
  ],
  [
    'title' => 'All Menu',
    'link' => 'menu',
    'icons' => 'menu-4-line'
  ]
];

$session = session()->get('sessionData');
$role = $session['role'];
?>

<?php if ($role === 'admin') : ?>
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