<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function view(Request $request) {
        $categories = Category::get();

        return view('pages/categories', ['categories' => $categories]);
    }

    public function form(Request $request) {
        if(Auth::user()->is_admin) {
            return view('pages/category-form');
        }

        return redirect('/');
    }
    public function create(Request $request):RedirectResponse {
        if(Auth::user()->is_admin) {
            $validated = $request->validate([
                'item_name'=>'required|max:80',
                'google_symbol_name' => 'required'
            ]);

            $data = $request->only(['item_name','google_symbol_name']);

            if($request->id) {
                Category::updateOrcreate(['id' => $request->id],$data);
            } else {
                Category::updateOrcreate($data);
            }

            if(Auth::user()->is_admin) {
                return redirect('/admin-panel/categories');
            } 
        } 
        
        return redirect('/redirect')->withErrors(['message' => 'Что-то пошло не так']);
    }
    public function delete(Request $request) {
        if(Auth::user() && Auth::user()->is_admin) {
            $id = $request->input('id');

            if(isset($id)) {
                Category::whereKey($id)->first()->delete();
            }
            return back();
        }
        return redirect('/');
    }
}
