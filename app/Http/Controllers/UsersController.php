<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Mail;
use Auth;

class UsersController extends Controller
{
  public function destroy(User $user)
  {
    $this->authorize('destroy',$user);
    $user->delete();
    session()->flash('success','成功删除用户');
    return back();
  }
  //except指定动作不使用auth中间件过滤
    public function __construct()
    {
        $this->middleware('auth',
        [
          'except'=>['show','create','store','index','confirmEmail']
        ]);
        $this->middleware('guest',[
          'only'=>['create']
        ]);
    }
    //展示用户列表
  public function index()
  {
   //paginate实现分页的功能，每页容纳十个用户
    $users=User::paginate(10);
    return view('users.index',compact('users'));
  }
   public function update(User $user ,Request $request)
   {
        $this->validate($request,[
          'name'=>'required|max:50',
          'password'=>'required|confirmed|min:6'
        ]);
        $this->authorize('update',$user);
        $data=[];
        $data['name']=$request->name;
        if($request->password)
        {
          $data['password']=bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','修改信息成功!');
        return redirect()->route('users.show',$user->id);
   }
   //访问/user/$user->id/edit的页面
    public function edit(User $user)
    {
      $this->authorize('update',$user);
      return view('users.edit',compact('user'));
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
        $this->validate($request,[
          'name'=>'required|max:50',
          'email'=>'required|email|unique:users|max:250',
          'password'=>'required|confirmed|min:6'
        ]);
    $user=User::create([
      'name'=>$request->name,
      'email'=>$request->email,
      'password'=>bcrypt($request->password),
    ]);

    /*
    Auth::login($user);
    session()->flash('success','欢迎，您将在这里开启一段新的旅程');
    return redirect()->route('users.show',[$user]);
    */
    $this->sendEmailConfirmation($user);
    session()->flash('success','验证邮件已经发送你的邮箱上');
    return redirect( '/');
  }
  //发送激活邮件
  protected function sendEmailConfirmation($user)
  {
    $view='emails.confirm';
    $data=compact('user');
    $from='aufree@yousails.com';
    $name="Aufree";
    $to=$user->email;
    $subject="感谢注册Sample应用！请确认你的邮箱。";
    Mail::send($view,$data,function($message)use ($from,$name,$to,$subject){
      $message->from($from,$name)->to($to)->subject($subject);
    });
  }
  public function confirmEmail($token)
  {
    $user=User::where('activation_tokon',$token)->firstOrFail();
    $user->activated=true;
    $user->activation_tokon=null;
    $user->save();
    Auth::login($user);
    session()->flash('success','恭喜你激活成功');
    return redirect()->route('users.show',[$user]);
  }
  /*
  *显示用户的微博，按照时间逆序排列，每页30条
  */
  public function show(User $user)
  {
    $statuses=$user->statuses()
                   ->orderBy('created_at','desc')
                   ->paginate(30);
    return view('users.show',compact('user','statuses'));
  }
  public function followings(User $user)
  {
    $users=$user->followings()->paginate(30);
    $title='关注的人';
    return view('users.show_follow',compact('users','title'));
  }
 public function followers(User $user)
 {
       $users=$user->followers()->paginate(30);
       $title='粉丝';
       return view('users.show_follow',compact('users','title'));
 }
}
