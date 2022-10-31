<?php

namespace App\Controllers;

use App\Models\ModelPembeli;
use App\Models\ModelSetting;

class Rajaongkir extends BaseController
{
  public function __construct()
  {
    $modelPembeli = new ModelPembeli();
    $this->pembeli = $modelPembeli->find(session('LoggedUserData')['userid']);
  }

  public function dataprovinsi()
  {
    if ($this->request->isAJAX()) {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "key: " . getenv('API_KEY_RAJA_ONGKIR')
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        // print_r($response);
        // dd($response);

        // json_decode = mengubah json menjadi data biasa
        $arrayresponse = json_decode($response, true);
        $dataprovinsi = $arrayresponse['rajaongkir']['results'];
        $data = [
          'dataprovinsi' => $dataprovinsi,
          'provinsipembeli' => $this->pembeli['provinsipembeli']
        ];
        $json = [
          'data' => view('rajaongkir/view_dataprovinsi', $data)
        ];
        // json_encode = mengubah data biasa kedalam bentuk json
        echo json_encode($json);
      }
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function datadistrik()
  {
    if ($this->request->isAJAX()) {
      $provinsiid = $this->request->getVar('id_provinsi');

      if (empty($provinsiid)) {
        $provinsiid = $this->pembeli['provinsipembeli'];
      }

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=$provinsiid",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "key: " . getenv('API_KEY_RAJA_ONGKIR')
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        $arrayresponse = json_decode($response, true);
        // echo "<pre> $response</pre>";
        $datadistrik = $arrayresponse['rajaongkir']['results'];
        $data = [
          'datadistrik' => $datadistrik,
          'distrikpembeli' => $this->pembeli['distrikpembeli']
        ];
        $json = [
          'data' => view('rajaongkir/view_datadistrik', $data),
        ];
        echo json_encode($json);
      }
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function dataekspedisi()
  {
    if ($this->request->isAJAX()) {
      $json = [
        'data' => view('rajaongkir/view_dataekspedisi')
      ];
      echo json_encode($json);
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }

  public function datapaket()
  {
    if ($this->request->isAJAX()) {
      $ModelSetting = new ModelSetting();
      $lokasitoko = $ModelSetting->first()['distrik'];  // kab.karanganyar

      $ekspedisi = $this->request->getVar('ekspedisi');
      $distrik = $this->request->getVar('distrik');
      $berat = $this->request->getVar('berat');
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=$lokasitoko&destination=$distrik&weight=$berat&courier=$ekspedisi",
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded",
          "key: " . getenv('API_KEY_RAJA_ONGKIR')
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        $arrayresponse = json_decode($response, true);
        // echo "<pre> $response</pre>";
        $datapaket = $arrayresponse['rajaongkir']['results'][0]['costs'];
        $data = [
          'datapaket' => $datapaket
        ];
        $json = [
          'data' => view('rajaongkir/view_datapaket', $data)
        ];
        echo json_encode($json);
      }
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }
}
