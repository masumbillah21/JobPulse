<?php

namespace App\Http\Middleware;

use App\Models\AsideMenu;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

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
        $asideMenus = AsideMenu::with(['children' => function ($query) {
            $query->where('status', true);
        }])
        ->whereNull('parent_id')
        ->where('status', true)
        ->get();
        
        $data = $asideMenus->map(function ($menu) {

            $menuItem = [
                'label' => $menu->label,
                'icon' => $menu->icon,
            ];
        
            if ($menu->route) {
                $menuItem['route'] = $menu->route;
            }
        
            if ($menu->children->isNotEmpty()) {
                $menuItem['menu'] = $menu->children->map(function ($child) {
                    if($child->status == 1){
                        return [
                            'route' => $child->route,
                            'icon' => $child->icon,
                            'label' => $child->label,
                        ];
                    }
                });
            }
        
            return $menuItem;
        });

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'asideMenu' => $request->user() ? $data->toArray() : null
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
        ];
    }
}
