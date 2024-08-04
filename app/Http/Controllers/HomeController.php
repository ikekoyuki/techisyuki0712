<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $time = intval(date('H'));

        if (4 <= $time && $time <= 12) {
            // 4時～12時の時間帯の処理
            $greeting = 'おはようございます☀️';
        } elseif (12 <= $time && $time <= 20) {
            // 12時〜20時の時間帯の処理
            $greeting = 'こんにちは☕️';
        } else {
            // それ以外の時間帯の処理
            $greeting = 'こんばんは🌙';
        }

        $types = ['リビング','寝室','キッチン','玄関','クローゼット'];
        $type = $types[rand(0, 4)];

        $messages = ['今日は' . $type . 'のモノを整理してみましょう！','同じ使用用途のモノはないか確認してみましょう！','今日もお疲れさまです！','使わずに長らく放置されているものがないか確認してみましょう！','モノを捨てる場合は、メモに理由を残してみましょう！'];
        $message = $messages[rand(0, 4)];


        return view('home', ['greeting' => $greeting] , ['message' => $message]);
    }
}
