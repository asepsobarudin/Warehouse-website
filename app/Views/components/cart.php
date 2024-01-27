<div class="block w-full h-[100svh] bg-white p-2 relative efectTrasition overflow-y-scroll scrollBar scrollBarBg scrollBarColors">
  <input type="checkbox" name="restockButton" id="restockButton" class="hidden">
  <button class="block lg:hidden w-[30px] h-[30px] absolute top-4 right-4 group" onclick="checkButton()">
    <img src="<?= base_url('assets/icons/cart-line-black-1.svg') ?>" alt="file-list-line" class="h-full w-full object-cover block group-hover:hidden">
    <img src="<?= base_url('assets/icons/cart-line-gold-1.svg') ?>" alt="file-list-line" class="h-full w-full object-cover hidden group-hover:block">
  </button>
  <form action="<?= base_url('restock/create') ?>" method="post" class="block w-full h-full" id="form_add_restock">
    <?= csrf_field() ?>
    <div class="flex justify-center items-center gap-2 py-4">
      <img src="<?= base_url() ?>/assets/icons/cart-line-black-1.svg" alt="cart" class="w-[30px] h-[30px] object-cover">
      <h2 class="font-medium text-xl text-primary">Keranjang Barang</h2>
    </div>
    <div class="flex flex-col justify-start items-start gap-1 my-2">
      <span class="block text-base font-medium text-primary/80">Masukan Kode Faktur : </span>
      <?php if (isset($restock_code)) { ?>
        <h2><?= $restock_code ?></h2>
        <input type="hidden" name="restock_code" id="restock_code" value="<?= $restock_code ?>">
      <?php } else { ?>
        <input type="text" name="restock_code" id="restock_code" placeholder="010.000-0000000000" class="p-2 outline-none border-2 border-black/10 rounded-md w-full focus:border-black/30">
      <?php } ?>
    </div>
    <div class="flex flex-col items-center justify-start gap-2 min-h-[400px] md:overflow-y-scroll scroll-smooth scrollBar scrollBarBg scrollBarColors overflow-hidden" id="restock_list_cart">
      <!-- List Cart Restock -->
    </div>
    <div class="block w-full mt-2 h-max pb-2">
      <button class="buttonSuccess flex justify-center items-center gap-1 w-full p-2 font-semibold" type="button" id="buttonLoading" onclick="messageConfirmation({ title: 'Kirim Permintaan', text: 'Apakah yakin ingin membuat permintaan?', form: 'form_add_restock' })">
        <img src="<?= base_url('assets/icons/van-line-white-1.svg') ?>" alt="edit-line" class="w-[30px] h-[30px] object-cover">
        <img src="<?= base_url('assets/icons/van-line-green-1.svg') ?>" alt="edit-line" class="w-[30px] h-[30px] object-cover">
        <h2>Buat Permintaan</h2>
      </button>
    </div>
  </form>
</div>