<?= $this->extend('layout/main'); ?>

<?= $this->section('content') ?>
<main class="container p-2" id="main">
  <?= $this->include('components/flash_message') ?>
  <div class="w-full flex justify-between items-center my-4 gap-2 flex-wrap">
    <div class="flex justify-center items-center gap-2 w-max">
      <img src="<?= base_url('assets/icons/box-line-add-black-1.svg') ?>" alt="box-line" class="w-[40px] h-[40px] object-cover">
      <h2 class="text-2xl text-black font-semibold">Tambah Stok</h2>
    </div>
    <button class="p-2 flex lg:hidden group hover:bg-black/10 rounded-md effectTrasition" onclick="navMobile()">
      <img src="<?= base_url() ?>assets/icons/menu-line-black-1.svg" alt="menu" class="w-[30px] h-[30px] object-cover">
    </button>
  </div>
  <div class="my-4 flex flex-col lg:flex-row justify-center items-start gap-4">
    <form action="<?= site_url() ?>/goods/add_stock" method="post" id="form_goods_stock" class="flex flex-col justify-center items-start gap-2 w-full lg:w-[60%]">
      <?= csrf_field() ?>
      <label for="goods_name" class="block w-full">
        <div class="flex justify-between items-center w-full flex-wrap gap-1">
          <span class="block font-medium text-black/80 text-sm">Nama Barang/Kode</span>
          <?php if (isset($errors['goods_name'])) : ?>
            <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['goods_name'] ?>"</span>
          <?php endif; ?>
        </div>
        <input type="text" id="goods_name" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="Masukan nama/code barang" name="goods_name" list="list_goods" value="<?= old('goods_name') ?>" autofocus>
        <datalist id="list_goods"></datalist>
      </label>
      <label for="goods_qty" class="block w-1/2">
        <div class="flex justify-between items-center w-full flex-wrap gap-1">
          <span class="block font-medium text-black/80 text-sm">Jumlah Barang</span>
          <?php if (isset($errors['goods_qty'])) : ?>
            <span class="block text-danger text-sm font-medium whitespace-nowrap">"<?= $errors['goods_qty'] ?>"</span>
          <?php endif; ?>
        </div>
        <input type="number" id="goods_qty" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="0" name="goods_qty" value="<?= old('goods_qty') ?>">
      </label>
      <div class="flex justify-end items-center w-full">
        <button type="button" class="buttonSuccess py-2 px-3 font-semibold text-white flex justify-center items-center gap-1" onclick="messageConfirmation({ title: 'Tambah stok', text: 'Apakah anda yakin ingin menambah stok barang?', form: 'form_goods_stock' })">
          <img src="<?= base_url('assets/icons/add-line-white-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
          <img src="<?= base_url('assets/icons/add-line-green-1.svg') ?>" alt="save" class="w-[30px] h-[30px]">
          <span>Tambah</span>
        </button>
      </div>
    </form>
    <div class="flex flex-col justify-start items-center w-full lg:w-[40%] h-full border-2 p-2 rounded-md">
      <h2 class="text-xl font-medium w-full text-center px-2 py-4">Stok Barang Dibawah Minimal</h2>
      <span class="block w-full h-[2px] rounded-full bg-primary/50 mb-4"></span>
      <div class="h-full lg:h-[440px] w-full overflow-y-scroll scroll-smooth scrollBar scrollBarBg scrollBarColors block">
        <?php if ($goods) { ?>
          <div class="h-max w-full flex flex-col items-center gap-2">
            <?php foreach ($goods as $list) : ?>
              <div class="flex justify-center items-center gap-2 w-full min-h-[80px] bg-dark rounded-md overflow-hidden">
                <div class="w-[80%] font-medium block h-full p-2">
                  <div class="flex justify-start items-center">
                    <h2 class="text-base w-[90%]">
                      <?= $list['goods_name'] ?>
                    </h2>
                    <button class="block ml-1 p-2 border-2 border-primary/10 hover:border-primary/60 active:border-primary bg-white rounded-md duration-200 ease-in-out" onclick="copyTextToClipboard({copyText: '<?= $list['goods_name'] ?>'})">
                      <img src="<?= base_url('assets/icons/copy-line-1.svg') ?>" alt="copy-line-1" class="w-[20px] h-[20px] object-cover">
                    </button>
                  </div>
                  <span class="block w-full h-[2px] rounded-full bg-primary/30 my-1"></span>
                  <h2 class="text-sm mt-2">Minimal stok : <?= $list['goods_min_stock'] ?></h2>
                </div>
                <div class="flex flex-col justify-center items-center w-[20%]">
                  <h2>Stok</h2>
                  <h2 class="w-max text-center font-semibold text-danger">
                    <?= $list['goods_stock_warehouse'] ?>
                  </h2>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php } else { ?>
          <div class="w-full h-full flex justify-center items-center">
            <div class="flex flex-col justify-center items-center gap-1">
              <img src="<?= base_url() ?>/assets/icons/not-line-black-1.svg" alt="not-line" class="w-[30px] h-[30px] object-cover opacity-80">
              <p class="text-sm opacity-80 font-medium">List kosong</p>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</main>
<?= $this->endSection(); ?>