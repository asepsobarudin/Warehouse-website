<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
  <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

  <title> <?= $title ?> </title>
</head>

<body class="flex flex-col justify-start items-center scrollBar scrollBarBg scrollBarColors">
  <nav class="w-full h-[60px] bg-white flex justify-center items-center">
    <div class="container flex justify-between items-center gap-2 after:contents-[''] after:block after:w-[40px] px-2">
      <a href="<?= base_url($link) ?>" class="p-1 w-[40px] h-[40px] block rounded-md hover:bg-black/10">
        <img src="<?= base_url('assets/icons/arrow-right-s-line.svg') ?>" alt="arrow" class="w-full h-full object-cover rotate-180">
      </a>
      <h2 class="text-lg font-medium"><?= $title ?></h2>
    </div>
  </nav>
  <?= $this->renderSection('content'); ?>

  <script>
    const goodsContainer = document.getElementById('goods_table')
    const price = document.getElementById('goods_price');
    const baseURL = '<?= base_url() ?>';

    $(document).ready(function() {
      const price = $("#goods_price");
      price.on("input", function() {
        const getPrice = price.val();
        const setPrice = getPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        document.getElementById("out_price").innerHTML = 'Rp. ' + setPrice
      })
    })

    var link = window.location.href;
    var text = 'goods/'
    var getIndex = link.indexOf('goods/')
    var getLink = link.slice(getIndex, getIndex + text.length);
    if (getLink == text) {
      window.addEventListener('load', () => {
        if (price.value) {
          getPrice()
        }
      })
    }

    function getPrice() {
      const getPrice = price.value;
      const setPrice = getPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      document.getElementById("out_price").innerHTML = 'Rp. ' + setPrice
    }

    const btnRestock = document.getElementById('restockButton');
    const lyRestock = document.getElementById('restock_cart');
    const lbRestock = document.getElementById('labelButton');
    btnRestock.addEventListener('click', () => {
      if(btnRestock.checked) {
        lyRestock.classList.remove('nonActive')
        lyRestock.classList.add('active')
        lbRestock.classList.remove('nonActive')
        lbRestock.classList.add('active')
      } else {
        lyRestock.classList.remove('active')
        lyRestock.classList.add('nonActive')
        lbRestock.classList.remove('active')
        lbRestock.classList.add('nonActive')
      }
    })
  </script>
  <script src="<?= base_url('/assets/js/sub_main.js') ?>"></script>
</body>

</html>