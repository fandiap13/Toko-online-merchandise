<option value="">-- Pilih --</option>

<?php

foreach ($datadistrik as $key => $value) :

?>

  <option value="<?= $value['city_id']; ?>" <?= $distrik == $value['city_id'] ? 'selected' : ''; ?>><?= $value['type']; ?> <?= $value['city_name']; ?></option>

<?php endforeach; ?>