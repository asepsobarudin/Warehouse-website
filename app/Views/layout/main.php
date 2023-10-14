 <!doctype html>
 <html lang="en">

 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
   <script src="<?= base_url('/assets/js/main.js') ?>"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

   <title><?= $title ?></title>
 </head>

 <body class="flex justify-center items-start">
   <?= $this->include('components/navbar') ?>
   <?= $this->renderSection('content'); ?>

   <script>
     const goodsContainer = document.getElementById("goods_container");
     const page = document.getElementById("block_ctn")
     const baseURL = '<?= base_url() ?>'

     getGoods(baseURL)

     let typingTimer;
     const doneTypingInterval = 1000;
     $(document).ready(function() {
       const searchInput = $("#search");
       searchInput.on("input", function() {
         clearTimeout(typingTimer);
         typingTimer = setTimeout(function() {
           const key = searchInput.val();
           if (key) {
             document.getElementById("goods_container").innerHTML = loading();
             searchGoods(`${baseURL}/search`, key)
           } else {
             getGoods(baseURL)
           }
         }, doneTypingInterval);
       });
     });

     const btn_nav = document.getElementById('btn_nav')
     const navbar = document.getElementById('navbar')
     const main = document.getElementById('main')

     function openNav() {
       if (btn_nav.checked == true) {
         navbar.classList.remove('not_active');
         navbar.classList.add('active');

         main.classList.add('active')
       } else {
         navbar.classList.remove('active');
         navbar.classList.add('not_active');

         main.classList.remove('active')
       }
     }
     btn_nav.addEventListener('click', (e) => {
       openNav();
     })
   </script>
 </body>

 </html>