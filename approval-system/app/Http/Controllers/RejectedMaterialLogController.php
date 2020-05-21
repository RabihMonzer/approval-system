<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class RejectedMaterialLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        return view('rejectedMaterialLogs.index', ['rejectedMaterialsLog' => $user->getRejectedMaterialsLog()]);
    }
}
