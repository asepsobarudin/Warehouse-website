<?= $this->extend('layout/main') ?>

<?= $this->section('content'); ?>
<main class="dashboard_content">
  <?= $this->include('components/navbar') ?>
  <div class="block_ctn" id="block_ctn">
    <header>
      <div>
        <h2>TokoKu</h2>
        <h2>Building Materials Shop</h2>
      </div>
      <div>
        <div class="head_card">
          <img src="<?= base_url("/assets/icons/transaction.png") ?>" alt="transaction">
          <div>
            <h2>Transaksi</h2>
            <h2>10</h2>
          </div>
        </div>
        <div class="head_card">
          <img src="<?= base_url("/assets/icons/goods.png") ?>" alt="transaction">
          <div>
            <h2>Barang Terjual</h2>
            <h2>10</h2>
          </div>
        </div>
        <div class="head_card">
          <img src="<?= base_url("/assets/icons/car_box.png") ?>" alt="transaction">
          <div>
            <h2>Barang Masuk</h2>
            <h2>10</h2>
          </div>
        </div>
      </div>
    </header>
    <div>
      <div>
        <button>
          <img src="<?= base_url("assets/icons/filter.png") ?>" alt="filter">
          <span>Filter</span>
        </button>
      </div>

      <label for="search">
        <span>
          <img src="<?= base_url('assets/icons/search.png') ?>" alt="filter">
        </span>
        <input type="text" id="search" name="search" class="search" placeholder="Search...">
      </label>
    </div>
    <?= $this->include('components/product_card') ?>
    <h2 id="view"></h2>

    <div class="paginate">
      <div class="paginate_text" id="paginate_text">
      </div>
      <div class="paginate_button" id="paginate_button">
      </div>
    </div>
  </div>

  <div class="flex flex-col justify-start w-[400px] h-screen bg-white p-2 gap-2">
    <div class="h-max">
      <div class="flex items-center gap-2 text-xl font-semibold h-max w-full opacity-80 mt-2">
        <img src="<?= base_url("assets/icons/cart.png") ?>" alt="cart" class="w-[40px]">
        <h2>Keranjang</h2>
      </div>
      <div class="flex justify-start items-center gap-2 text-sm font-semibold text-black/50 mb-2">
        <h2>No Transaksi</h2>
        <h2>T-0000001</h2>
      </div>
    </div>
    <div class="h-full flex flex-col justify-start md:mb-[60px] lg:mb-0">
      <div class="cart_list md:h-[60%] lg:h-[50%] 2xl:h-[55%] w-full rounded-md p-1 overflow-y-scroll bg-black/5">
        <div class="w-full h-max flex flex-col justify-start items-start gap-2">
          <?php for ($i = 1; $i <= 8; $i++) { ?>
            <div class="flex justify-start items-start overflow-hidden gap-1 p-1 shadow-md rounded-md bg-white relative">
              <div class="flex flex-col gap-1">
                <img src="<?= base_url("assets/images/image1.jpeg") ?>" alt="image" class="w-[80px] h-[80px] object-cover rounded-md">
                <button class="p-1 bg-red-600 hover:bg-red-700 rounded-md w-full flex justify-center items-center ease-in duration-100">
                  <img src="<?= base_url("assets/icons/close.png") ?>" alt="close" class="w-[20px]">
                </button>
              </div>
              <div class="flex flex-col gap-1 text-sm">
                <h2 class="text-base font-medium">Lorem ipsum dolor sit amet consectetur adipisicing elit.</h2>
                <div>
                  <span class="text-base font-semibold text-green-700">Rp 100.000</span>
                  <span class="text-xs font-semibold text-black/60">/100</span>
                </div>
                <div class="flex justify-end items-center gap-1">
                  <span class="text-sm font-semibold text-black/60">Qty :</span>
                  <input type="number" class="border-2 w-[100px] outline-none rounded-md p-1 focus:border-black/30 text-sm font-semibold" min="0" value="0" placeholder="Qty">
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="w-full h-max p-2 shadow-md rounded-md my-2 border-2 flex flex-col gap-1 text-sm">
        <div class="font-semibold flex justify-between items-center gap-1">
          <h2>Diskon</h2>
          <label for="discount" class="relative">
            <span class="h-full absolute right-2 flex justify-center items-center text-black/80">%</span>
            <input type="number" min="0" max="100" maxlength="3" class="pl-1 py-1 pr-6 w-[75px] border-2 rounded-md outline-none focus:border-black/30" id="discount">
          </label>
        </div>
        <div class="font-semibold text-red-600 flex justify-between items-center">
          <h2>Total Harga</h2>
          <h2>Rp. 500.000</h2>
        </div>
        <div class="font-semibold flex justify-between items-center">
          <h2>Bayar</h2>
          <label for="pay" class="relative">
            <span class="h-full absolute left-2 flex justify-center items-center text-black/80">Rp</span>
            <input type="number" class="pl-7 py-1 pr-1 w-[200px] border-2 rounded-md outline-none focus:border-black/30" id="pay">
          </label>
        </div>
        <div class="font-semibold flex justify-between items-center">
          <h2>Kembalian</h2>
          <h2>Rp. 0</h2>
        </div>
        <div class="font-semibold text-red-600 flex justify-between items-center">
          <h2>Tunggakan</h2>
          <h2>Rp. 500.000</h2>
        </div>
        <button class="flex justify-center items-center gap-1 p-2 bg-green-600 hover:bg-green-700 w-full text-white font-semibold rounded-md ease-in duration-100 mt-2">
          <span>Checkout</span>
          <img src="<?= base_url("assets/icons/checkout.png") ?>" alt="checkout" class="w-[30px]">
        </button>
      </div>
    </div>
  </div>
</main>
<?= $this->endSection(); ?>