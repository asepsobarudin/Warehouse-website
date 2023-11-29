<?= $this->extend('layout/sub_layout') ?>

<?= $this->section('content') ?>
<main class="container my-2 flex flex-col items-center justify-start px-2" id="container_page">
  <div class="w-full my-4 border-b-[1px] border-black/80" id="header_print">
    <h1 class="text-2xl font-semibold w-full text-center">TB SALUYU MEKAR</h1>
    <h3 class="w-full text-center font-medium text-sm">Penerimaan Barang</h3>
  </div>
  <div class="flex justify-between items-center gap-2 flex-wrap w-full mt-2">
    <div class="flex justify-center items-center text-sm text-primary/80 gap-1 w-max">
      <h2>Kode Restock : </h2>
      <h2>
        <?= $restock ?>
      </h2>
    </div>
    <h2 class="text-sm">Tanggal : <?= $date ?></h2>
  </div>
  <div class="w-full flex justify-start items-end" id="header_print">
    <h2 class="block font-medium w-max text-xs">Nama Penerima : </h2>
  </div>
  <table class="table-auto w-full my-1" id="table_print">
    <thead>
      <tr>
        <td>
          #
        </td>
        <td>
          <span class="hidden md:block">Nama Barang</span>
          <span class="block md:hidden">Barang</span>
        </td>
        <td>Permintaan</td>
        <td>Dikirm</td>
        <td>Lebih</td>
        <td>Kurang</td>
        <td>Rusak</td>
        <td>
          <div class="flex justify-center items-center">
            <img src="<?= base_url() ?>/assets/icons/check-line-black-1.svg" alt="check">
          </div>
        </td>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($goods)) {
        $no = 1;
        foreach ($goods as $list) : ?>
          <tr class="group">
            <td class="group-odd:bg-netral group-even:bg-dark"><?= $no ?></td>
            <td class="group-odd:bg-netral group-even:bg-dark"><?= $list['goods_name'] ?></td>
            <td class="group-odd:bg-netral group-even:bg-dark"><?= $list['qty'] ?></td>
            <td class="group-odd:bg-netral group-even:bg-dark"><?= $list['qty_send'] ?></td>
            <td class="group-odd:bg-netral group-even:bg-dark"></td>
            <td class="group-odd:bg-netral group-even:bg-dark"></td>
            <td class="group-odd:bg-netral group-even:bg-dark"></td>
            <td class="group-odd:bg-netral group-even:bg-dark"></td>
          </tr>
      <?php $no++;
        endforeach;
      } ?>
    </tbody>
  </table>
  <?php if ($message) : ?>
    <div class="py-2 flex flex-col gap-2 w-full hide-on-print">
      <h2 class="font-semibold text-primary text-lg">Pesan</h2>
      <span class="block w-full h-[2px] bg-primary/30"></span>
      <p class="text-base font-medium text-primary/80">
        <?= $message ?>
      </p>
    </div>
  <?php endif; ?>
  <div class="w-full flex justify-end items-center hide-on-print">
    <button class="buttonSuccess p-2" onclick="PrintPDF()">
      <h2 class="font-semibold">Export PDF</h2>
    </button>
  </div>
</main>
<?= $this->endSection(); ?>