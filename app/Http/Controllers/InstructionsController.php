<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Instructions;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class InstructionsController extends Controller {
    public function results(Request $request) {
        if(!Instructions::count()) { return view('pages.results'); }

        $max_items = 21;

        $search = $request->search;

        $query = DB::table('instructions')->where(['accepted' => true]);
        
        switch (true) {
            case isset($request->category);
                $query->where('category_id', $request->category);
            case isset($search);
                $query->where('item_name', 'LIKE', '%'. $search .'%');
        }

        $result = $query->orderBy('id', 'desc')->paginate($max_items,['*'],'page',$request->page);

        return view('pages.results', ['instructions' => $result]);
    }
    public function form(Request $request) {
        if(Auth::user()) {
            return view('pages/instruction-form');
        }

        return redirect('/login')->withErrors(['message' => 'Для добавления собственных инструкций вы должны быть авторизированны']);
    }
    public function create(Request $request):RedirectResponse {
        if(Auth::user()) {
            $validated = $request->validate([
                'item_name'=>'required|max:40',
                'description'=>'max:255',
                'file' => 'required|mimes:pdf|max:10000',
                'category_id' => 'required'
            ]);

            if(Category::whereKey($request->category_id)->get()->isEmpty()) {
                return redirect('/');
            }

            $data = $request->only(['item_name','category_id','description']);

            $file = $request->file('file');
            $disk = Storage::disk('public_uploads');
    
            $fileUrl = $disk->put('instructions', $file);

            $data['uploader_id'] = Auth::user()->id;
            $data['accepted'] = !!Auth::user()->is_admin;

            $data['file'] = '/uploads/' . $fileUrl;
            $inst = Instructions::create($data);

            if(Auth::user()->is_admin) {
                return redirect('/redirect')->withErrors(['message' => 'Вы успешно добавили инструкцию!']);
            } else {
                return redirect('/redirect')->withErrors(['message' => 'Инструкция загружена! Она появится в поиске в ближайшее время!']);
            }
        } 
        
        return redirect('/register')->withErrors(['message' => 'Для добавления собственных инструкций Вы должны быть авторизированны!']);
    }

    public function view(Request $request) {
        $id = $request->input('id');
        if(isset($id)) {
            $item = Instructions::whereKey($id)->first();

            if($item) {
                if($item->accepted || Auth::user()->is_admin) {
                    return view('pages/instruction-view')->with('item',$item);
                }
            }
        }
        return redirect('/redirect');
    }
    public function delete(Request $request) {
        if(Auth::user() && Auth::user()->is_admin) {
            $id = $request->input('id');

            if(isset($id)) {
                $item = Instructions::whereKey($id)->first();

                $disk = Storage::disk('public_uploads');
                $fileUrl = str_replace('/uploads/','',$item->file);

                if($disk->exists($fileUrl)) { $disk->delete($fileUrl); } 

                $item->delete();
            }
            return back();
        }
        return redirect('/');
    }
    public function accept(Request $request) {
        if(Auth::user() && Auth::user()->is_admin) {
            $id = $request->input('id');

            if(isset($id)) {
                $item = Instructions::whereKey($id)->first();

                $item->update(['accepted' => true]);
            }
            return back();
        }
        return redirect('/');
    }
}
