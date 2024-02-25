<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Models\AsideMenu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class AsideMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asideMenu = AsideMenu::with('parent')->orderBy('created_at', 'desc')->paginate(10);


        return Inertia::render('Backend/AsideMenu/Index', [
            'asideMenuList' => $asideMenu
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentList = AsideMenu::select('id', 'label')->where('parent_id', null)->get();

        return Inertia::render('Backend/AsideMenu/Edit', [
            'parentMenuList' => $parentList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|unique:aside_menus',
            'route' => 'nullable|unique:aside_menus',
            'icon' => 'required|string|max:50',
            'parent_id' => 'nullable|exists:aside_menus,id',
            'status' => 'required|boolean'
        ]);

        AsideMenu::create($request->all());

        return redirect()->back()->with('success', 'Aside menu created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(AsideMenu $asideMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AsideMenu $asideMenu)
    {
        $parentList = AsideMenu::select('id', 'label')->where('parent_id', null)->get();

        return Inertia::render('Backend/AsideMenu/Edit', [
            'asideMenuData' => $asideMenu,
            'parentMenuList' => $parentList
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AsideMenu $asideMenu)
    {
        $request->validate([
            'label' => 'required|'.Rule::unique('aside_menus')->ignore($asideMenu->id),
            'route' => 'nullable|'.Rule::unique('aside_menus')->ignore($asideMenu->id),
            'icon' => 'required|string|max:50',
            'parent_id' => 'nullable|exists:aside_menus,id',
            'status' => 'required|boolean'
        ]);

        $asideMenu->update($request->all());

        return redirect()->back()->with('success', 'Aside menu updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AsideMenu $asideMenu)
    {
        $asideMenu->delete();

        return redirect()->back()->with('success', 'Aside menu deleted successfully');
    }
}
