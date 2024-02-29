<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Company;
use App\Models\Job;
use App\Models\Blog;
use App\Models\JobCategory;
use App\Models\Page;
use Inertia\Inertia;
use App\Models\Setting;
use App\Models\Category;
use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FrontEndController extends Controller
{
    
    public function index()
    {
        $homeID = Setting::where('name', 'home')->first();
        $homePageData = Page::where('id', $homeID->value)->first();
        $jobList = Job::whereDate('closing_date', '>=', now())->with('company')->where('status', 1)->get();
        $allActiveJobs = Job::whereDate('closing_date', '>=', now())->with('company')->where('status', 1)->get();
        
        $jobCategories = JobCategory::get(['name', 'slug', 'logo']);
        $companies = Company::where('status', 1)->get(['name', 'slug', 'logo']);

        return Inertia::render('Frontend/Home', [
            'storageUrl' => config('app.url') . Storage::url('public/'),
            'homePageData' => $homePageData,
            'jobList' => $jobList,
            'allActiveJobs' => $allActiveJobs,
            'jobCategories' => $jobCategories,
            'companies' => $companies
        ]);
    }

    public function jobPage(){

        
        $jobId = Setting::where('name', 'job')->first();

        if ($jobId != null) {
            $jobPageData = Page::where('id', $jobId->value)->first();
        }else{
            $jobPageData = null;
        }
       
        $jobList = Job::whereDate('closing_date', '>=', now())->with('company')->where('status', 1)->paginate(10);
        $allActiveJobs = Job::whereDate('closing_date', '>=', now())->with('company')->where('status', 1)->get();
        
        return Inertia::render('Frontend/Job/Index', [
            'storageUrl' => config('app.url') . Storage::url('public/'),
            'jobPageData' => $jobPageData,
            'jobList' => $jobList,
            'allActiveJobs' => $allActiveJobs
        ]);
    }
    public function jobDetails(string $slug){

        $jobDetail = Job::whereDate('closing_date', '>=', now())->where('slug', $slug)->with('company', 'user')->where('status', 1)->first();
        
        if (!$jobDetail) {
            return abort(404);
        }

        return Inertia::render('Frontend/Job/Show', [
            'jobDetail' => $jobDetail,
        ]);
    }

    public function blogPage()
    {
        $blogId = Setting::where('name', 'blog')->first();

        if ($blogId != null) {
            $blogPageData = Page::where('id', $blogId->value)->first();
        }else{
            $blogPageData = null;
        }

        $postList = Blog::with('user')->where('status', 1)->paginate(9);
        
        return Inertia::render('Frontend/Blog/Index', [
            'blogsList' => $postList,
            'blogPageData' => $blogPageData,
            'storageUrl' => config('app.url') . Storage::url('public/'),
        ]);
    }

    public function postDetails(string $slug)
    {
        $blog = Blog::with('user')->where('slug', $slug)->first();
        $postList = Blog::with('user')->where('status', 1)->select('title', 'slug')->take(5)->get();
        
        $postCategories = Category::withCount('blogs')->get(['name', 'slug']); 

        if (!$blog) {
            return abort(404);
        }
        
        return Inertia::render('Frontend/Blog/Show', [
            'post' => $blog,
            'recentPosts' => $postList,
            'postCategories' => $postCategories,
            'storageUrl' => config('app.url') . Storage::url('public/'),
        ]);
    }

    public function postCategory(string $slug)
    {
        $postCategory = Category::where('slug', $slug)->first();
        
        if(!$postCategory){
            return abort(404);
        }

        $postList = $postCategory->blogs()->paginate(9);
        

        return Inertia::render('Frontend/Blog/Category', [
            'postList' => $postList,
            'postCategory' => $postCategory,
            'storageUrl' => config('app.url') . Storage::url('public/'),
        ]);
    }

    public function contactPage(){
        $contactId = Setting::where('name', 'contact')->first();

        if ($contactId != null) {
            $contactPageData = Page::where('id', $contactId->value)->first();
        }else{
            $contactPageData = null;
        }

        return Inertia::render('Frontend/Contact', [
            'contactPageData' => $contactPageData,
            'storageUrl' => config('app.url') . Storage::url('public/'),
        ]);
    }

    public function contactPageEmail(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|lowercase',
            'message' => 'required|string',
        ]);
        
        Mail::to(config('mail.from.address'))->send(new ContactEmail($request->name, $request->email, $request->message, $request->subject));

        return redirect()->back()->with('success', 'Email sent successfully');
    }

    public function generalPages(string $slug){

        $pageData = Page::where(['slug' => $slug, 'status' => 1])->first();
        if(!$pageData){
            return abort(404);
        }
        return Inertia::render('Frontend/Page', [
            'pageData' => $pageData,
            'storageUrl' => config('app.url') . Storage::url('public/'),
        ]);
    }
}
