<?php

namespace App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }
}
