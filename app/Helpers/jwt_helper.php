<?php

use App\Models\ModelPembeli;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWT($otentikasiHeader)
{
  if (is_null($otentikasiHeader)) {
    throw new Exception("Otentikasi JWT gagal");
  }
  // var_dump(explode(" ", $otentikasiHeader)[1]);
  return explode(" ", $otentikasiHeader)[1];
}

function validasiJWT($encodeToken)
{
  $key = getenv('JWT_TOKEN');
  $decodeToken = JWT::decode($encodeToken, new Key($key, 'HS256'));
  $modelUser = new ModelPembeli();
  $data = $modelUser->getWhere(['emailpembeli' => $decodeToken->email])->getRowArray();
  if (!$data) {
    throw new Exception("Data otentikasi tidak ditemukan");
  }
  return $data;
}

function createJWT($email)
{
  $waktuRequest = time();
  $waktuToken = getenv('JWT_TIME_TO_LIVE');
  $waktuExpired = $waktuRequest + $waktuToken;
  $payload = [
    'email' => $email,
    'iat' => $waktuRequest,
    'exp' => $waktuExpired
  ];
  $jwt = JWT::encode($payload, getenv('JWT_TOKEN'), 'HS256');
  return $jwt;
}
