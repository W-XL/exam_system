<?php
namespace app\controller;

use think\Controller;
use think\Request;
use think\Loader;

class Paper extends Controller{

    public function index(){
        $paper_dao = Loader::model('PaperDao');
        $paper_list = $paper_dao->get_paper_list();
        $this->assign('paper_list',$paper_list);
        return view('index');
    }

    public function add_view(){
        return view('add_view');
    }

    public function do_add(){
        $params = Request::instance()->param();
        if(!$params['paper_name'] || !$params['exam_time']){
            return error_msg("缺少必填项");
        }
        $num = $params['single_question'] +$params['multiple_question'] +$params['completion']+$params['short_answer'];
        if($num == '0'){
            return error_msg('试题总和不能为0');
        }
        $paper_dao = Loader::model('PaperDao');
        $paper_dao->insert_paper($params);
        return succeed_msg();
    }

    public function edit_view(){
        $id = input()['id'];
        $paper_dao = Loader::model('PaperDao');
        $info = $paper_dao->get_paper_info($id);
        $this->assign("info", $info);
        return view("edit_view");
    }

    public function do_edit(){
        $params = Request::instance()->param();
        if(!isset($params['paper_name']) || !$params['exam_time']){
            return error_msg("缺少必填项");
        }
        $num = $params['single_question'] +$params['multiple_question'] +$params['completion']+$params['short_answer'];
        if($num == '0'){
            return error_msg('试题总和不能为0');
        }
        $paper_dao = Loader::model('PaperDao');
        $paper_dao->update_paper($_POST);
        return succeed_msg();
    }

    public function delete_view(){
        $id = input()['id'];
        $this->assign('id',$id);
        return view('delete_view');
    }

    public function do_del(){
        $id = Request::instance()->param('id');
        $paper_dao = Loader::model('PaperDao');
        $info = $paper_dao->get_paper_info($id);
        if(!$info){
            return error_msg('删除出错啦');
        }
        $paper_dao->delete_paper($id);
        return succeed_msg();
    }

    public function question_type(){
        $paper_dao = Loader::model('PaperDao');
        $question_list = $paper_dao->get_question_type_list();
        $this->assign('question_list',$question_list);
        return view('question_type');
    }

    public function add_question_type(){
        return view('question_type_add');
    }

    public function do_add_type(){
        $params = Request::instance()->param();
        if(!$params['q_type_name']){
            return error_msg('试题类型名称不能为空');
        }
        $paper_dao = Loader::model('PaperDao');
        $paper_dao->insert_q_type($params);
        return succeed_msg();
    }

    public function question_type_edit(){
        $id = input()['id'];
        $paper_dao = Loader::model('PaperDao');
        $info = $paper_dao->get_question_type_info($id);
        $this->assign("info", $info);
        return view("question_type_edit");
    }

    public function do_edit_type(){
        $params = Request::instance()->param();
        if(!$params['q_type_name']){
            return error_msg('试题类型名称不能为空');
        }
        $paper_dao = Loader::model('PaperDao');
        $paper_dao->update_q_type($params);
        return succeed_msg();
    }

    public function question_list(){
        $paper_dao = Loader::model('PaperDao');
        $question_list = $paper_dao->get_question_list();
        $this->assign('question_list',$question_list);
        return view('question_list');
    }

    public function add_question(){
        $paper_dao = Loader::model('PaperDao');
        $question_type = $paper_dao->get_type_list();
        $this->assign('question_type',$question_type);
        return view('question_add');
    }

    public function do_add_question(){
        $params = Request::instance()->param();
        if(!$params['q_type_id'] || !$params['q_title'] || !$params['q_score']){
            return error_msg('缺少必填项');
        }
        $paper_dao = Loader::model('PaperDao');
        $paper_dao->insert_question($params);
        return succeed_msg();
    }

    public function question_edit(){
        $id = input()['id'];
        $paper_dao = Loader::model('PaperDao');
        $info = $paper_dao->get_question_info($id);
        if(!$info){
            return error_msg('查无此题目');
        }
        $question_type = $paper_dao->get_type_list();
        $this->assign('question_type',$question_type);
        $this->assign('info',$info);
        return view('question_edit');
    }

}