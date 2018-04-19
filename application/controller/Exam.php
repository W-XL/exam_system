<?php
namespace app\controller;

use think\Controller;
use think\Request;
use think\Loader;

class Exam extends Controller {


    public function _initialize(){
        if (!check_login_common()){
            $this->redirect('Login/index');
        }
    }

    public function index(){
        $paper_dao = Loader::model('PaperDao');
        $paper_list = $paper_dao->get_paper_list();
        $this->assign('paper_list',$paper_list);
        $this->assign("pages",$paper_list->render());
        return view();
    }

    public function exam_show(){
        return view('exam_show');
    }

    public function get_paper(){
        if (Request::instance()->isAjax()){
            $parmas = Request::instance()->param();
            if ($parmas['start'] == '1'){
                $exam_dao = Loader::model('ExamDao');
                $paper_res_rand = $exam_dao->get_papers_rand();
                if (!$paper_res_rand){
                    return error_msg("没有相关试卷");
                }
                //开始考试，给时间，题目
                $paper_time = $paper_res_rand[0]['exam_time'];
                return succeed_msg(array('paper_time'=>$paper_time,'paper_id'=>$paper_res_rand[0]['id']));
            }else{
                return error_msg("不能重复开始考试");
            }
        }else{
            return error_msg("请求错误");
        }
    }

    public function get_question(){
        if (Request::instance()->isAjax()){
            $parmas = Request::instance()->param();
            if (!$parmas['p_id'] || !$parmas['q_id']){
                return error_msg("参数错误");
            }
            $exam_dao = Loader::model('ExamDao');
            $paper = $exam_dao->get_paper_by_id($parmas['p_id']);
            if (!$paper){
                return error_msg("没有相关试卷");
            }
            $question_list = explode(',',$paper['paper_questions']);
            $question_count = count($question_list);
            $question = $exam_dao->get_question_by_id($question_list[((int)$parmas['q_id']-1)]);
            return succeed_msg(array("question_count"=>$question_count,"q_title"=>$question['q_title'],
                "q_score"=>$question['q_score'],"q_type_rule"=>$question['q_type_rule'],
                "q_content"=>$question['q_content']));
        }else{
            return error_msg("请求错误");
        }
    }

}