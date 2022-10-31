<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelSetting;

class RajaongkirAdmin extends BaseController
{

  public function dataprovinsi()
  {
    if ($this->request->isAJAX()) {

      $id = $this->request->getVar('id');
      $ModelSetting = new ModelSetting();
      $dataSetting = $ModelSetting->find($id);

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
        // dd($response);
        // json_decode = mengubah json menjadi data biasa
        $arrayresponse = json_decode($response, true);
        $dataprovinsi = $arrayresponse['rajaongkir']['results'];
        $data = [
          'provinsi' => $dataSetting['provinsi'],
          'dataprovinsi' => $dataprovinsi
        ];
        $json = [
          'data' => view('admin/rajaongkir/view_dataprovinsi', $data)
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

      $id = $this->request->getVar('id');
      $provinsiid = $this->request->getVar('id_provinsi');

      $ModelSetting = new ModelSetting();
      $dataSetting = $ModelSetting->find($id);

      if (empty($provinsiid) || $provinsiid == "") {
        $provinsiid = $dataSetting['provinsi'];
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
          'distrik' => $dataSetting['distrik'],
          'datadistrik' => $datadistrik
        ];
        $json = [
          'data' => view('admin/rajaongkir/view_datadistrik', $data)
        ];
        echo json_encode($json);
      }
    } else {
      exit("Maaf tidak dapat diperoses");
    }
  }
}
