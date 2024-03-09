<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Job;
use App\Models\Tag;
use App\Models\Blog;
use App\Models\Page;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Setting;
use App\Models\Category;
use App\Mail\ContactEmail;
use App\Models\JobCategory;
use App\Models\JobCandidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FrontEndController extends Controller
{
    
    public function index()
    {
        $homeID = Setting::where('name', 'home')->firstOrFail();

        if($homeID){
            $homePageData = Page::where('id', $homeID->value)->firstOrFail();
            $jobList = Job::whereDate('closing_date', '>=', now())->with('company')->where('status', 1)->get();
            $allActiveJobs = Job::whereDate('closing_date', '>=', now())->with('company')->where('status', 1)->get();
            
            $jobCategories = JobCategory::get(['name', 'slug', 'logo']);
            $companies = Company::where('status', 1)->whereNot('logo', null)->get(['name', 'slug', 'logo']);    
        }else{
            $homePageData = null;
            $jobList = null;
            $allActiveJobs = null;
            $jobCategories = null;
            $companies = null;
        }
        
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

        if(Auth::check()){
            $isApplied = JobCandidate::where('job_id', $jobDetail->id)->where('user_id', Auth::id())->first() ? true : false;
        }else{
            $isApplied = false;
        }   

        return Inertia::render('Frontend/Job/Show', [
            'jobDetail' => $jobDetail,
            'isApplied' => $isApplied
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
        $blog = Blog::with('user', 'categories', 'tags')->where('slug', $slug)->where('status', 1)->first();

        if (!$blog) {
            return abort(404);
        }

        $postList = Blog::with('user')->where('status', 1)->select('title', 'slug')->take(5)->get();
        
        $postCategories = Category::withCount('blogs')->get(['name', 'slug']); 
        $postTags = Tag::withCount('blog')->get(['name', 'slug']);

        return Inertia::render('Frontend/Blog/Show', [
            'post' => $blog,
            'recentPosts' => $postList,
            'postCategories' => $postCategories,
            'postTags' => $postTags,
        ]);
    }

    public function postCategory(string $slug)
    {
        $postCategory = Category::where('slug', $slug)->first();
        $cateBgImage = Setting::where('name', 'catebg')->first();
        
        if(!$postCategory){
            return abort(404);
        }

        $postList = $postCategory->blogs()->paginate(9);
        

        return Inertia::render('Frontend/Blog/Category', [
            'postList' => $postList,
            'postCategory' => $postCategory,
            'cateBgImage' => $cateBgImage->value ?? null,
        ]);
    }

    public function postTag(string $slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        if(!$tag){
            return abort(404);
        }
        $postList = $tag->blog()->paginate(9);
        
        return Inertia::render('Frontend/Blog/Tag', [
            'postList' => $postList,
            'postTag' => $tag,
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

    public function applyJob(Request $request){

        $job = Job::where('id', $request->id)->where('status', 1)->first();
        if(!$job){
            return abort(404);
        }

        $job->applications()->attach(Auth::id(), ['expected_salary' => $request->expected_salary, 'status' => 'pending']);

        return redirect()->back()->with('success', 'Job applied successfully');
        
    }

    public function jobByCompnay(string $slug){
        $company = Company::where('slug', $slug)->where('status', 1)->first();
        if(!$company){
            return abort(404);
        }
        $jobList = Job::whereDate('closing_date', '>=', now())->with('company')->where(['status' => 1, 'company_id' => $company->id])->paginate(10);
        return Inertia::render('Frontend/Job/Company', [
            'jobsData' => $jobList,
            'companyData' => $company,
            'storageUrl' => config('app.url') . Storage::url('public/'),
        ]);
    }

    public function jobByCategory(string $slug){
        $category = JobCategory::where('slug', $slug)->first();
        if(!$category){
            return abort(404);
        }
        $jobList = Job::whereDate('closing_date', '>=', now())->with('company')->where(['status' => 1, 'job_category_id' => $category->id])->paginate(10);
        return Inertia::render('Frontend/Job/Category', [
            'jobsData' => $jobList,
            'categoryData' => $category
        ]);
    }
}
