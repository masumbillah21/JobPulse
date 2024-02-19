<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Blog;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class BlogPageController extends Controller
{
    public function index()
    {
        
        return Inertia::render('Frontend/Blog/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'blogsList' => Blog::with('user')->where('status', 1)->paginate(9),
        ]);
    }

    public function postDetails(string $slug)
    {
        $blog = Blog::with('user')->where('slug', $slug)->first();
        $postList = Blog::with('user')->where('status', 1)->select('title', 'slug')->take(5)->get();
        if (!$blog || $postList->count() == 0) {
            return abort(404);
        }
        
        return Inertia::render('Frontend/Blog/Show', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'post' => $blog,
            'recentPosts' => $postList,
        ]);
    }
}
