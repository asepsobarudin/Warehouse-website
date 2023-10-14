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

<body class="flex flex-col justify-start items-center">
  <nav class="w-full h-[60px] bg-white flex justify-center items-center fixed top-0 z-10">
    <div class="container flex justify-between items-center gap-2 after:contents-[''] after:block px-2">
      <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="p-2 w-[40px] h-[40px] block rounded-md hover:bg-black/10">
        <img src="<?= base_url('assets/icons/arrow1.png') ?>" alt="arrow" class="w-full h-full object-cover rotate-180">
      </a>
      <h2 class="text-lg font-medium"><?= $title ?></h2>
    </div>
  </nav>
  <?= $this->renderSection('content'); ?>

  <script>
    function preview() {
      const cover = document.querySelector('#goods_images');
      const imagePreview = document.querySelector('#imgPreview');

      const fileCover = new FileReader();
      fileCover.readAsDataURL(cover.files[0]);

      fileCover.onload = function(e) {
        imagePreview.src = e.target.result;
      }
    }

    $(document).ready(function() {
      const price = $("#goods_price");
      price.on("input", function() {
        const getPrice = price.val();
        console.log(getPrice)
        const setPrice = getPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        document.getElementById("out_price").innerHTML = 'Rp. ' + setPrice
      })
    })

    const price = document.getElementById('goods_price');

    function getPrice() {
      const getPrice = price.value;
      const setPrice = getPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      document.getElementById("out_price").innerHTML = 'Rp. ' + setPrice
    }
    getPrice();


    document.addEventListener("trix-file-accept", function(event) {
      event.preventDefault();
    });
  </script>
</body>

</html>