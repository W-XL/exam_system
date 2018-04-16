<?php
namespace app\model;

use think\Model;
use think\Db;

class AccountDao extends Model{

        public function get_user_list($params){
            if ($params){
                return Db::table('tb_users')
                    ->field('u.*,r.rules,r.name,ur.role_id')
                    ->alias('u')
                    ->join('tb_user_role_access ur','ur.user_id = u.id')
                    ->join('tb_roles r','ur.role_id = r.id')
                    ->where('u.account','eq',$params)
                    ->paginate(10);
            }else{
                return Db::table('tb_users')
                    ->field('u.*,r.rules,r.name,ur.role_id')
                    ->alias('u')
                    ->join('tb_user_role_access ur','ur.user_id = u.id')
                    ->join('tb_roles r','ur.role_id = r.id')
                    ->paginate(10);
            }
        }

        public function get_user_by_id($id){
            return Db::table('tb_users')
                ->field('u.*,r.rules,r.name,ur.role_id')
                ->alias('u')
                ->join('tb_user_role_access ur','ur.user_id = u.id')
                ->join('tb_roles r','ur.role_id = r.id')
                ->where('u.id='.$id)
                ->find();
        }

        public function get_role_list(){
            return Db::table('tb_roles')
                ->select();
        }

        public function get_user_edit($params){
            return Db::table('tb_users')
                ->where('id','neq',$params['id'])
                ->where('account','eq',$params['account'])
                ->find();
        }

        public function update_user_pwd($id,$pwd){
            Db::table('tb_users')
                ->where('id',$id)
                ->update(['pwd'=>$pwd]);

        }

        public function update_user_info($params){
            Db::table('tb_users')
                ->where('id',$params['id'])
                ->update(['account'=>$params['account'],'user_name'=>$params['user_name']]);
        }

        public function update_role_user($params){
            Db::table('tb_user_role_access')
                ->where('user_id',$params['id'])
                ->update(['role_id'=>$params['role_id']]);
        }

        public function insert_user($params){
            $user_id = Db::table('tb_users')
                ->insertGetId(['account'=>$params['account'],'pwd'=>md5($params['usr_pwd']),'user_name'=>$params['user_name']]);
            Db::table('tb_user_role_access')
                ->insert(['user_id'=>$user_id,'role_id'=>$params['role_id']]);
        }
 }