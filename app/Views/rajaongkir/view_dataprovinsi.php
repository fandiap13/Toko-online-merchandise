<option value="">-- Pilih Provinsi --</option>

<?php foreach ($dataprovinsi as $key => $tiapprovinsi) : ?>
  <option value="<?= $tiapprovinsi['province_id']; ?>" id_provinsi="<?= $tiapprovinsi['province_id']; ?>" <?= $provinsipembeli == $tiapprovinsi['province_id'] ? 'selected' : ''; ?>>
    <?= $tiapprovinsi['province']; ?>
  </option>
<?php endforeach; ?>