<?php

function kirim_email($to, $token)
{
  $email = \Config\Services::email();
  $email->setTo($to);
  $email->setFrom('crewpucksapi@gmail.com', 'HMPTI merchandise');

  $title = "Konfirmasi Registrasi";

  $pesan = "Akun yang kamu miliki dengan E-mail " . $to . " telah siap digunakan, silahkan melakukan aktifasi E-mail dengan cara klik link ini: " . site_url('/') . "verifikasi?email=" . $to . "&token=" . $token;

  $email->setSubject($title);
  $email->setMessage($pesan);
  return $email->send();

  // $data = $email->printDebugger(['headers']);
  // print_r($data); 
}
