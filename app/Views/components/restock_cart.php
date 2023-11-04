<div class="block w-full h-full md:h-screen bg-white rounded-md p-2 relative">
  <label for="restockButton" class="absolute top-2 block lg:hidden h-[40px] w-[40px] bg-white hover:bg-black/5 p-1 rounded-md cursor-pointer border-2 ease-in-out duration-200 labelButton nonActive" id="labelButton">
    <input type="checkbox" name="restockButton" id="restockButton" class="hidden">
    <img src="<?= base_url('assets/icons/file-list-line.svg') ?>" alt="file-list-line" class="h-full w-full object-cover">
  </label>
  <h2 class="p-2 text-center font-semibold text-lg">List Barang</h2>
  <div class="flex justify-start items-start gap-2 mt-2">
    <span class="block mb-2 text-sm font-medium text-black/80">NoRS.</span>
    <span class="block mb-2 text-sm font-semibold text-black/80"><?= $noRes ?></span>
  </div>
  <div class="flex flex-col items-center justify-start gap-2 h-full md:h-[65%] lg:h-[55%] md:overflow-y-scroll scroll-smooth scrollBar scrollBarBg scrollBarColors overflow-hidden" id="restock_list_cart">
  </div>
  <div class="block w-full mt-2">
    <label for="decription">
      <textarea id="description" rows="5" class="block w-full mb-2 outline-none border-2 rounded-md p-2" placeholder="Deskripsi..."></textarea>
    </label>
    <button class="block w-full bg-add hover:bg-addHover ease-in-out duration-100 p-2 rounded-md text-white font-semibold">Buat Permintaan</button>
  </div>
</div>