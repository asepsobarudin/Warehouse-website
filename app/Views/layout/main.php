 <!doctype html>
 <html lang="en">

 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
   <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/icons.png') ?>">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <title><?= $title ?></title>
 </head>

 <body class="flex justify-center items-start scrollBar scrollBarBg scrollBarColors overflow-x-hidden">
   <?= $this->include('components/navbar/navbar') ?>
   <dialog class="py-2 px-4 rounded-md bg-netral outline-none font-medium fixed top-2 z-10 select-none" id="message_copy">
     Text berhasil di copy.
   </dialog>
   <div class="fixed right-0 z-20">
     <dialog class="notification_message" id="notification_message">
     </dialog>
   </div>
   <dialog class="message_confirmation" id="message_confirmation">
   </dialog>
   <?= $this->renderSection('content'); ?>

   <script src="<?= base_url('/assets/js/components.js') ?>"></script>
   <script>
     const csTable = document.getElementById("cashier_list_table");
     const containerPage = document.getElementById('container_page');
     const baseURL = '<?= base_url() ?>';
     const csrfToken = document.getElementsByName('<?= csrf_token() ?>')[0];

     loadData({
       text: "cashier",
       fnc: `getGoods({url: '${baseURL}goods/goods_list'})`
     });

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
     window.addEventListener('load', (e) => {
       const windowWidth = window.innerWidth;
       if (windowWidth >= 768) {
         btn_nav.checked = true;
       } else {
         btn_nav.checked = false;
       }
       openNav();
     });
     window.addEventListener('resize', (e) => {
       const windowWidth = window.innerWidth;
       if (windowWidth >= 768) {
         btn_nav.checked = true;
       } else {
         btn_nav.checked = false;
       }
       openNav();
     });
   </script>
   <script src="<?= base_url('/assets/js/api.js') ?>"></script>
   <script src="<?= base_url('/assets/js/main.js') ?>"></script>
 </body>

 </html>