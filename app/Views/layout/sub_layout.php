<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>">
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/icons.png') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title> <?= $title ?> </title>
</head>

<body class="flex flex-col justify-start items-center scrollBar scrollBarBg scrollBarColors relative scroll-smooth" id="body">
  <dialog class="message_confirmation" id="message_confirmation">
  </dialog>
  <div class="fixed right-0 bg-transparent z-20">
    <dialog class="notification_message" id="notification_message">
    </dialog>
  </div>
  </div>
  <nav class="w-full h-[60px] bg-white flex justify-center items-center shadow-sm shadow-primary/10 hide-on-print">
    <div class="container flex justify-between items-center gap-2 after:contents-[''] after:block after:w-[40px] px-2">
      <a href="<?= base_url($link) ?>" class="p-1 w-[40px] h-[40px] block rounded-md bg-white  hover:bg-primary/10 efectTrasition">
        <img src="<?= base_url('assets/icons/arrow-line-2.svg') ?>" alt="arrow" class="w-full h-full object-cover rotate-180">
      </a>
      <h2 class="text-lg font-medium text-primary"><?= $title ?></h2>
    </div>
  </nav>
  <?= $this->renderSection('content'); ?>

  <?php
  $session = session()->get('sessionData');
  $restockCode = '';
  if (isset($restock_code)) {
    $restockCode = $restock_code;
  }
  $userRole = '';
  if (isset($session['role'])) {
    $userRole = $session['role'];
  }
  ?>

  <script src="<?= base_url('/assets/js/components.js') ?>"></script>
  <script src="<?= base_url('/assets/js/layout.js') ?>"></script>
  <script>
    const baseURL = '<?= base_url() ?>';
    const siteURL = '<?= site_url() ?>';
    const restockCode = '<?= $restockCode  ?>';
    const userRole = '<?= $userRole ?>';

    const containerPage = document.getElementById('container_page');
    const price = document.getElementById('goods_price');
    const csrfToken = document.getElementsByName('<?= csrf_token() ?>')[0];

    $(document).ready(function() {
      const price = $("#goods_price");
      price.on("input", function() {
        const getPrice = price.val();
        const setPrice = getPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        document.getElementById("out_price").innerHTML = 'Rp. ' + setPrice
      })
    })

    loadData({
      text: "/goods/edit/",
      fnc: 'getPrice()'
    });

    function getPrice() {
      const getPrice = price.value;
      const setPrice = getPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      document.getElementById("out_price").innerHTML = 'Rp. ' + setPrice
    }

    const btnRestock = document.getElementById('restockButton');
    const lyRestock = document.getElementById('restock_cart');
    const body = document.getElementById('body');

    function checkButton() {
      if (!btnRestock.checked) {
        btnRestock.checked = true;
      } else {
        btnRestock.checked = false;
      }
      openCart();
    }

    function openCart() {
      if (btnRestock.checked) {
        lyRestock.classList.remove('nonActive');
        lyRestock.classList.add('active');
        body.classList.add('active')
      } else {
        lyRestock.classList.remove('active');
        lyRestock.classList.add('nonActive');
        body.classList.remove('active')
      }
    }

    window.addEventListener('load', () => {
      const notifValue = document.getElementById('notification_value');
      if (notifValue && notifValue.value != '') {
        notification({
          notif: {
            title: notifValue.value
          }
        })
      }
    })

    function addGoodsQty({
      getQty,
      viewQty,
      inputQty,
      oprator
    }) {
      const setQty = document.getElementById(getQty);
      const setView = document.getElementById(viewQty);
      const setInput = document.getElementById(inputQty);

      let result;
      if (oprator == 'plus') {
        result = parseInt(setQty.value) + parseInt(setInput.value);
      } else {
        result = parseInt(setQty.value) - parseInt(setInput.value);
      }

      if (result >= 0) {
        setView.innerHTML = result;
        setQty.value = result;
      }
    }
  </script>
  <script src="<?= base_url('/assets/js/api.js') ?>"></script>
  <script src="<?= base_url('/assets/js/sub_main.js') ?>"></script>
</body>

</html>