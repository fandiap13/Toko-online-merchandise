<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class FilterAdmin implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    // Do something here
    // sebelum login
    if (empty(session()->get('LoggedUserData'))) {
      session()->setFlashData("msg", 'error#Harus login terlebih dahulu');
      return redirect()->to('/login');
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
    if (!empty(session('LoggedUserData')) && session()->get('LoggedUserData')['level'] == 'Admin') {
      return redirect()->to('/admin/dashboard');
    }
  }
}
