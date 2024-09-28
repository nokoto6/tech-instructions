<?php

namespace App\Http\Controllers;

use App\Models\Instructions;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

//use Rahul900day\Captcha\Facades\Captcha;
//use Rahul900day\Captcha\Rules\Captcha as CaptchaRule;
//use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function register(Request $request) {
        if(Auth::user()) {
            return redirect('/');
        };
        return view('pages/register');
    }

    public function create(Request $request) {
        if(Auth::user() && Auth::user()->is_admin) {
            return view('pages/user-create');
        }
        return redirect('/');
    }

    public function login(Request $request) {
        if(Auth::user()) {
            return redirect('/');
        };
        return view('pages/login');
    }

    public function registerCreate(Request $request):RedirectResponse {
        $validated = $request->validate([
            'name'=>'required|max:40',
            'email'=>'required|max:255',
            'password'=>'required|max:255'//,
            //Captcha::getResponseName()=>['required', new CaptchaRule(),]  // каптча просит SSL сертификат, поэтому пока убираю из валидатора
        ]);

        if(LoginController::isCaptchaEmpty($request) && !$request->input('noAuth')) { 
            return redirect('register')->withErrors(['message' => 'Пройдите капчу!']); 
        }; // ^ простая проверка капчи без валидатора, имхо для нормальной валидации каптча просит SSL сертификат

        if(!User::where(['email' => $request->email])->exists()) {
            $data = $request->only(['name','email','password']);

            if(User::get()->count() == 0) {
                $data['is_admin'] = true;
            }
            
            if(Auth::user() && Auth::user()->is_admin) {
                if($request->is_admin) {
                    $data['is_admin'] = true;
                }
            }

            User::create($data); // создаю таблицу с пользователем

            if(!$request->input('noAuth')) {
                Auth::attempt($request->only(['email', 'password'])); // пробую сразу залогинится
            } else {
                return redirect('admin-panel/users');
            }
            return back();
        };

        return back()->withErrors(['message' => 'Такой email уже зарегистрирован!']);  
    }

    public function authentication(Request $request) {
        $validated = $request->validate([
            'email'=>'required|max:255',
            'password'=>'required|max:255'//,
            //Captcha::getResponseName()=>['required', new CaptchaRule(),] // каптча просит SSL сертификат, отключаем
        ]);

        if(LoginController::isCaptchaEmpty($request)) { 
            return redirect('login')->withErrors(['message' => 'Пройдите капчу!']); 
        }; // ^ проверка капчи, без валидатора, имхо для нормальной валидации каптча просит SSL сертификат

        if(User::where(['email' => $request->input('email')])->get()->isEmpty()) { // ищем есть ли такие Имейлы
            return redirect('login')->withErrors(['message' => 'Пользователя с таким E-Mail не существует']); 
        }

        if(User::where(['email' => $request->input('email')])->get()->first()->blocked) {
            return redirect('login')->withErrors(['message' => 'Вы были заблокированны администрацией!']); 
        }

        $attemp = Auth::attempt($request->only(['email', 'password'])); // логинюсь

        if(!$attemp) {
            return redirect('login')->withErrors(['message' => 'Неверные данные!']); 
            // если не нашло юзера
        };

        return redirect('/');
    }

    public function logout(Request $request) {
        Auth::logout();

        return redirect('/');
    }

    public function isCaptchaEmpty($request) { // простенькая функция для проверка капчи без валидатора
        if(empty($request['g-recaptcha-response'])) { // проверяю пустое ли поле ответа капчи (пусто в случае не прохождения капчи)
            return true; 
        }
        return false;
    }
    public function delete(Request $request) {
        if(Auth::user() && Auth::user()->is_admin) {
            $id = $request->input('id');

            if(isset($id)) {
                $user = User::whereKey($id)->first();
                
                if($user->is_admin) { return back(); } // админов блочить не надо c:

                $user_instructions = Instructions::where('uploader_id', $id)->get();

                foreach ($user_instructions as $key => $instruction) {
                    $instruction->update(['uploader_id' => 1]);
                }

                $user->delete();
                DB::table('sessions')->where('user_id', $id)->delete(); // вырубаем сессии
            }
            return back();
        }
        return redirect('/');
    }

    public function block(Request $request) {
        if(Auth::user() && Auth::user()->is_admin) {
            $id = $request->input('id');

            if(isset($id)) {
                $block = $request->input('block');

                $user = User::whereKey($id)->first();

                if($user->is_admin) { return back(); } // админов блочить не надо c:

                $user->update(['blocked' => $block]);

                if($block) {
                    DB::table('sessions')->where('user_id', $id)->delete(); // вырубаем сессии
                }
            }
            return back();
        }
        return redirect('/');
    }
}
