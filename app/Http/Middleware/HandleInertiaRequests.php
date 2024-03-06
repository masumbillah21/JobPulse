<?php

namespace App\Http\Middleware;

use App\Models\Page;
use App\Models\Company;
use App\Models\Feature;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        $permissions = $this->getUserPermissions($request);
        $allActiveFeatures = $this->allActiveFeatures($request);

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'role' => $request->user() ? $request->user()->roles()->first() : null,
                'permissions' => $request->user() ? $permissions : [],
                'features' => $request->user() ? $allActiveFeatures : [],
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'urls' => [
                'storeUrl' => config('app.url') . '/storage',
            ],
            'session' => [
                'success' => session('success'),
            ],
            'info' => [
                'message' => session('message'),
            ],
            'publicPages' => $this->getPublicPageList(),
        ];
    }

    private function getUserPermissions(Request $request)
    {
        
        if (!$request->user()) {
            return [];
        }
        
        $user = $request->user();

        if ($user->roles() == null) {
            return [];
        }

        $roles = $user->roles()->with('permissions')->get();

        $permissions = $roles->flatMap(function ($role) {
            return $role->permissions;
        });

        $uniquePermissions = $permissions->unique('id');

        return $uniquePermissions;
    }

    private function getPublicPageList()
    {
        $pages = Page::select('title', 'slug', 'page_order')
                ->where(['for_nav' => 1, 'status' => 1, 'page_type' => 'general'])
                ->orderBy('page_order', 'asc')
                ->get();

        return $pages ?? [];
    }

    private function allActiveFeatures(Request $request)
    {
        if (!$request->user()) {
            return [];
        }

        if(!$request->user()->company_id) {
            return [];
        }

        $company = Company::find($request->user()->company_id);

        $features = $company->features()
        ->where('company_id', $request->user()->company_id)
        ->pluck('features.id') ?? [];

        return $features ?? [];
    }
}
