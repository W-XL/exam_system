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

    public function GetInfo($user_id){
        return Db::table('admins')->where('id = ' . $user_id)->find();
    }

    public function get_roles_info($user_id){
        return  Db::table('tb_user_role_access')
            ->alias('a')
            ->join(['tb_roles'=>'r'],'a.role_id=r.id','left')
            ->where('a.user_id="'.$user_id.'"')
            ->field('a.user_id,r.*')
            ->find();
    }

    public function get_module_list(){
        return Db::table('tb_menues')->where('status = 0')->select();
    }

    public function get_menu_list($pid){
        return Db::table('tb_menues')->where('status = 0')->where('pid='.$pid)->select();
    }


 }