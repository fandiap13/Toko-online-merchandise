<?php

namespace App\Controllers;

use App\Models\ModelAdmin;
use App\Models\ModelPembeli;

class Login extends BaseController
{
  private $foofleClient = NULL;
  public function __construct()
  {
    session();
    require_once APPPATH . "libraries/vendor/autoload.php";
    $this->googleClient = new \Google_Client();
    $this->googleClient->setClientId("422074532634-nj0gvca3plqjhbqg80d7ipp7u1h9be4n.apps.googleusercontent.com");
    $this->googleClient->setClientSecret("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");
    $this->googleClient->setRedirectUri("http://localhost:8080/login");
    $this->googleClient->addScope("email");
    $this->googleClient->addScope("profile");
    // $this->googleClient->addScope("address");
  }

  public function index()
  {
    // Nangkep Kode di URL
    $code = isset($_GET['code']) ? $_GET['code'] : NULL;
    if ($code == '') {
      $data = [
        'title' => 'Login',
        'googleButton' => $this->googleClient->createAuthUrl(),
      ];
      return view('login', $data);
    } else {
      $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
      // dd($token);
      if (!isset($token['error'])) {
        $this->googleClient->setAccessToken($token['access_token']);
        session()->set('AccessToken', $token['access_token']);

        $googleService = new \Google_Service_Oauth2($this->googleClient);
        $data = $googleService->userinfo->get();
        // dd($data);
        // dd($data['modelData']['verified_email']);
        $email = $data['email'];

        $modelpembeli = new ModelPembeli();
        $modeladmin = new ModelAdmin();
        $cek_email_pembeli = $modelpembeli->where('emailpembeli', $email)->get()->getRowArray();
        $cek_email_admin = $modeladmin->where('emailadmin', $email)->get()->getRowArray();

        if ($cek_email_admin) {
          $update = [
            'emailadmin' => $data['email'],
            'namaadmin' => $data['givenName'] . " " . $data['familyName'],
            'level' => 'Admin'
          ];
          $modeladmin->update($cek_email_admin['adminid'], $update);

          $currentDateTime = date("Y-m-d H:i:s");
          $userdata = [
            'userid' => $cek_email_admin['adminid'],
            'name' => $data['givenName'] . " " . $data['familyName'],
            'email' => $data['email'],
            'profile_img' => $data['picture'],
            'updated_at' => $currentDateTime,
            'level' => 'Admin'
          ];
          session()->set("LoggedUserData", $userdata);
          session()->setFlashData("msg", 'success#Selamat datang, ' . $data['name']);
          return redirect()->to(site_url('/admin/dashboard'));
        } elseif ($cek_email_pembeli) {
          $update = [
            'emailpembeli' => $data['email'],
            'namapembeli' => $data['givenName'] . " " . $data['familyName'],
            'level' => 'Pembeli'
          ];
          $modelpembeli->update($cek_email_pembeli['pembeliid'], $update);

          $currentDateTime = date("Y-m-d H:i:s");
          $userdata = [
            'userid' => $cek_email_pembeli['pembeliid'],
            'name' => $data['givenName'] . " " . $data['familyName'],
            'email' => $data['email'],
            'profile_img' => $data['picture'],
            'updated_at' => $currentDateTime,
            'level' => 'Pembeli'
          ];
          session()->set("LoggedUserData", $userdata);
          session()->setFlashData("msg", 'success#Selamat datang, ' . $data['name']);
          return redirect()->to(site_url('/'));
        } else {
          $modelpembeli->insert([
            'emailpembeli' => $data['email'],
            'namapembeli' => $data['givenName'] . " " . $data['familyName'],
            'level' => 'Pembeli'
          ]);

          $currentDateTime = date("Y-m-d H:i:s");
          //set Session Google
          $userdata = [
            'name' => $data['givenName'] . " " . $data['familyName'],
            'email' => $data['email'],
            'profile_img' => $data['picture'],
            'updated_at' => $currentDateTime,
            'level' => 'Pembeli'
          ];
          session()->set("LoggedUserData", $userdata);
          session()->setFlashData("msg", 'success#Selamat datang, ' . $data['email'] . ' . Anda kini dapat mendaftar event memakai akun ini.');
          return redirect()->to(site_url('/'));
        }
      } else {
        session()->setFlashData("msg", 'error#Ada kesalahan sistem');
        return redirect()->to(site_url('/login'));
      }
    }
  }

  public function keluar()
  {
    session()->remove('LoggedUserData');
    session()->remove('AccessToken');

    session()->setFlashData("msg", 'error#Anda Berhasil Keluar');
    return redirect()->to(base_url('/login'));
  }
}
