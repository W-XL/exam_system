<?php
namespace app\controller;

use think\Controller;
use think\Session;
use think\Loader;

class Index extends Controller{

    public function _initialize(){
        if (!check_login_common()){
            $this->redirect('Login/index');
        }
    }

    public function index(){
        $this->assign('menu_list',Session::get('menu_list'));
        return $this->fetch();
    }

}