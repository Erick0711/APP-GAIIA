<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GaiaController extends Controller
{
    public function index(){
        return view('gaia.index');
    }
}
