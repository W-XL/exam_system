<?php
namespace app\controller;

use think\Controller;
use think\Session;
use think\Loader;

class Index extends Controller{

    public function index(){
        if (!Session::get('user_id')){
            $this->redirect('Login/index');
        }
        $this->assign('menu_list',Session::get('menu_list'));
        return $this->fetch();
    }

}