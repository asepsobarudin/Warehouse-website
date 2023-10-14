<?= $this->extend('layout/sub_layout') ?>

<?php if (session()->getFlashdata('_ci_validation_errors')) :
  $errors = session()->getFlashdata('_ci_validation_errors');
endif; ?>

<?= $this->section('content') ?>
<main class="container pt-[70px]">
  <form action="<?= base_url('goods_update') ?>" method="post" enctype="multipart/form-data" class="p-2 bg-white rounded-md flex flex-col gap-2">
    <? csrf_field() ?>
    <div class="flex flex-col lg:flex-row justify-center items-start gap-2 w-full">
      <div class="block w-full lg:w-[40%]">
        <?php if (isset($errors['goods_images'])) : ?>
          <span class="block text-red-600 text-sm font-medium mb-1"><?= $errors['goods_images'] ?></span>
        <?php endif; ?>
        <div class="block w-full h-[450px] rounded-md overflow-hidden">
          <img src="<?= base_url('assets/images/uploads/' . $goods['goods_images']) ?>" alt="images" class="object-contain h-full w-full" id="imgPreview">
        </div>
        <label class="block p-2" for="goods_images">
          <span class="sr-only">Choose profile photo</span>
          <input type="file" class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-200" id="goods_images" name="goods_images" accept="image/png, image/jpg, image/jpeg" onchange="preview()" />
        </label>
      </div>
      <div class="w-full lg:w-[60%] flex flex-col gap-4 py-2">
        <div class="block">
          <input type="hidden" name="goods_code" value="<?= $goods['goods_code'] ?>">
          <label for="goods_name" class="relative flex justify-start items-center">
            <input type="text" id="goods_name" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="Nama" name="goods_name" value="<?= old('goods_name') ? old('goods_name') : $goods['goods_name'] ?>" autofocus>
            <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Goods Name</span>
          </label>
          <?php if (isset($errors['goods_name'])) : ?>
            <span class="block text-red-600 text-sm font-medium mt-1"><?= $errors['goods_name'] ?></span>
          <?php endif; ?>
        </div>
        <div class="block">
          <select name="goods_category" id="goods_category" class="p-2 w-[50%] outline-none border-2 border-black/10 focus:border-black/30 font-medium text-black/80 bg-white rounded-md">
            <option value="">Select Category</option>
            <?php if (isset($category)) : foreach ($category as $list) : ?>
                <option value="<?= $list['category_name'] ?>" <?= old('goods_category') == $list['category_name'] || $goods['goods_category'] == $list['category_name'] ? 'selected' : '' ?>>
                  <?= $list['category_name'] ?>
                </option>
            <?php endforeach;
            endif; ?>
          </select>
          <?php if (isset($errors['goods_category'])) : ?>
            <span class="block text-red-600 text-sm font-medium mt-1"><?= $errors['goods_category'] ?></span>
          <?php endif; ?>
        </div>
        <div class="flex justify-start items-center gap-2 text-sm font-medium text-black/80 px-2">
          <span class="block">Previous Price : </span>
          <span class="block">Rp. <?= number_format($goods['goods_prev_price'], 0, ',', '.') ?></span>
        </div>
        <div class="block w-full">
          <div class="flex items-center gap-2">
            <label for="goods_price" class="relative flex justify-start items-center w-[60%]">
              <input type="number" id="goods_price" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-full" placeholder="0" name="goods_price" value="<?= old('goods_price') ? old('goods_price') : $goods['goods_price']  ?>">
              <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Price</span>
            </label>
            <h2 class="w-[40%] font-semibold text-lg text-black/80" id="out_price">Rp. 0</h2>
          </div>
          <?php if (isset($errors['goods_price'])) : ?>
            <span class="block text-red-600 text-sm font-medium mt-1"><?= $errors['goods_price'] ?></span>
          <?php endif; ?>
        </div>
        <div class="flex flex-col gap-4">
          <label for="goods_stok" class="relative flex justify-start items-center">
            <input type="number" id="goods_stok" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-[50%]" placeholder="0" name="goods_stok" value="<?= old('goods_stok') ? old('goods_stok') : $goods['goods_stok'] ?>" disabled>
            <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Stok</span>
          </label>
          <label for="goods_stok" class="relative flex justify-start items-center">
            <input type="number" id="goods_stok" class="p-2 rounded-md font-medium outline-none border-2 border-black/10 peer focus:border-black/30 w-[50%]" placeholder="0" name="goods_stok" value="<?= old('goods_stok') ? old('goods_stok') : $goods['goods_stok'] ?>">
            <span class="absolute block font-medium text-sm text-black/50 -top-[9px] left-2 bg-white ease-out duration-100 px-1 peer-focus:text-black/60">Add Stok</span>
          </label>
          <div>
            <button class="p-2 bg-slate-400 rounded-md">+</button>
          </div>
        </div>
        <div class="block font-medium text-sm">
          <span class="block p-2 bg-black/10 w-max rounded-md mb-2">Di tambahkan : <?= $goods['created_at'] ?></span>
          <span class="block p-2 bg-black/10 w-max rounded-md">Terakhir di ubah : <?= $goods['updated_at'] ?></span>
        </div>
      </div>
    </div>
    <label for="goods_description" class="relative flex flex-col justify-start items-start w-full">
      <span class="block font-medium text-sm text-black/60 bg-white ease-out duration-100 px-1 mb-2 w-full">Description</span>
      <input id="text_editor" type="hidden" name="goods_description" value="<?= old('goods_description') ? old('goods_description') : '' ?>">
      <trix-editor input="text_editor" class="w-full min-h-[200px] trix-content">
        <?= old('goods_description') ? ''  : $goods['goods_description'] ?>
      </trix-editor>
    </label>
    <div class="flex justify-end items-center">
      <button class="py-2 px-3 bg-sky-600 hover:bg-sky-700 font-semibold text-white rounded-md ease-in-out duration-100 flex justify-center items-center gap-1">
        <span>Simpan</span>
        <img src="<?= base_url('assets/icons/save.png') ?>" alt="save" class="w-[30px] h-[30px]">
      </button>
    </div>
  </form>
</main>
<?= $this->endSection(); ?>