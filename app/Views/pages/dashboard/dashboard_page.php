<?= $this->extend('layout/main') ?>

<?php
$session = session()->get('sessionData');
?>

<?php
$year =  date('Y');
$month =  date('m');
$day =  date('d');
$dayName =  date('l');

$bulan = array(
  '01' =>  'Januari',
  '02' => 'Februari',
  '03' => 'Maret',
  '04' => 'April',
  '05' => 'Mei',
  '06' => 'Juni',
  '07' => 'Juli',
  '08' => 'Agustus',
  '09' => 'September',
  '10' => 'Oktober',
  '11' => 'November',
  '12' => 'Desember'
);

$hari = [
  'Monday'    => 'Senin',
  'Tuesday'   => 'Selasa',
  'Wednesday' => 'Rabu',
  'Thursday'  => 'Kamis',
  'Friday'    => 'Jumat',
  'Saturday'  => 'Sabtu',
  'Sunday'    => 'Minggu',
];

?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <header class="flex justify-between items-center w-full gap-2">
    <div class="flex justify-between items-center gap-2 my-4 w-full flex-wrap">
      <div class="flex justify-center items-center w-max gap-2">
        <img src="<?= base_url() ?>/assets/icons/dashboard-line-black-1.svg" alt="dashboard" class="w-[40px] h-[40px] object-cover">
        <h2 class="text-2xl font-semibold text-primary whitespace-normal">
          Dashboard, <span class="text-xl font-semibold text-green-800"><?= $session['username'] ?></span><span class="text-base ml-1">(<?= $session['role'] ?>)</span>
        </h2>
      </div>
      <h2 class="text-lg font-medium">
        <?= $hari[$dayName] . ', ' . $day . ' ' . $bulan[$month] . ' ' . $year ?>
      </h2>
    </div>
    <button class="p-2 flex lg:hidden group hover:bg-black/10 rounded-md effectTrasition" onclick="navMobile()">
      <img src="<?= base_url() ?>assets/icons/menu-line-black-1.svg" alt="menu" class="w-[30px] h-[30px] object-cover">
    </button>
  </header>
  <div class="flex justify-start items-center flex-wrap gap-2 mb-4">
    <?php if ($session['role'] == "gudang") : ?>
      <div class="flex flex-col justify-center items-start p-3 bg-white rounded-md text-black shadow-md w-full md:w-[49%] lg:w-[19%] hover:bg-info hover:text-white effectTrasition">
        <p class="text-sm font-semibold"> Total Barang Masuk</p>
        <h2 class="font-medium w-full block">
          <span class="text-xl"><?= $goods_in ?></span>
          <span class="text-sm">/Qty</span>
        </h2>
      </div>
      <div class="flex flex-col justify-center items-start p-3 bg-white rounded-md text-black shadow-md w-full md:w-[49%] lg:w-[19%] hover:bg-info hover:text-white effectTrasition">
        <p class="text-sm font-semibold">Total Barang Keluar</p>
        <h2 class="font-medium w-full block">
          <span class="text-xl"><?= $goods_out ?></span>
          <span class="text-sm">/Qty</span>
        </h2>
      </div>
    <?php endif; ?>
    <?php if ($session['role'] == "admin") : ?>
      <a href="<?= site_url() ?>/history" class="flex flex-col justify-center items-start p-3 bg-white rounded-md text-black shadow-md w-full md:w-[49%] lg:w-[19%] hover:bg-info hover:text-white effectTrasition">
        <p class="text-sm font-semibold"> Total Barang Masuk</p>
        <h2 class="font-medium w-full block">
          <span class="text-xl"><?= $goods_in ?></span>
          <span class="text-sm">/Qty</span>
        </h2>
      </a>
      <a href="<?= site_url() ?>/history" class="flex flex-col justify-center items-start p-3 bg-white rounded-md text-black shadow-md w-full md:w-[49%] lg:w-[19%] hover:bg-info hover:text-white effectTrasition">
        <p class="text-sm font-semibold">Total Barang Keluar</p>
        <h2 class="font-medium w-full block">
          <span class="text-xl"><?= $goods_out ?></span>
          <span class="text-sm">/Qty</span>
        </h2>
      </a>
      <a href="<?= site_url() ?>/restock" class="flex flex-col justify-center items-start p-3 bg-white rounded-md text-black shadow-md w-full md:w-[49%] lg:w-[19%] hover:bg-info hover:text-white effectTrasition">
        <p class="text-sm font-semibold">Jumlah Pengiriman</p>
        <h2 class="font-medium w-full block">
          <span class="text-xl"><?= $restock ?></span>
          <span class="text-sm">Pengiriman</span>
        </h2>
      </a>
    <?php endif; ?>
    <a href="<?= site_url() ?>/goods" class="flex flex-col justify-center items-start p-3 bg-white rounded-md text-black shadow-md w-full md:w-[49%] lg:w-[19%] hover:bg-info hover:text-white effectTrasition">
      <p class="text-sm font-semibold">Jumlah Barang</p>
      <h2 class="font-medium w-full block">
        <span class="text-xl"><?= $goods_qty ?></span>
        <span class="text-sm">barang</span>
      </h2>
    </a>
    <?php if ($session['role'] != 'kasir') { ?>
      <a href="<?= site_url() ?>/goods/add_stock" class="flex flex-col justify-center items-start p-3 bg-white rounded-md text-black shadow-md w-full md:w-[49%] lg:w-[19%] hover:bg-info hover:text-white effectTrasition">
        <p class="text-sm font-semibold">Stok Dibawah Minimal</p>
        <h2 class="font-medium w-full block">
          <span class="text-xl"><?= $goods_low ?></span>
          <span class="text-sm">barang</span>
        </h2>
      </a>
    <?php } ?>
  </div>
  <?php if ($session['role'] == "admin") : ?>
    <div class="flex justify-between items-center gap-2 flex-wrap">
      <h2 class="text-lg font-medium">Total Barang Masuk Dan Keluar</h2>
      <label for="input-date" class="w-full md:w-max">
        <input type="date" name="input-date-7" id="input-date-7" class="block w-full md::min-w-[100px] outline-none p-2 border-2 border-black/10 focus:border-black/30 rounded-md" value="<?= date('Y-m-d') ?>" onchange="ChartHistory()">
      </label>
    </div>
    <div class="flex justify-start items-center flex-wrap mt-2">
      <div class="w-full lg:w-[50%] block">
        <div class="w-full min-h-max md:min-h-[400px] lg:min-h-[300px]" id="div_goods_in">
          <canvas id="goods_in"></canvas>
        </div>
      </div>

      <div class="w-full lg:w-[50%] block">
        <div class="w-full min-h-max md:min-h-[400px] lg:min-h-[300px]" id="div_goods_out">
          <canvas id="goods_out"></canvas>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <div class="flex justify-between items-center gap-2 flex-wrap mt-14">
    <h2 class="text-lg font-medium w-full md:w-max text-center">Barang Masuk Dan Keluar</h2>
    <label for="input-date" class="w-full md:w-max">
      <input type="date" name="input-date-1" id="input-date-1" class="block w-full md::min-w-[100px] outline-none p-2 border-2 border-black/10 focus:border-black/30 rounded-md" value="<?= date('Y-m-d') ?>" onchange="GoodsInOut()">
    </label>
  </div>
  <div class="flex justify-start items-center flex-wrap mb-2">
    <div class=" w-full lg:w-[95%] block">
      <div class="w-full min-h-[500px]" id="div_goods_in_list">
        <canvas id="goods_in_list"></canvas>
      </div>
    </div>

    <div class="w-full lg:w-[95%] block">
      <div class="w-full min-h-[500px]" id="div_goods_out_list">
        <canvas id="goods_out_list"></canvas>
      </div>
    </div>
  </div>
</main>
<?= $this->endSection() ?>