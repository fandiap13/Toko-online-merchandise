<option value="">-- Pilih Distrik --</option>
<?php foreach ($datadistrik as $key => $tiapdistrik) : ?>
  <option 
    id_distrik="<?= $tiapdistrik['city_id']; ?>"
    nama_provinsi="<?= $tiapdistrik['province']; ?>"
    nama_distrik="<?= $tiapdistrik['city_name']; ?>"
    tipe_distrik="<?= $tiapdistrik['type']; ?>"
    kodepos="<?= $tiapdistrik['postal_code']; ?>"
    value="<?= $tiapdistrik['city_id']; ?>"
    <?= $distrikpembeli == $tiapdistrik['city_id'] ? 'selected' : ''; ?>
  >
    <?= $tiapdistrik['type']." ". $tiapdistrik['city_name']; ?>
  </option>
<?php endforeach; ?>