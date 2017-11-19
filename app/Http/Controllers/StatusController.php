<?php

namespace App\Http\Controllers;

use App\Services\ClickService;

class StatusController
{
    private $clickService;

    public function __construct(ClickService $clickService)
    {
        $this->clickService = $clickService;
    }

    public function index($action, $id)
    {
        if($action == 'success') {
            return $this->success($id);
        } else {
            return $this->error();
        }
    }

    private function success($id)
    {
        $click = $this->clickService->findById($id);

        return view('status.success', compact('click'));
    }

    private function error()
    {
        $message = 'Переданые данные уже находятся в базе данных!!!';

        $isRedirect = session('isRedirect');
        if($isRedirect) {
            return response()
                ->view('status.error', compact('message'))
                ->header('refresh', '5;url=http://google.com');
        }

        return view('status.error', compact('message'));
    }
}