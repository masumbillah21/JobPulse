<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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

}
