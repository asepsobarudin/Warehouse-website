 <!doctype html>
 <html lang="en">

 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <title><?= $title ?></title>
 </head>

 <body class="flex justify-center items-start">
   <?= $this->include('components/navbar') ?>
   <?= $this->renderSection('content'); ?>

   <script src="<?= base_url('/assets/js/main.js') ?>"></script>
   <script>
     const goodsContainer = document.getElementById("goods_table");
     const page = document.getElementById("block_ctn")
     const baseURL = '<?= base_url() ?>'

     getGoods(baseURL)

     let typingTimer;
     const doneTypingInterval = 1000;
     $(document).ready(function() {
       const searchInput = $("#search");
       searchInput.on("input", function() {
         goodsContainer.innerHTML = loading();
         clearTimeout(typingTimer);
         typingTimer = setTimeout(function() {
           const key = searchInput.val();
           if (key) {
             searchGoods(`${baseURL}/search`, key)
           } else {
             getGoods(baseURL)
           }
         }, doneTypingInterval);
       });
     });

     const btn_nav = document.getElementById('btn_nav')
     const btn_nav_label = document.getElementById('btn_nav_label')
     const navbar = document.getElementById('navbar')
     const main = document.getElementById('main')

     function openNav() {
       if (btn_nav.checked == true) {
         navbar.classList.remove('not_active');
         navbar.classList.add('active');

         btn_nav_label.classList.add('rotate-180')

         main.classList.add('active')
       } else {
         navbar.classList.remove('active');
         navbar.classList.add('not_active');

         btn_nav_label.classList.remove('rotate-180')

         main.classList.remove('active')
       }
     }
     btn_nav.addEventListener('click', (e) => {
       openNav();
     })
   </script>
 </body>

 </html>