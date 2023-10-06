 <!doctype html>
 <html lang="en">

 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title><?= $title ?></title>
   <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
   <script src="<?= base_url('/assets/js/main.js') ?>"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 </head>

 <body>
   <?= $this->renderSection('content'); ?>

   <script>
     const baseURL = '<?= base_url() ?>'
     paginate(baseURL)

     const page = document.getElementById("block_ctn")

     function paginateButton(link) {
       document.getElementById("product_container").innerHTML = loading();
       paginate(link)
       page.scrollTo({
         top: 0,
         behavior: "smooth"
       })
       window.scrollTo({
         top: 0,
         behavior: "smooth"
       })
     }

     let typingTimer;
     const doneTypingInterval = 1000;
     $(document).ready(function() {
       const searchInput = $("#search");
       searchInput.on("input", function() {
         clearTimeout(typingTimer);
         typingTimer = setTimeout(function() {
           const keyword = searchInput.val();
           if (keyword) {
             document.getElementById("product_container").innerHTML = loading();
             Search(`${baseURL}/search`, keyword)
           } else {
             paginate(baseURL)
           }
         }, doneTypingInterval);
       });
     });

     function paginateSearchBtn(link) {
       const searchInput = document.getElementById("search")
       document.getElementById("product_container").innerHTML = loading();
       const keyword = searchInput.value
       Search(link, keyword)
       page.scrollTo({
         top: 0,
         behavior: "smooth"
       })
       window.scrollTo({
         top: 0,
         behavior: "smooth"
       })
     }

     const btn_nav = document.getElementById('btn_nav')
     const navbar = document.getElementById('navbar')

     function openNav() {
       if (btn_nav.checked == true) {
         navbar.classList.remove('not_active');
         navbar.classList.add('active');
       } else {
         navbar.classList.remove('active');
         navbar.classList.add('not_active');
       }
     }
     btn_nav.addEventListener('click', (e) => {
       openNav();
     })
   </script>
 </body>

 </html>