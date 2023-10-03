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
     paginate('<?= base_url() ?>', '<?= base_url() ?>')

     const page = document.getElementById("block_ctn")

     function paginateButton(link) {
       paginate(link, '<?= base_url() ?>')

       page.scrollTo({
         top: 0,
         behavior: "smooth"
       })
     }

     function paginateButton(link) {
       paginate(link, '<?= base_url() ?>')
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
         document.getElementById("product_container").innerHTML = '<img src="<?= base_url('assets/icons/loading.png') ?>" alt="loading" class="bg-transparent rounded-full h-[40px] w-[40px] relative z-20 flex justify-center items-center animate-spin">';
         typingTimer = setTimeout(function() {
           const keyword = searchInput.val();
           if (keyword) {
             Search('<?= base_url("/search") ?>', '<?= base_url() ?>', keyword)
           } else {
             paginate('<?= base_url() ?>', '<?= base_url() ?>')
           }
         }, doneTypingInterval);
       });
     });

     function paginateSearchBtn(link) {
       const searchInput = document.getElementById("search")
       const keyword = searchInput.value
       Search(link, '<?= base_url() ?>', keyword)
       page.scrollTo({
         top: 0,
         behavior: "smooth"
       })
     }
   </script>
 </body>

 </html>