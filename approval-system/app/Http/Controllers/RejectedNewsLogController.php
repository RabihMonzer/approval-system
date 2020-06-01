<?php

namespace App\Http\Controllers;

use App\RejectedNewsLog;
use Illuminate\Http\Request;

class RejectedNewsLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        return view('rejectedNewsLogs.index', ['rejectedNewsLogs' => $user->getRejectedNewsLogs()]);
    }
}
