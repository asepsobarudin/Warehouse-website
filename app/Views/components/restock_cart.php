<div class="block w-full h-screen bg-white p-2 relative efectTrasition overflow-y-scroll scrollBar scrollBarBg scrollBarColors">
  <input type="checkbox" name="restockButton" id="restockButton" class="hidden">
  <button class="block lg:hidden w-[30px] h-[30px] absolute top-4 right-4 group" onclick="checkButton()">
    <img src="<?= base_url('assets/icons/cart-line-black-1.svg') ?>" alt="file-list-line" class="h-full w-full object-cover block group-hover:hidden">
    <img src="<?= base_url('assets/icons/cart-line-gold-1.svg') ?>" alt="file-list-line" class="h-full w-full object-cover hidden group-hover:block">
  </button>
  <div class="block w-full h-full">
    <div class="flex justify-center items-center gap-2 py-4">
      <img src="<?= base_url() ?>/assets/icons/cart-line-black-1.svg" alt="cart" class="w-[30px] h-[30px] object-cover">
      <h2 class="font-medium text-xl text-primary">Keranjang Barang</h2>
    </div>
    <div class="flex justify-start items-start gap-2 mt-2">
      <span class="block mb-2 text-sm font-medium text-primary/80">Kode Restock : </span>
      <span class="block mb-2 text-sm font-semibold text-primary/80"><?= $restock_code ?></span>
    </div>
    <div class="flex flex-col items-center justify-start gap-2 min-h-[460px] md:overflow-y-scroll scroll-smooth scrollBar scrollBarBg scrollBarColors overflow-hidden" id="restock_list_cart">
      <!-- List Cart Restock -->
    </div>
    <form action="<?= base_url('restock/create') ?>" method="post" class="block w-full mt-2 h-max pb-2" id="form_add_restock">
      <?= csrf_field() ?>
      <input type="hidden" name="restock_code" value="<?= $restock_code ?>">
      <button class="buttonSuccess flex justify-center items-center gap-1 w-full p-2 font-semibold" type="button" id="buttonLoading" onclick="messageConfirmation({ title: 'Kirim Permintaan', text: 'Apakah yakin ingin membuat permintaan?', form: 'form_add_restock' })">
        <img src="<?= base_url('assets/icons/van-line-white-1.svg') ?>" alt="edit-line" class="w-[30px] h-[30px] object-cover">
        <img src="<?= base_url('assets/icons/van-line-green-1.svg') ?>" alt="edit-line" class="w-[30px] h-[30px] object-cover">
        <h2>Kirim</h2>
      </button>
    </form>
  </div>
</div>