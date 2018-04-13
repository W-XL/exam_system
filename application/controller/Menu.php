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
        return view('index');
    }

    public function add_view(){
        $pid = input()['id'];
        if(!$pid){
            $pmenu = array("id"=>0,"name"=>"顶级菜单");
        }else{
            $menu_dao = Loader::model('MenuDao');
            $pmenu = $menu_dao->get_menu($pid);
        }
        $this->assign("pmenu", $pmenu);
        return view('menu_add');
    }

    public function do_add(){
        if(!isset($_POST['pid']) || !$_POST['name'] || !isset($_POST['status'])){
            $this->error_msg("缺少必填项");
        }
        $menu_dao = Loader::model('MenuDao');
        $menu_dao->insert_menu($_POST);
        $this->succeed_msg();
    }

    public function edit_view(){
        $id = input()['id'];
        $menu_dao = Loader::model('MenuDao');
        $info = $menu_dao->get_menu($id);
        if($info['pid']==0){
            $info['pp_id'] = 0;
        }
        $parents = $menu_dao->get_cate_menu($info['pp_id']);
        if($info['pid']==0){
            $parents[] = array("id"=>0, "name"=>"=顶级菜单=");
        }
        $this->assign("info", $info);
        $this->assign("parents", $parents);
        return view("menu_edit");
    }

    public function do_edit(){
        if(!isset($_POST['pid']) || !$_POST['name'] || !isset($_POST['status'])){
            $this->error_msg("缺少必填项");
        }
        $menu_dao = Loader::model('MenuDao');
        $menu_dao->update_menu($_POST);
        $this->succeed_msg();
    }

}