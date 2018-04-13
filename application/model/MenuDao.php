<?php
namespace app\model;

use think\Model;
use think\Db;

class MenuDao extends Model{

    public function get_cate_menu($pid){
        return Db::table('tb_menues')->where('status = 0')->where('pid='.$pid)->select();
    }


 }