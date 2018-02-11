<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionsController extends Controller
{
    //
    //让登录页面和注册页面仅仅让未登入用户访问

    public function  __construct()
    {
      $this->middleware('guest',
      [
        'only'=>['create']
      ]);
    }

    public function destory()
    {
      Auth::logout();
      session()->flash('success','您已经成功退出');
      return redirect('login');
    }
    public function create()
    {
         return view('sessions.create');
    }
    public function store(Request $request)
    {
        $this->validate($request,[
          'email'=>'required|email|max:255',
          'password'=>'required'
        ]);
        $credentials=[
          'email'=>$request->email,
          'password'=>$request->password,
        ];
        if(Auth::attempt($credentials,$request->has('remember'))){
           if(Auth::user()->activated)
           {
            session()->flash('success','欢迎回来！');
            //intended方法可将用户跳转到之前想要访问的页面上
            return redirect()->intended(route('users.show',[Auth::user()]));
          }
          else {
            Auth::logout();
            session()->flash('warning','你的账号未激活，请检查邮箱中的注册邮件进行激活');
            return redirect('/');
          }
        }else {
          session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
          return redirect()->back();
        }
        return ;
    }
}
