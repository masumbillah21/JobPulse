<?php

namespace App\Http\Controllers\Backend;

use App\Models\Page;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{

    public function showHome(): Response
    {
        return Inertia::render('Backend/Pages/Home');
    }
    public function updateOrCreateHome(Request $request)
    {
        //
    }

    public function showAbout()
    {
        return Inertia::render('Backend/Pages/About');
    }
    public function updateOrCreateAbout(Request $request)
    {
        //
    }

    public function showContact()
    {
        return Inertia::render('Backend/Pages/Contact');
    }
    public function updateOrCreateContact(Request $request)
    {
        //
    }

    public function create() {
        return Inertia::render('Backend/Pages/Edit');
    }

}
