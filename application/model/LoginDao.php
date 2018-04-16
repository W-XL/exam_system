<?php
namespace app\model;

use think\Model;
use think\Db;

class LoginDao extends Model{

    public function GetAdmins($account){
        return Db::table('tb_users')
            ->field('u.*,r.rules,ur.role_id')
            ->alias('u')
            ->join('tb_user_role_access ur','ur.user_id = u.id')
            ->join('tb_roles r','ur.role_id = r.id')
            ->where('u.account="' . $account . '"')
            ->find();
    }

    public function get_module_list(){
        return Db::table('tb_menues')->where('status = 0 and pid = 0')->select();
    }

    public function get_menu_list($pid){
        return Db::table('tb_menues')->where('status = 0')->where('pid='.$pid)->select();
    }


 }