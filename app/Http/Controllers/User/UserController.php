<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $devices = User::findOrFail(Auth::user()->id)->device()->paginate(10);
        return view('user.user.index',[
            'devices' => $devices
        ]);
    }
}
