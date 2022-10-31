<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Coba extends BaseController
{
    public function index()
    {
        return view('coba', $data = ['title' => 'Coba']);
    }

    public function formcoba()
    {
        require __DIR__ . '/vendor/autoload.php';

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            'c0c6bc437d67831c4c10',
            '101b508135d59e93c783',
            '1464190',
            $options
        );

        $data['message'] = 'hello world';
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}
