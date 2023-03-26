<?php

namespace App\Http\Controllers\Admin\UserController;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function index(UserDataTable $datatable){
        return $datatable->render('admin.users.index');
    }
}
