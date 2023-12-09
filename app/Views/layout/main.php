 <!doctype html>
 <html lang="id">

 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
   <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/icons.png') ?>">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <title><?= $title ?></title>
 </head>

 <body class="flex justify-center items-start scrollBar scrollBarBg scrollBarColors overflow-x-hidden scroll-smooth" id="body">
   <?= $this->include('components/navbar/navbar') ?>
   <dialog class="py-2 px-4 rounded-md bg-white shadow-md outline-none font-medium fixed top-2 z-10 select-none" id="message_copy">
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
   <script src="<?= base_url('/assets/js/layout.js') ?>"></script>
   <script src="<?= base_url('/assets/js/api.js') ?>"></script>
   <script>
     const containerPage = document.getElementById('container_page');
     const baseURL = '<?= base_url() ?>';
     const siteURL = '<?= site_url() ?>';
     const csrfToken = document.getElementsByName('<?= csrf_token() ?>')[0];

     //  Tabel
     const tabelGoodsList = document.getElementById('goods_page_list');
     const tabelGoodsHistory = document.getElementById('tabel_history_list');
     const tabelTrashRestock = document.getElementById('trash_restock_list');
     const tabelTrashGoods = document.getElementById('trash_goods_list');
     //  End Tabel

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

     const btn_nav = document.getElementById('btn_nav');
     const btn_nav_label = document.getElementById('btn_nav_label');
     const navbar = document.getElementById('navbar');
     const main = document.getElementById('main');
     const body = document.getElementById('body');

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

     function navMobile() {
       if (btn_nav.checked == true) {
         btn_nav.checked = false;
         body.classList.remove('notScroll')
       } else {
         btn_nav.checked = true;
         body.classList.add('notScroll');
       }
       openNav();
     }

     window.addEventListener('load', () => {
       const windowWidth = window.innerWidth;
       if (windowWidth >= 1024) {
         btn_nav.checked = true;
       } else {
         btn_nav.checked = false;
       }
       openNav();
     });

     window.addEventListener('resize', () => {
       const windowWidth = window.innerWidth;
       if (windowWidth >= 1024) {
         btn_nav.checked = true;
       } else {
         btn_nav.checked = false;
       }
       openNav();
     });

     const goodsName = document.getElementById('goods_name');
     let timeGetGoods;
     $(document).ready(function() {
       const gName = $("#goods_name");
       gName.on("input", function() {
         clearTimeout(timeGetGoods);
         timeGetGoods = setTimeout(() => {
           const getValue = gName.val();
           searchGoods({
             goods: getValue
           });
         }, 1000);
       })
     })

     const btnRestock = document.getElementById('restock_trash');
     const btnGoods = document.getElementById('goods_trash');
     const restockList = document.getElementById('restock_trash_list');
     const goodsList = document.getElementById('goods_trash_list');

     btnRestock.addEventListener('click', () => {
       btnGoods.classList.remove('tabActive');
       btnRestock.classList.add('tabActive');
       goodsList.classList.remove('tabActive')
       goodsList.classList.add('tabNotActive')
       restockList.classList.remove('tabNotActive')
       restockList.classList.add('tabActive')
     });

     btnGoods.addEventListener('click', () => {
       GoodsTrashList({
         url: `${siteURL}/goods/trash`
       })
       btnRestock.classList.remove('tabActive');
       btnGoods.classList.add('tabActive');
       restockList.classList.remove('tabActive')
       restockList.classList.add('tabNotActive')
       goodsList.classList.remove('tabNotActive')
       goodsList.classList.add('tabActive')
     })
   </script>
   <script src="<?= base_url('/assets/js/main.js') ?>"></script>
 </body>

 </html>