<?php
namespace app\controller;

use think\Controller;
use think\Session;
use think\Loader;

class Menu extends Controller{

    public function index(){
        $menu_dao = Loader::model('MenuDao');
        $top_list = $menu_dao->get_cate_menu(0);
        foreach ($top_list as $k=>$v){
            $sub_list = $menu_dao->get_cate_menu($v['id']);
            $top_list[$k]['sub_list'] = $sub_list;
            foreach ($sub_list as $kk=>$vv){
                $child_list = $menu_dao->get_cate_menu($vv['id']);
                $top_list[$k]['sub_list'][$kk]['child_list'] = $child_list;
            }
        }
        $this->assign("dataList", $top_list);
        echo $this->fetch('index');
    }

    public function add_view(){
        var_dump($_POST);
    }


}