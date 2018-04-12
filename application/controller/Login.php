<?php
namespace app\controller;

use think\Controller;
use think\Session;
use think\Loader;

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

    public function do_login2(){
        $params = $_POST;
        if(!$params['account'] || !$params['user_pwd']){
            $this->error("缺少必填项");
        }
        if($this->userPwdCheck($params)){
            $this->redirect('Index/index');
        }else{
            $this->redirect('Login/index');
        }
    }

    //用户帐号密码验证
    public function userPwdCheck($params){
        $account = $params['account'];
        $password = $params['user_pwd'];
        $md5_pwd = md5($password);
        $login_dao = Loader::model('LoginDao');
        $user_info = $login_dao->GetAdmins($account);
        if(strtolower($md5_pwd) != strtolower($user_info['pwd'])){
            if($user_info){
                Session::set('err_msg','密码错误，请重新输入');
                return false;
            }else{
                Session::set('err_msg','用户名不存在，请重新输入');
                return false;
            }
        }else{
            $menu_arr="";
            if($user_info['id']){
                $perm_info = $login_dao->get_roles_info($user_info['id']);
                $menu_arr =explode(',',$perm_info['rules']);
            }
            $m_list = $login_dao ->get_module_list();
            foreach($m_list as $key=>$data){
                if(!in_array($data['id'],$menu_arr)){
                    unset($m_list[$key]);
                    continue;
                }
                $p_menu_list = $login_dao->get_menu_list($data['id']);
                foreach($p_menu_list as $i=>$list){
                    if(!in_array($list['id'],$menu_arr)){
                        unset($p_menu_list[$i]);
                        continue;
                    }
                    $menu_list = $login_dao->get_menu_list($list['id']);
                    foreach($menu_list as $j=>$clist){
                        if(!in_array($clist['id'],$menu_arr)){
                            unset($menu_list[$j]);
                            continue;
                        }
                    }
                    $p_menu_list[$i]['c_menu']=$menu_list;
                }
                $m_list[$key]['p_menu']=$p_menu_list;
            }
            Session::set('menu_list',$m_list);
            Session::set('user_id',$user_info['id']);
            Session::set('group_id',$user_info['group_id']);
            Session::delete('login_error_msg');
            return true;
        }

    }

    public function do_logout(){
        Session::delete('user_id');
        Session::delete('group_id');
        Session::delete('menu_list');
        Session::delete('err_msg');
        $this->redirect('Login/index');
    }


}