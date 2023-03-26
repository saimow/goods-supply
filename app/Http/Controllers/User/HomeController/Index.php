<?php

namespace App\Http\Controllers\User\HomeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function index(){
        return view('user.home');
    }
}
