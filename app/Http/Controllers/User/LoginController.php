<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Model\UserModel;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
    //处理api登录
    public function apiLogin(Request $request){
       // echo 111;
        $user = $request->input('user_name');
        $pass = $request->input('pass');
      
        // echo 'passport<hr>';
        // echo "n: ".$user;echo '<br>';
        // echo "p: ".$pass;echo '<br>';

        //验证用户信息
        $data=UserModel::where('name',$user)->first();
        if($data){
            $result=password_verify($pass,$data['password']);
            if($result){
                //echo "ok";
                $token=Str::random(16);
                $key='str:user:token'.$data['id'];
                Redis::set($key,$token);
                Redis::expire($key,3600);
                $res=[
                    'error'=>0,
                    'status'=>'ok',
                    'uid'=>$data['id'],
                    'token'=>$token
                ];
                return $res;
            }else{
                echo "账号或密码错误";
            }
        }else{
            echo "账号不存在";
       }
      
    }
    public function apiReg(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $mibble = $request->input('mibble');
        $pass = $request->input('pass');
        $passs = $request->input('passs');
        
        // echo 'passport<hr>';
        // echo "n: ".$name;echo '<br>';
        // echo "e: ".$email;echo '<br>';
        // echo "m: ".$mibble;echo '<br>';
        // echo "p: ".$pass;echo '<br>';
        $post['pass']=password_hash($post['pass'],PASSWORD_BCRYPT);
        unset($post['passs']);
        $res=ShopModel::create(['name'=>$name])->orWhere(['email'=>$email])->orWhere(['mibble'=>$account]);
        if($res){
            $data=[
                'name'=>$post['name'],
                'url' =>"注册成功"
            ];
            // return $res;
        }
    }
}
