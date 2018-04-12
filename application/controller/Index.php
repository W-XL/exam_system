<?php
namespace app\controller;

use think\Controller;
use think\Session;

class Index extends Controller{

    public function index(){
        if (!Session::get('user_id')){
            $this->redirect('Login/index');
        }
        return $this->fetch();
    }

}