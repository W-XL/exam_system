<?php
namespace app\controller;

use think\Controller;
use think\Request;
use think\Loader;

class Account extends Controller{

    public function _initialize(){
        if (!check_login_common()){
            $this->redirect('Login/index');
        }
    }

    public function index(){
        $params = Request::instance()->param('user_name');
        $account_dao = Loader::model('AccountDao');
        $account_list = $account_dao->get_user_list($params);
        $this->assign("params", $params);
        $this->assign("list", $account_list);
        $this->assign("pages",$account_list->render());
        return view('index');
    }

    public function modify_pwd(){
        $id = Request::instance()->param('id');
        if (!$id){
            return '用户id不存在';
        }
        $this->assign('id',$id);
        return view('pwd_modify');
    }

    public function do_modify_pwd(){
        $parmas = Request::instance()->param();
        if (!$parmas['id']){
            return error_msg('用户id不存在');
        }
        if (!$parmas['password'] || !$parmas['re_pwd']){
            return error_msg('缺少必填项');
        }
        if ($parmas['password'] != $parmas['re_pwd']){
            return error_msg('两次密码不一致');
        }
        $account_dao = Loader::model('AccountDao');
        $account_dao->update_user_pwd($parmas['id'],md5($parmas['password']));
        return succeed_msg();
    }

    public function edit_view(){
        $id = Request::instance()->param('id');
        if (!$id){
            return '用户id不存在';
        }
        $account_dao = Loader::model('AccountDao');
        $user_info = $account_dao->get_user_by_id($id);
        $role_list = $account_dao->get_role_list();
        $this->assign('info',$user_info);
        $this->assign('role_list',$role_list);
        return view('edit');
    }

    public function do_edit(){
        $parmas = Request::instance()->param();
        if (!$parmas['role_id'] || !$parmas['account'] || !$parmas['user_name'] || !$parmas['id']){
            return error_msg('缺少必填项');
        }
        $account_dao = Loader::model('AccountDao');
        $user_check = $account_dao->get_user_edit($parmas);
        if ($user_check){
            return error_msg('用户账号已经被使用');
        }
        $account_dao->update_user_info($parmas);
        $account_dao->update_role_user($parmas);
        return succeed_msg();
    }

    public function add_view(){
        $account_dao = Loader::model('AccountDao');
        $role_list = $account_dao->get_role_list();
        $this->assign('role_list',$role_list);
        return view('add');
    }

    public function do_add(){
        $parmas = Request::instance()->param();
        if (!$parmas['role_id'] || !$parmas['account'] || !$parmas['usr_pwd'] || !$parmas['user_name']){
            return error_msg('缺少必填项');
        }
        $login_dao = Loader::model('LoginDao');
        $user_check = $login_dao->GetAdmins($parmas['account']);
        if ($user_check){
            return error_msg('用户账号已经被使用');
        }
        $account_dao = Loader::model('AccountDao');
        $account_dao->insert_user($parmas);
        return succeed_msg();
    }



}