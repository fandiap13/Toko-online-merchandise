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
    $this->googleClient->setClientId(getenv('API_GOOGLE_CLIENT_ID'));
    $this->googleClient->setClientSecret(getenv("API_GOOGLE_CLIENT_SECRET"));
    $this->googleClient->setRedirectUri(site_url("/loginWithGoogle"));  // Masukkan Redirect Uri anda
    $this->googleClient->addScope("email");
    $this->googleClient->addScope("profile");
    // $this->googleClient->addScope("address");
  }

  public function index()
  {
    $data = [
      'title' => 'Login',
      'googleButton' => $this->googleClient->createAuthUrl(),
    ];
    return view('login', $data);
  }

  public function loginWithGoogle()
  {
    // Nangkep Kode di URL
    $code = isset($_GET['code']) ? $_GET['code'] : NULL;
    if ($code == '') {
      return redirect()->to(site_url('/login'));
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
          $currentDateTime = date("Y-m-d H:i:s");
          $userdata = [
            'userid' => $cek_email_pembeli['pembeliid'],
            'name' => $cek_email_pembeli['namapembeli'],
            'email' => $data['email'],
            'profile_img' => $cek_email_pembeli['profilpembeli'],
            'updated_at' => $currentDateTime,
            'level' => 'Pembeli'
          ];
          session()->set("LoggedUserData", $userdata);
          session()->setFlashData("msg", 'success#Selamat datang, ' . $cek_email_pembeli['namapembeli']);
          return redirect()->to(site_url('/'));
        } else {
          session()->setFlashData("msg", 'error#Email ' . $email . ' belum terdaftar');
          return redirect()->to(site_url('/login'));
        }
      } else {
        session()->setFlashData("msg", 'error#Ada kesalahan sistem');
        return redirect()->to(site_url('/login'));
      }
    }
  }

  public function registrasi()
  {
    return view('view_registrasi', [
      'title' => 'Registrasi',
      'validation' => \Config\Services::validation()
    ]);
  }

  public function ceklogin()
  {
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    $modelpembeli = new ModelPembeli();
    $data = $modelpembeli->where('emailpembeli', $email)->first();
    if (!$data) {
      session()->setFlashData("msg", 'error#Email tidak terdaftar');
      return redirect()->to('/login')->withInput();
    }

    if (!password_verify($password, $data['passwordpembeli'])) {
      session()->setFlashData("msg", 'error#Password salah');
      return redirect()->to('/login')->withInput();
    }

    $currentDateTime = date("Y-m-d H:i:s");
    $userdata = [
      'userid' => $data['pembeliid'],
      'name' => $data['namapembeli'],
      'email' => $email,
      'profile_img' => $data['profilpembeli'],
      'updated_at' => $currentDateTime,
      'level' => 'Pembeli'
    ];
    session()->set("LoggedUserData", $userdata);
    session()->setFlashData("msg", 'success#Selamat datang, ' . $data['namapembeli']);
    return redirect()->to(site_url('/'));
  }

  public function save_register()
  {
    $namalengkap = $this->request->getVar('namalengkap');
    $email = $this->request->getVar('email');
    $password = $this->request->getVar('password');

    $valid = $this->validate([
      'namalengkap' => [
        'label' => 'Nama lengkap',
        'rules' => "required|is_unique[tbl_pembeli.namapembeli]|max_length[150]",
        'errors' => [
          'is_unique' => '{field} ' . $namalengkap . ' sudah digunakan',
          'required' => '{field} tidak boleh kosong',
          'max_length' => '{field} maksimal terdiri dari 150 karakter'
        ],
      ],
      'email' => [
        'label' => 'Email',
        'rules' => "required|valid_email|is_unique[tbl_pembeli.emailpembeli]|is_unique[tbl_admin.emailadmin]|max_length[150]",
        'errors' => [
          'is_unique' => '{field} ' . $email . ' sudah digunakan',
          'valid_email' => '{field} tidak valid',
          'required' => '{field} tidak boleh kosong',
          'max_length' => '{field} maksimal terdiri dari 150 karakter'
        ]
      ],
      'password' => [
        'label' => 'Password',
        'rules' => 'required|max_length[150]',
        'errors' => [
          'required' => '{field} tidak boleh kosong',
          'max_length' => '{field} maksimal terdiri dari 150 karakter'
        ]
      ],
      'retype_password' => [
        'label' => 'Retype password',
        'rules' => 'required|max_length[150]|matches[password]',
        'errors' => [
          'required' => '{field} tidak boleh kosong',
          'max_length' => '{field} maksimal terdiri dari 150 karakter',
          'matches' => '{field} tidak sama'
        ]
      ]
    ]);

    if (!$valid) {
      return redirect()->to('/registrasi')->withInput();
    } else {
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $token = sha1($password);

      helper('kirim_email');
      if (!kirim_email($email, $token)) {
        session()->setFlashData("msg", 'error#Registrasi gagal');
        return redirect()->to('/registrasi')->withInput();
      }

      try {
        $modelpembeli = new ModelPembeli();
        $modelpembeli->insert([
          'namapembeli' => $namalengkap,
          'emailpembeli' => $email,
          'passwordpembeli' => $password_hash,
          'token_daftar' => $token,
          'level' => "Pembeli"
        ]);
        session()->setFlashData("pesan", 'Registrasi berhasil silahkan cek email anda untuk melakukan aktifasi akun');
        return redirect()->to('/registrasi');
      } catch (\Throwable $th) {
        session()->setFlashData("msg", 'error#Registrasi gagal');
        return redirect()->to('/registrasi')->withInput();
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
