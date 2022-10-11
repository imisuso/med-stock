<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        Logger('IN HandleInertiaRequests');
        $user = Auth::user();
        Logger($user);
        Logger('-------------------------');
        // return array_merge(parent::share($request), [
        //     'auth' => $request->user() ?[
        //         'user' => $request->user(),
        //         'abilities'=> $request->user()->abilities,
        //     ]:null,
        //     'flash' => [
        //         'status' => fn () => $request->session()->pull('status'),
        //         'msg' => fn () => $request->session()->pull('msg'),
        //         'mainMenuLinks' => fn () => $request->session()->pull('mainMenuLinks',[]),
        //         // 'actionMenu' => fn () => $request->session()->pull('action-menu', []),
        //     ],
        // ]);

           return array_merge(parent::share($request), [
            'auth' => $user?[
                'user' => fn () => $request->session()->pull('user'),
                'abilities'=> fn () => $request->session()->pull('abilities'),
            ]:null,
            'flash' => [
                'status' => fn () => $request->session()->pull('status'),
                'msg' => fn () => $request->session()->pull('msg'),
                'mainMenuLinks' => fn () => $request->session()->pull('mainMenuLinks',[]),
                'user'=> fn () => $request->session()->pull('user',[])
                // 'actionMenu' => fn () => $request->session()->pull('action-menu', []),
            ],
        ]);
    }
}
