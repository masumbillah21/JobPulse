<?php

namespace App\Http\Controllers\Backend;

use App\Models\JobCandidate;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $chartInfo = ['data'];
        if(auth()->user()->user_type == UserTypeEnum::CANDIDATE){
            $totaApplied =  JobCandidate::where('user_id', auth()->user()->id)->whereYear('created_at', Carbon::now()->year)->count();
            $totalAppliedData = JobCandidate::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month'), DB::raw('COUNT(*) AS count'))
                                ->whereYear('created_at', Carbon::now()->year)
                                ->groupBy('month')
                                ->orderBy('month')
                                ->pluck('count', 'month')
                                ->toArray();
            $chartInfo['data'][] = $this->chartInfoArray($totalAppliedData);

            $totalSelected = JobCandidate::where('user_id', auth()->user()->id)->whereYear('created_at', Carbon::now()->year)->where('status', 'selected')->count();
            $totalSelectedData = JobCandidate::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month'), DB::raw('COUNT(*) AS count'))
                                ->whereYear('created_at', Carbon::now()->year)
                                ->where('status', 'selected')
                                ->groupBy('month')
                                ->orderBy('month')
                                ->pluck('count', 'month')
                                ->toArray();
            $chartInfo['data'][] = $this->chartInfoArray($totalSelectedData);
            
            $totalRejected = JobCandidate::where('user_id', auth()->user()->id)->whereYear('created_at', Carbon::now()->year)->where('status', 'rejected')->count();
            $totalRejectedData = JobCandidate::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month'), DB::raw('COUNT(*) AS count'))
                                ->whereYear('created_at', Carbon::now()->year)
                                ->where('status', 'rejected')
                                ->groupBy('month')
                                ->orderBy('month')
                                ->pluck('count', 'month')
                                ->toArray();
            $chartInfo['data'][] = $this->chartInfoArray($totalRejectedData);


        }else if(auth()->user()->user_type == UserTypeEnum::COMPANY){
            $totalEmployees = auth()->user()->compnay_id ? auth()->user()->company->employees->count() : 0;
            $totalJobs = auth()->user()->company->jobs->count();

            $jobData = Job::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month'), DB::raw('COUNT(*) AS count'))
                    ->where('company_id', auth()->user()->company_id)        
                    ->groupBy('month')
                    ->orderBy('month')
                    ->pluck('count', 'month')
                    ->toArray();

            $chartInfo['data'][] = $this->chartInfoArray($jobData);

            $totalCandidates = JobCandidate::whereHas('job', function ($query) {
                                    $query->where('company_id', auth()->user()->company_id);
                                })
                                ->count();

            $candidateData  = JobCandidate::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month'), DB::raw('COUNT(*) AS count'))
                            ->whereIn('job_id', Job::where('company_id', auth()->user()->company_id)->pluck('id'))        
                            ->groupBy('month')
                            ->orderBy('month')
                            ->pluck('count', 'month')
                            ->toArray();          

            $chartInfo['data'][] = $this->chartInfoArray($candidateData);       
                                
        }
        return Inertia::render('Backend/Dashboard', [
            'chartInfo' => $chartInfo,
            'totalEmployees' => $totalEmployees ?? 0,
            'totalJobs' => $totalJobs ?? 0,
            'totalCandidates' => $totalCandidates ?? 0,

            'totalApplied' => $totaApplied ?? 0,
            'totalSelected' => $totalSelected ?? 0,
            'totalRejected' => $totalRejected ?? 0.
        ]);
    }
    public function indexSystem(){

        $totalEmployees = auth()->user()->compnay_id ? auth()->user()->company->employees->count() : 0;
        $totalCompanies = Company::where('default', 0)->count();
        $totalJobs = Job::count();
        $totalCandidates = User::where('user_type', UserTypeEnum::CANDIDATE)->count();

        $companyData = Company::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month'), DB::raw('COUNT(*) AS count'))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->toArray();

        $chartInfo['data'][] = $this->chartInfoArray($companyData);

        $jobData = Job::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month'), DB::raw('COUNT(*) AS count'))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->toArray();

        $chartInfo['data'][] = $this->chartInfoArray($jobData);

        $candidateData = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month'), DB::raw('COUNT(*) AS count'))
        ->where('user_type', UserTypeEnum::CANDIDATE)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->toArray();

        $chartInfo['data'][] = $this->chartInfoArray($candidateData);
        
        return Inertia::render('Backend/Sys/Dashboard',[
            'totalEmployees' => $totalEmployees,
            'totalCompanies' => $totalCompanies,
            'totalJobs' => $totalJobs,
            'totalCandidates' => $totalCandidates,
            'chartInfo' => $chartInfo
        ]);
    }

    private function chartInfoArray($data){
        $currentYear = Carbon::now()->year;
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::createFromDate($currentYear, $i, 1)->startOfMonth();
        }

        
        foreach ($months as $month) {
            $monthKey = $month->format('Y-m');
            if (!isset($data[$monthKey])) {
                $data[$monthKey] = 0;
            }
        }

        ksort($data);

        return array_values($data);
        
    }
}
