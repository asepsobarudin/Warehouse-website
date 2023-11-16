<?= $this->extend('layout/sub_layout') ?>

<?= $this->section('content') ?>
<main class="container my-2 flex flex-col items-center justify-start" id="container_page">
  <?= $this->include('components/flash_message') ?>
  <?= csrf_field() ?>
  <div class="w-full h-full block p-2">
    <div class="flex justify-end items-center text-primary/80 font-semibold gap-2 m-2">
      <h2>No Restock :</h2>
      <h2>
        <?= $restock_code ?>
      </h2>
    </div>
    <table class="table-auto w-full border my-2">
      <thead class="hidden md:table-header-group">
        <tr>
          <td class="border p-2 bg-primary text-secondary font-semibold text-center">
            <span class="hidden md:block">No</span>
            <span class="block md:hidden">Restok Barang</span>
          </td>
          <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Nama Barang</td>
          <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">
            <span class="hidden lg:block">Stok Gudang</span>
            <span class="block lg:hidden">Qty</span>
          </td>
          <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden lg:table-cell">Qty</td>
          <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Tambah Barang</td>
          <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Status</td>
        </tr>
      </thead>
      <tbody class="distribution_list_goods" id="distribution_list_goods">
        <!-- Restock Goods List -->
      </tbody>
    </table>
    <div class="flex justify-end items-center w-full mb-4 gap-2">
      <?php if ($restock_status == 2) : ?>
        <form action="<?= base_url('distribution/cancle_send') ?>" method="post" id="form_distribution_response">
          <?= csrf_field() ?>
          <input type="hidden" name="restock_code" value="<?= $restock_code ?>">
          <button type="button" class="buttonDanger p-[11px] flex justify-center items-center gap-2" onclick="messageConfirmation({ icons: 'van-line-black-1', title: 'Kirim Barang', text: 'Apakah anda ingin melakukan pengiriman?', form: 'form_distribution_response' })">
            <img src="<?= base_url('assets/icons/cross-line-white-1.svg') ?>" alt="cross-line" class="w-[20px] h-[20px] object-cover">
            <img src="<?= base_url('assets/icons/cross-line-red-1.svg') ?>" alt="cross-line" class="w-[20px] h-[20px] object-cover">
            <h2 class="font-semibold">Batal</h2>
          </button>
        </form>
      <?php endif ?>
      <?php if ($restock_status == 1) : ?>
        <form action="<?= base_url('distribution/send_restock') ?>" method="post" id="form_distribution_response">
          <?= csrf_field() ?>
          <input type="hidden" name="restock_code" value="<?= $restock_code ?>">
          <button type="button" class="buttonSuccess p-2 flex justify-center items-center gap-2" onclick="messageConfirmation({ icons: 'van-line-black-1', title: 'Kirim Barang', text: 'Apakah anda ingin melakukan pengiriman?', form: 'form_distribution_response' })">
            <img src="<?= base_url('assets/icons/van-line-white-1.svg') ?>" alt="van-line" class="w-[30px] h-[30px] object-cover">
            <img src="<?= base_url('assets/icons/van-line-green-1.svg') ?>" alt="van-line" class="w-[30px] h-[30px] object-cover">
            <h2 class="font-semibold">Kirim Barang</h2>
          </button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</main>
<?= $this->endSection() ?>