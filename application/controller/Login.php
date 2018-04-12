<?php
namespace app\controller;

use think\Controller;
use think\Session;

class Login extends Controller{

    public function index(){
        if (Session::get('user_id')){
            return $this->fetch('Index/index');
        }
        $this->assign('err_msg',Session::get('err_msg'));
        return $this->fetch('login');
    }

    public function do_login(){
        //判断是否登录成功
        if (true){
            Session::set('user_id',71);
            Session::set('user_name','admin');
            return $this->fetch('Index/index');
        }else{
            Session::set('err_msg','密码错误');
            $this->redirect('Login/index');
        }
    }


}