<option value="">-- Pilih Distrik --</option>
<?php foreach ($datapaket as $key => $tiappaket) : ?>
  <option 
    paket="<?= $tiappaket['service']; ?>"
    ongkir="<?= $tiappaket['cost'][0]['value']; ?>"
    etd="<?= $tiappaket['cost'][0]['etd']; ?>"
  >
    <?= $tiappaket['service']." ". number_format($tiappaket['cost'][0]['value'], 0, ",", "."); ?>
  </option>
<?php endforeach; ?>