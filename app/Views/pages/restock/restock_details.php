<?= $this->extend('layout/sub_layout') ?>
<?php
$session = session()->get('sessionData');
$role = $session['role'];
?>

<?= $this->section('content') ?>
<main class="container my-2 flex flex-col items-center justify-start px-2" id="container_page">
  <?= $this->include('components/flash_message') ?>
  <div class="flex justify-between items-center gap-2 flex-wrap w-full my-2">
    <div class="flex justify-center items-center text-black gap-1 w-max">
      <h2>Kode Restock : </h2>
      <h2 class="font-semibold">
        <?= $restock ?>
      </h2>
    </div>
    <h2 class="">Tanggal : <?= $date ?></h2>
  </div>
  <table class="table-auto w-full">
    <thead>
      <tr>
        <td class="bg-primary p-2 text-secondary text-center font-semibold">
          #
        </td>
        <td class="bg-primary p-2 text-secondary text-center font-semibold">
          <span class="hidden md:block">Nama Barang</span>
          <span class="block md:hidden">Barang</span>
        </td>
        <td class="bg-primary p-2 text-secondary text-center font-semibold">Qty</td>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($goods)) {
        $i = 1;
        foreach ($goods as $list) : ?>
          <tr class="group">
            <td class="group-odd:bg-white group-even:bg-dark p-2 text-center"><?= $i ?></td>
            <td class="group-odd:bg-white group-even:bg-dark p-2 min-w-[200px] max-w-[400px]"><?= $list['goods_name'] ?></td>
            <td class="group-odd:bg-white group-even:bg-dark p-2 min-w-[60px] text-center"><?= $list['qty'] ?></td>
          </tr>
      <?php $i++;
        endforeach;
      } ?>
    </tbody>
  </table>
  <div class="w-full flex justify-end items-center hide-on-print gap-2 my-2">
    <?php if ($limit < 24) : ?>
      <form action="<?= site_url() ?>/restock/cancle" method="post" id="form_restock_cancle">
        <?= csrf_field() ?>
        <input type="hidden" name="restock_code" value="<?= $restock ?>">
        <button type="button" class="buttonDanger p-2 flex justify-center items-center gap-2" onclick="messageConfirmation({ title: 'Batalkan Pengiriman', text: 'Yakin ingin membatalakn peniriman?', form: 'form_restock_cancle' })">
          <img src="<?= base_url() ?>/assets/icons/success-line-white-1.svg" alt="print" class="w-[30px] h-[30px] object-cover">
          <img src="<?= base_url() ?>/assets/icons/success-line-green-1.svg" alt="print" class="w-[30px] h-[30px] object-cover">
          <h2 class="font-semibold">Batalkan</h2>
        </button>
      </form>
    <?php endif; ?>
  </div>
</main>
<?= $this->endSection(); ?>