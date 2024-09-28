<?php

namespace App\Http\Controllers;

use App\Models\Complaints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ComplaintsController extends Controller
{
    public function create(Request $request):RedirectResponse {
        if(Auth::user()) {
            $validated = $request->validate([
                'description'=>'required|max:255',
                'instruction_id'=>'required'
            ]);

            $data = $request->only(['description', 'instruction_id']);
            $data['uploader_id'] = Auth::user()->id;

            Complaints::create($data);
            return redirect('/');
        } 
        
        return redirect('/register')->withErrors(['message' => 'Чтобы пожаловаться Вы должны быть авторизированны!']);
    }
    public function delete(Request $request) {
        if(Auth::user() && Auth::user()->is_admin) {
            $id = $request->input('id');

            if(isset($id)) {
                Complaints::whereKey($id)->first()->delete();
            }
            return back();
        }
        return redirect('/');
    }
}
