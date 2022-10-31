<!-- edot data -->
<?php if ($ukuranprodukdetail) { ?>
  <option value="">-- Pilih --</option>
  <?php foreach ($ukuranprodukoptions as $u) : ?>
    <option value="<?= $u['ukuran']; ?>" ukuranprodukid="<?= $u['ukuranprodukid']; ?>" <?= $ukuranprodukdetail['ukuran'] == $u['ukuran'] ? 'selected' : ''; ?>><?= $u['ukuran']; ?></option>
  <?php endforeach; ?>
  <!-- tambahdata -->
<?php } else { ?>
  <option value="">-- Pilih --</option>
  <?php foreach ($ukuranprodukoptions as $u) : ?>
    <option value="<?= $u['ukuran']; ?>" ukuranprodukid="<?= $u['ukuranprodukid']; ?>"><?= $u['ukuran']; ?></option>
  <?php endforeach; ?>
<?php } ?>