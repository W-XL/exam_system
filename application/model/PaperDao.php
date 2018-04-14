<?php
namespace app\model;

use think\Model;
use think\Db;

class PaperDao extends Model{

    public function get_paper_info($id){
        return Db::table('tb_papers')->where('is_del = 0')->where('id='.$id)->find();
    }

    public function get_paper_list(){
        return Db::table('tb_papers')
            ->where('is_del=0')
            ->select();
    }

    public function insert_paper($params){
        $data = ['paper_name'=>$params['paper_name'],'paper_ids'=>$params['paper_ids'],'paper_addtime'=>time(),'exam_time'=>$params['exam_time']];
        Db::name('tb_papers')
            ->data($data)
            ->insert();
    }

    public function update_paper($params){
        Db::table('tb_papers')
            ->where('id',$params['id'])
            ->update(['paper_name'=>$params['paper_name'],'paper_ids'=>$params['paper_ids'],'exam_time'=>$params['exam_time'],'paper_modifytime'=>time()]);
    }

    public function delete_paper($id){
        Db::table('tb_papers')
            ->where('id',$id)
            ->update(['is_del'=>1]);
    }

    public function get_question_type_list(){
        return Db::table('tb_question_type')->select();
    }

    public function insert_q_type($params){
        $data = ['q_type_name'=>$params['q_type_name'],'q_type_dis'=>$params['q_type_dis'],'q_type_rule'=>$params['q_type_rule'],'q_type_addtime'=>time()];
        Db::table('tb_question_type')
            ->data($data)
            ->insert();
    }

 }