<div class="block w-full min-h-screen md:h-screen bg-netral rounded-md p-2 relative efectTrasition">
  <label for="restockButton" class="absolute top-2 block lg:hidden h-[40px] w-[40px] p-1 rounded-md cursor-pointer labelButton nonActive" id="labelButton">
    <img src="<?= base_url('assets/icons/cart-line-gold-1.svg') ?>" alt="file-list-line" class="h-full w-full object-cover">
    <img src="<?= base_url('assets/icons/cart-line-white-1.svg') ?>" alt="file-list-line" class="h-full w-full object-cover">
    <img src="<?= base_url('assets/icons/cart-line-black-1.svg') ?>" alt="file-list-line" class="h-full w-full object-cover">
    <input type="checkbox" name="restockButton" id="restockButton" class="hidden">
  </label>
  <h2 class="px-2 py-4 text-center font-medium text-2xl text-primary">Keranjang Barang</h2>
  <div class="flex justify-start items-start gap-2 mt-2">
    <span class="block mb-2 text-sm font-medium text-primary/80">NoRS.</span>
    <span class="block mb-2 text-sm font-semibold text-primary/80"><?= $restock_code ?></span>
  </div>
  <div class="flex flex-col items-center justify-start gap-2 min-h-[300px] md:h-[65%] lg:h-[55%] md:overflow-y-scroll scroll-smooth scrollBar scrollBarBg scrollBarColors overflow-hidden" id="restock_list_cart">
    <!-- List Cart Restock -->
  </div>
  <form action="<?= base_url('restock/restock_create') ?>" method="post" class="block w-full mt-2" id="form_add_restock">
    <?= csrf_field() ?>
    <input type="hidden" name="restock_code" value="<?= $restock_code ?>">
    <label for="message">
      <textarea id="message" name="message" rows="4" class="block w-full mb-2 outline-none border-2 border-primary/20 focus:border-primary/50 rounded-md p-2 scrollBar scrollBarBg scrollBarColors" placeholder="Pesan..."><?php if (isset($message)) : ?><?= $message ?><?php endif; ?></textarea>
    </label>
    <?php if (!isset($status)) { ?>
      <button class="buttonSuccess block w-full p-2 font-semibold" type="button" id="buttonLoading" onclick="messageConfirmation({ icons: 'send-line-black-1', title: 'Kirim Permintaan Barang', text: 'Apakah yakin ingin membuat permintaan?', form: 'form_add_restock' })">
        Buat Permintaan
      </button>
    <?php } else { ?>
      <button class="buttonWarning block w-full p-2 font-semibold" type="button" id="buttonLoading" onclick="messageConfirmation({ icons: 'update-line-black-1', title: 'Ubah Perminaan Barang', text: 'Apakah anda yakin ingin menyimpan perubahan?', form: 'form_add_restock' })">
        Edit Permintaan
      </button>
    <?php } ?>
  </form>
</div>