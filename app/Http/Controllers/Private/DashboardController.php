<?php

// app/Http/Controllers/Private/DashboardController.php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('private.dashboard');
    }
}
