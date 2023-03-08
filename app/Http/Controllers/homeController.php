<?php

namespace App\Http\Controllers;


use Auth;


class homeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            abort(404);
        }

        $notifications = auth()->user()->unreadNotifications;
        $view = '';

        switch (Auth::user()->role) {
            case 'admin':
                $view = 'dashboard.welcome';
                break;
            case 'sales':
                $view = 'sales.welcome';
                break;
            case 'noc':
                $view = 'noc.welcome';
                break;
            case 'finance':
                $view = 'finance.welcome';
                break;
            case 'support':
                $view = 'support.welcome';
                break;
        }

        return view($view, compact('notifications'));
    }
}
