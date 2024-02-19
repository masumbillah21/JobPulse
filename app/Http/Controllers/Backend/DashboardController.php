<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        return Inertia::render('Backend/Dashboard');
    }
    public function indexSystem(){
        return Inertia::render('Backend/Sys/Dashboard');
    }
}
