<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return Inertia::render('Backend/Dashboard');
    }
    public function indexSystem(){
        return Inertia::render('Backend/Sys/Dashboard');
    }
}
