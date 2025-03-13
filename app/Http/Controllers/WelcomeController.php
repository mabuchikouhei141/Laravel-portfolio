<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        // もしログインしていればダッシュボード or 自身のポートフォリオにリダイレクト
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // ログインしていない場合はウェルカムページを表示
        return view('welcome'); // resources/views/welcome.blade.php など
    }
}
