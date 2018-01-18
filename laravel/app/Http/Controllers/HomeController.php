<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $req)
    {
        $name = $req->input('name');
        return 'hello world '.$name;
    }
}
