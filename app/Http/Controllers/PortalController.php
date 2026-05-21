<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $pendaftar = $user->pendaftar;

        return view('portal', [
            'user' => $user,
            'pendaftar' => $pendaftar,
        ]);
    }
}
