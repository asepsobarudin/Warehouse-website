<?php
$list_menu = [
  'title_menu' => ['Dashboard', 'Cashier', 'Goods'],
  'link' => ['dashboard', 'cashier', 'goods'],
  'image' => ['dashboard', 'cashier', 'box']
]
?>

<nav class="navbar">
  <div class="nav_ct">
    <div class="nav_logo">
      <img src="<?= base_url("/assets/images/logo.png") ?>" alt="logo">
    </div>
    <div class="nav_menu">
      <?php foreach ($list_menu['title_menu'] as $menu => $title_menu) : ?>
        <a href="<?= $list_menu['link'][$menu] ?>">
          <img src="<?= base_url("/assets/icons/" . $list_menu['image'][$menu] . ".png") ?>" alt="<?= base_url($list_menu['image'][$menu]) ?>">
          <span class="text"><?= $list_menu['title_menu'][$menu] ?></span>
          <?php if ($title == $list_menu['title_menu'][$menu]) { ?>
            <span class="active"></span>
          <?php } else { ?>
            <span class="non_active"></span>
          <?php } ?>
        </a>
      <?php endforeach; ?>
    </div>
    <div class="nav_opt">
      <a href="#">
        <img src="<?= base_url("/assets/icons/logout.png") ?>" alt="logout">
      </a>
    </div>
  </div>
</nav>

<!-- Mobile -->
<nav class="navbar_mobile">
  <div class="nav_menu">
    <?php foreach ($list_menu['title_menu'] as $menu => $title_menu) : ?>
      <a href="<?= $list_menu['link'][$menu] ?>">
        <img src="<?= base_url("/assets/icons/" . $list_menu['image'][$menu] . ".png") ?>" alt="<?= base_url($list_menu['image'][$menu]) ?>">
        <?php if ($title == $list_menu['title_menu'][$menu]) { ?>
          <span class="active"></span>
        <?php } else { ?>
          <span class="non_active"></span>
        <?php } ?>
      </a>
    <?php endforeach; ?>
  </div>
</nav>