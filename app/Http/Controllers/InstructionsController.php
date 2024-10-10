<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class InstructionsController extends Controller {
    public function list(Request $request) {
        if(!Instructions::count()) { return view('body'); }

        $max_items = 25;

        $search = $request->search;
        $page = $request->page;

        if(isset($search)) {
            $instructions = Instructions::where('item_name', 'LIKE', '%'. $search .'%')->where(['accepted' => true])
            ->orWhere('description', 'LIKE', '%'. $search .'%')->where(['accepted' => true]);
        } else {
            $instructions = Instructions::where(['accepted' => true]);
        }

        return view('body', ['instructions' => $instructions->paginate($max_items,['*'],'page',$page)]);
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
                'item_name'=>'required|max:30',
                'description'=>'required|max:255',
                "file" => "required|mimes:pdf|max:10000"
            ]);

            $data = $request->only(['item_name','description']);
            $file = $request->file('file');
            $disk = Storage::disk('public_uploads');
    
            $fileUrl = $disk->put('instructions', $file);

            $data['uploader_id'] = Auth::user()->id;
            $data['accepted'] = !!Auth::user()->is_admin;

            $data['file'] = '/uploads/' . $fileUrl;
            $inst = Instructions::create($data);
            return redirect('/');
        } 
        
        return redirect('/register')->withErrors(['message' => 'Для добавления собственных инструкций Вы должны быть авторизированны!']);
    }

    public function view(Request $request) {
        $id = $request->input('id');
        if(isset($id)) {
            $item = Instructions::whereKey($id)->first();

            if($item) {
                return view('pages/instruction-view')->with('item',$item);
            }
        }
        return redirect('/');
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
