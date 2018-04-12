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
        $menuDao = Loader::model('LoginDao');
        $menu_list = $menuDao->GetAdminMenus();
        $this->assign('menu_list',$menu_list);
        return $this->fetch();
    }

}