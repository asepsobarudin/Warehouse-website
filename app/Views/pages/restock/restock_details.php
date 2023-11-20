<?= $this->extend('layout/sub_layout') ?>

<?= $this->section('content') ?>
<main class="container my-2 flex flex-col items-center justify-start" id="container_page">
  <div class="flex justify-between items-center gap-2 flex-wrap w-full mt-2 px-2">
    <div class="flex justify-center items-center text-primary/80 gap-2 w-max">
      <h2 class="font-medium">Kode Restock :</h2>
      <h2 class="font-semibold">
        <?= $restock ?>
      </h2>
    </div>
    <?php if ($message) : ?>
      <details class="py-2 px-4 bg-netral/80 rounded-md border-2 border-primary/5 accordion cursor-pointer w-full md:w-[300px] lg:w-[400px]">
        <summary class="text-base font-semibold select-none flex items-center gap-2">
          <img src="<?= base_url('assets/icons/arrow-line-2.svg') ?>" alt="arrow" class="w-[30px] effectTrasition rotate-90">
          <span class="text-primary">Pesan</span>
        </summary>
        <div class="py-2 flex flex-col gap-4 w-full">
          <p class="text-base font-medium text-primary/80">
            <?= $message ?>
          </p>
        </div>
      </details>
    <?php endif; ?>
  </div>
  <table class="table-auto w-full border my-2">
    <thead>
      <tr>
        <td class="border p-2 bg-primary text-secondary font-semibold text-center">
          #
        </td>
        <td class="border p-2 bg-primary text-secondary font-semibold text-center">
          <span class="hidden md:block">Nama Barang</span>
          <span class="block md:hidden">Barang</span>
        </td>
        <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Permintaan</td>
        <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Dikirm</td>
        <td class="border p-2 bg-primary text-secondary font-semibold text-center hidden md:table-cell">Status</td>
      </tr>
    </thead>
    <tbody class="">
      <?php if (isset($goods)) {
        $no = 1;
        foreach ($goods as $list) : ?>
          <tr class="group">
            <td class="border p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium text-center"><?= $no ?></td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium block md:table-cell"><?= $list['goods_name'] ?></td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium block md:table-cell text-center"><?= $list['qty'] ?></td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium block md:table-cell text-center"><?= $list['qty_send'] ?></td>
            <td class="border p-2 group-odd:bg-netral group-even:bg-dark text-primary font-medium block md:table-cell text-center">
              <?php
              $qty_send = (int)$list['qty_send'];
              $qty = (int)$list['qty'];
              $percent = ($qty_send / $qty) * 100;
              ?>
              <?= (int)$percent ?>%
            </td>
          </tr>
      <?php $no++;
        endforeach;
      } ?>
    </tbody>
  </table>
</main>
<?= $this->endSection(); ?>