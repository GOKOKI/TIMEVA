<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function watches(){
        return view('products.watches');
    }
    public function glasses(){
        return view('products.glasses');
    }

        public function glassesshow()
    {
        return view('products.glassesshow');
    }
    
    public function watchesshow()
    {
        return view('products.watchesshow');
    }
}
