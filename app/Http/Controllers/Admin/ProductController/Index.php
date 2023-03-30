<?php

namespace App\Http\Controllers\Admin\ProductController;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function index(ProductDataTable $dataTable){
        return $dataTable->render('admin.products.index');
    }
}
