<?php
namespace app\controller;

use think\Controller;
use think\Request;
use think\Loader;
use think\Session;

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
        $p_id = Request::instance()->param('p_id');
        $this->assign('paper_id',$p_id);
        return view('exam_show');
    }

    public function get_paper(){
        if (Request::instance()->isAjax()){
            $parmas = Request::instance()->param();
            if ($parmas['start'] == '1'){
                $exam_dao = Loader::model('ExamDao');
                $paper = $exam_dao->get_paper_by_id($parmas['p_id']);
                if (!$paper){
                    return error_msg("没有相关试卷");
                }
                //开始考试，给时间，题目
                $exam_id = $exam_dao->insert_exam_record(array("paper_id"=>$parmas['p_id'],"do_id"=>Session::get('user_id')));
                $paper_time = $paper['exam_time'];
                return succeed_msg(array('paper_time'=>$paper_time,'paper_id'=>$paper['id'],'curr_exam_id'=>$exam_id));
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

    public function do_question(){
        if (Request::instance()->isAjax()){
            $parmas = Request::instance()->param();
            $exam_dao = Loader::model('ExamDao');
            $paper = $exam_dao->get_paper_by_id($parmas['p_id']);
            $question_list = explode(',',$paper['paper_questions']);
            $question = $exam_dao->get_question_by_id($question_list[((int)$parmas['q_id']-1)]);
            if (!array_key_exists('q_res',$parmas)){
                $parmas['q_res'] = '';
            }
            if ($question['q_answer'] == trim($parmas['q_res'],',')){
                //添加分数
                $exam_old_res = $exam_dao->get_exam_record_by_id($parmas['c_e_id']);
                $exam_dao->update_exam_record(array("c_e_id"=>$parmas['c_e_id'],"paper_res"=>trim($exam_old_res['paper_res'].','.'['.trim($parmas['q_res'],',').']',','),"paper_scord"=>(float)$exam_old_res['paper_scord']+(float)$question['q_score']));
            }else{
                $exam_old_res = $exam_dao->get_exam_record_by_id($parmas['c_e_id']);
                $exam_dao->update_exam_record(array("c_e_id"=>$parmas['c_e_id'],"paper_res"=>trim($exam_old_res['paper_res'].','.'['.trim($parmas['q_res'],',').']',','),"paper_scord"=>(float)$exam_old_res['paper_scord']));
            }
            return ;
        }
    }

    public function exam_submit(){
        $parmas = Request::instance()->param();
        $exam_dao = Loader::model('ExamDao');
        $paper = $exam_dao->get_paper_by_id($parmas['paper_id']);
        $question_list = explode(',',$paper['paper_questions']);
        $question = $exam_dao->get_question_by_id($question_list[((int)$parmas['question_id']-1)]);
        if (!array_key_exists('submit_res',$parmas)){
            $parmas['submit_res'] = '';
        }
        if ($question['q_answer'] == trim($parmas['submit_res'],',')){
            //添加分数
            $exam_old_res = $exam_dao->get_exam_record_by_id($parmas['curren_exam_id']);
            $exam_dao->update_exam_final(array("c_e_id"=>$parmas['curren_exam_id'],"paper_res"=>trim($exam_old_res['paper_res'].','.'['.trim($parmas['submit_res'],',').']',','),"paper_scord"=>(float)$exam_old_res['paper_scord']+(float)$question['q_score']));
        }else{
            $exam_old_res = $exam_dao->get_exam_record_by_id($parmas['curren_exam_id']);
            $exam_dao->update_exam_final(array("c_e_id"=>$parmas['curren_exam_id'],"paper_res"=>trim($exam_old_res['paper_res'].','.'['.trim($parmas['submit_res'],',').']',','),"paper_scord"=>(float)$exam_old_res['paper_scord']));
        }
        return succeed_msg("交卷成功");
    }

    //老师阅卷
    public function exam_mark(){
        $exam_dao = Loader::model('ExamDao');
        $paper_list = $exam_dao->get_paper_mark_list();
        $this->assign('paper_list',$paper_list);
        $this->assign("pages",$paper_list->render());
        return view('exam_mark');
    }

    public function exam_mark_show(){
        //只阅简答题
        $params = Request::instance()->param();
        if ($params['p_record_id']){
            $exam_dao = Loader::model('ExamDao');
            //$paper_record_res = $exam_dao->get_exam_record_by_id($params['p_record_id']);
            $exam_dao->update_exam_teacher($params);
            return view('exam_mark_check');
        }else{
            return '参数错误';
        }
    }

}