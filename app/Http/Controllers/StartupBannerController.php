<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;

class StartupBannerController extends Controller
{
    public function destroy(Request $request, Startup $startup)
    {
        $startup->deleteBanner();

        return back(303)->with('success', 'startup banner deleted');
    }
}
