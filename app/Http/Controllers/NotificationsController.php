<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class NotificationsController extends Controller
{
    public function __construct()
    {
        //用户必须登录才能访问
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        // 标记为已读，未读数量清零
        Auth::user()->markAsRead();
        return view('notifications.index',compact('notifications'));
    }
}
