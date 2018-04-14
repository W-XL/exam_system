<?php
namespace app\controller;

use think\Controller;
use think\Session;
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
        if(!isset($_POST['paper_name']) || !$_POST['exam_time']){
            $this->error_msg("缺少必填项");
        }
        $paper_dao = Loader::model('PaperDao');
        $paper_dao->insert_paper($_POST);
        $this->succeed_msg();
    }

    public function edit_view(){
        $id = input()['id'];
        $paper_dao = Loader::model('PaperDao');
        $info = $paper_dao->get_paper_info($id);
        $this->assign("info", $info);
        return view("edit_view");
    }

    public function do_edit(){
        if(!isset($_POST['paper_name']) || !$_POST['exam_time']){
            $this->error_msg("缺少必填项");
        }
        $paper_dao = Loader::model('PaperDao');
        $paper_dao->update_paper($_POST);
        $this->succeed_msg();
    }

    public function delete_view(){
        $id = input()['id'];
        $this->assign('id',$id);
        return view('delete_view');
    }

    public function do_del(){
        $paper_dao = Loader::model('PaperDao');
        $info = $paper_dao->get_paper_info($_POST['id']);
        if(!$info){
            $this->error_msg('删除出错啦');
        }
        $paper_dao->delete_paper($_POST['id']);
        $this->succeed_msg();
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
        if(!$_POST['q_type_name']){
            $this->error_msg('试题类型名称不能为空');
        }
        $paper_dao = Loader::model('PaperDao');
        $paper_dao->insert_q_type($_POST);
        $this->succeed_msg();
    }

}