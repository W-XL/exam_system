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

    public function insert_exam_record($params){
         return Db::table('tb_paper_record')
            ->insertGetId(['paper_id'=>$params['paper_id'],'do_id'=>$params['do_id']]);
    }

    public function get_exam_record_by_id($id){
        return Db::table('tb_paper_record')
            ->where('id='.$id)
            ->find();
    }

    public function update_exam_record($params){
        Db::table('tb_paper_record')
            ->where('id='.$params['c_e_id'])
            ->update(['paper_res'=>$params['paper_res'],"paper_scord"=>$params['paper_scord']]);
    }

    public function update_exam_final($params){
        Db::table('tb_paper_record')
            ->where('id='.$params['c_e_id'])
            ->update(['paper_res'=>$params['paper_res'],"paper_scord"=>$params['paper_scord'],"paper_submit_time"=>time(),"status"=>1]);
    }

    public function get_paper_mark_list(){
        return Db::table('tb_paper_record')
            ->field('pr.*,p.paper_name')
            ->alias('pr')
            ->join('tb_papers p','pr.paper_id=p.id','LEFT')
            ->where('pr.status=1')
            ->paginate(10);
    }
}