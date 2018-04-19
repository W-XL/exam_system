<?php
namespace app\model;

use think\Model;
use think\Db;

class ExamDao extends Model{

    public function get_papers_rand(){
        return Db::query('SELECT * FROM tb_papers WHERE is_del=0 ORDER BY rand() LIMIT 1');
    }

    public function get_paper_by_id($id){
        return Db::table('tb_papers')
            ->where('id='.$id)
            ->where('is_del=0')
            ->find();
    }

    public function get_question_by_id($id){
        return Db::table('tb_questions')
            ->field('q.*,qt.q_type_rule')
            ->alias('q')
            ->join('tb_question_type qt','q.q_type_id=qt.id','LEFT')
            ->where('q.id='.$id)
            ->where('q.is_del=0')
            ->find();
    }
}