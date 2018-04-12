<?php
namespace app\model;

use think\Model;
use think\Db;

class LoginDao extends Model{

    public function GetAdminMenus(){
        return   Db::table('tb_menues')->select();
    }

    public function GetAdmins($account){
        return Db::table('tb_users')
            ->where('account="' . $account . '"')
            ->find();
    }

    public function do_login_log($account, $password, $desc, $ip, $user_id = ''){
        $data = ['usr_id' => $user_id, 'usr_name' => $account, 'desc' => $desc, 'time' => date('Y-m-d H:i:s'), 'ip' => $ip, 'pwd' => $password];
        Db::table('admin_login_log')->data($data)->insert();
    }

    public function GetInfo($user_id){
        return Db::table('admins')->where('id = ' . $user_id)->find();
    }

 }