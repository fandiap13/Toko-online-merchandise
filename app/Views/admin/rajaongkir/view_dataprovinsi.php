<option value="">-- Pilih --</option>

<?php

foreach ($dataprovinsi as $key => $value) :

?>

<option 
  id_provinsi="<?= $value['province_id']; ?>" <?= $provinsi == $value['province_id'] ? 'selected' : ''; ?> 
  value="<?= $value['province_id']; ?>"
>
  <?= $value['province']; ?>
</option>

<?php endforeach; ?>