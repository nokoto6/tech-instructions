<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function view(Request $request) {
        $categories = Category::get();

        return view('pages/categories', ['categories' => $categories]);
    }
}
