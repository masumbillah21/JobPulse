<?php

namespace App\Http\Controllers\Backend;

use App\Models\Page;
use Inertia\Inertia;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::select('name', 'value')->get();
        $homePages = Page::select('id', DB::raw('title as label'))->where('status', 1)->where('for_nav', 1)->where('page_type', 'home')->orderBy('page_order')->get();
        $blogPages = Page::select('id', DB::raw('title as label'))->where('status', 1)->where('for_nav', 1)->where('page_type', 'blog')->orderBy('page_order')->get();
        $contactPages = Page::select('id', DB::raw('title as label'))->where('status', 1)->where('for_nav', 1)->where('page_type', 'contact')->orderBy('page_order')->get();
        $jobPages = Page::select('id', DB::raw('title as label'))->where('status', 1)->where('for_nav', 1)->where('page_type', 'job')->orderBy('page_order')->get();
        
        return Inertia::render('Backend/Settings', [
            'settingList' => $settings,
            'homePages' => $homePages,
            'blogPages' => $blogPages,
            'contactPages' => $contactPages,
            'jobPages' => $jobPages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'home' => 'required|numeric|exists:pages,id',
            'blog' => 'nullable|numeric|exists:pages,id',
            'contact' => 'nullable|numeric|exists:pages,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:200',
        ]);

        foreach ($request->all() as $key => $value) {
            $setting = Setting::firstOrNew(['name' => $key]);
            if($key == 'logo'){
                if ($request->hasFile('logo')) {
                    $oldLogo = Setting::where('name', 'logo')->first();
                    if($oldLogo){
                        Storage::disk('public')->delete($oldLogo->value);
                    }
                    $setting->value = $request->file('logo')->store('images', 'public');
                }
            }else{
                $setting->value = $value;
            }
            $setting->save();
            
        }

        return redirect()->back()->with('success', 'Setting saved successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
