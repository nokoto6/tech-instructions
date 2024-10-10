<?php

namespace App\Http\Controllers;
use App\Models\Complaints;
use App\Models\Instructions;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    public function panel(Request $request) {
        return redirect('/admin-panel/instructions');
    }
    public function instructions(Request $request) {
        if(Auth::user() && Auth::user()->is_admin) {
            $max_items = 20;

            $filter = $request->filter;
            $page = $request->page;

            if(!Instructions::count()) { return view('pages/admin/instructions', ['instructions' => Instructions::paginate($max_items,['*'],'page',$page)]); }

            if(!isset($filter) | $filter == 'all') {
                $instructions = Instructions::get()->toQuery();
            } else {
                if($filter == 'accepted') {
                    $instructions = Instructions::where(['accepted' => true]);
                } else {
                    $instructions = Instructions::where(['accepted' => false]);
                }
            }

            return view('pages/admin/instructions', ['instructions' => $instructions->paginate($max_items,['*'],'page',$page)]);
        }

        return redirect('/');
    }
    public function users(Request $request) {
        if(Auth::user() && Auth::user()->is_admin) {
            $max_items = 20;

            $filter = $request->filter;
            $page = $request->page;

            if($filter == 'blocked') {
                $users = User::where(['blocked' => true]);
            } else {
                $users = User::where(['blocked' => false]);
            }

            return view('pages/admin/users', ['users' => $users->paginate($max_items,['*'],'page',$page)]);
        }

        return redirect('/');
    }
    public function complaints(Request $request) {
        if(Auth::user() && Auth::user()->is_admin) {
            $max_items = 20;
            $page = $request->page;

            if(!Complaints::count()) { return view('pages/admin/complaints', ['complaints' => Complaints::paginate($max_items,['*'],'page',$page)]); }

            $complaints = Complaints::get()->toQuery();

            return view('pages/admin/complaints', ['complaints' => $complaints->paginate($max_items,['*'],'page',$page)]);
        }

        return redirect('/');
    }
}
