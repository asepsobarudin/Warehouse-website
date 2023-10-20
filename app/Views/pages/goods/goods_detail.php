<?= $this->extend('layout/sub_layout') ?>

<?= $this->section('content') ?>
<main class="flex flex-col md:flex-row justify-center w-full h-full md:h-screen overflow-hidden pt-[65px] px-2 pb-2">
  <div class="container flex justify-start flex-col items-start gap-2 overflow-y-scroll">
    <div class="flex flex-col gap-2 p-2 w-full bg-white rounded-md">
      <div class="flex flex-col lg:flex-row justify-center items-start gap-2">
        <div class="w-full lg:w-[50%] h-[400px] rounded-md overflow-hidden">
          <img src="<?= base_url('assets/images/uploads/' . $goods['goods_images']) ?>" alt="images" class="w-full h-full object-contain">
        </div>
        <div class="block w-full lg:w-[50%] py-2">
          <div class="block lg:min-h-[335px]">
            <a href="#" class="py-2 px-3 rounded-md bg-black/10 w-max font-semibold text-black/80 hover:bg-black/30">#<?= $goods['goods_category'] ?></a>
            <h2 class="text-[20px] font-medium mt-2"><?= $goods['goods_name'] ?></h2>
            <div class="text-base flex justify-start items-center gap-2">
              <div>
                <span class="font-semibold text-black/80">Stok</span>
                <span><?= $goods['goods_stok'] ?></span>
              </div>
            </div>
            <h2 class="font-semibold text-[30px] text-green-600 my-2">Rp<?= number_format($goods['goods_price'], 0, ',', '.') ?></h2>
          </div>
          <div class="my-2 flex justify-end items-center">
            <button class="p-2 flex justify-center items-center gap-2 bg-green-600 hover:bg-green-700 rounded-md duration-100 ease-in-out w-max">
              <img src="<?= base_url('assets/icons/add_cart_white.png') ?>" alt="add_cat" class="w-[30px] h-[30px]">
              <h2 class="font-semibold text-white">Add To Cart</h2>
            </button>
          </div>
        </div>
      </div>
      <div class="flex flex-col w-full">
        <div class="block py-2 px-6 border-2 rounded-md">
          <h2 class="font-semibold text-xl mt-2">Description</h2>
          <span class="w-full h-[2px] bg-black/20 rounded-full block my-2"></span>
          <div class="font-normal text-black/80 description">
            <?= $goods['goods_description'] ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?= $this->endSection(); ?>