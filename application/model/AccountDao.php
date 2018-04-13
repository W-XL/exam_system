<?php
namespace app\model;

use think\Model;
use think\Db;

class AccountDao extends Model{

    public function get_cate_menu($pid){
        return Db::table('tb_menues')->where('status = 0')->where('pid='.$pid)->select();
    }

    public function get_menu($pid){
        return Db::table('tb_menues')
            ->alias('a')
            ->join(['tb_menues'=>'b'],'a.pid=b.id','left')
            ->where('a.id="'.$pid.'"')
            ->field('a.*,b.pid as pp_id')
            ->find();
    }

    public function insert_menu($params){
        $data = ['pid'=>$params['pid'],'name'=>$params['name'],'url'=>$params['url'],'status'=>$params['status']];
        Db::name('tb_menues')
            ->data($data)
            ->insert();
    }

    public function get_account_list(){
        return Db::table('tb_users')->where('is_del = 0')->select();
    }


 }