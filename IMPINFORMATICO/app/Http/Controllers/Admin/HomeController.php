<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('modseguridad.Login');
    }
}
