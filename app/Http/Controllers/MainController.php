<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the HomePage
     * Method Get
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (Auth::check()) {
            if ($user && $user->status == 'Admin') {
                return redirect('/admin/devices');
            }
            return redirect('/user/devices');
        }
        return redirect()->guest('/');
    }

}
