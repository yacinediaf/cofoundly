<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;

class StartupLogoController extends Controller
{
    public function destroy(Request $request, Startup $startup)
    {
        $startup->deleteLogo();

        return back(303)->with('success', 'startup logo deleted');
    }
}
