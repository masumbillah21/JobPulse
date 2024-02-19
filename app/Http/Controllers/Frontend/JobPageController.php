<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Job;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class JobPageController extends Controller
{
    public function index()
    {
        $jobList = Job::whereDate('closing_date', '>=', now())->with('company')->where('status', 1)->paginate(2);

        return Inertia::render('Frontend/Job/Index',[
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'jobList' => $jobList
        ]);
    }

    public function jobDetails(string $id){

        $jobDetail = Job::whereDate('closing_date', '>=', now())->where('id', $id)->with('company', 'user')->where('status', 1)->first();
        
        return Inertia::render('Frontend/Job/Show', [
            'jobDetail' => $jobDetail,
        ]);
    }
}
