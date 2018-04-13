<?php
namespace app\controller;

use think\Controller;
use think\Session;
use think\Loader;

class Account extends Controller{

    public function index(){
        $account_dao = Loader::model('AccountDao');
        $list = $account_dao->get_account_list();
        $this->assign("params", $_GET);
        $this->assign("datalist", $list);
        return view('index');
    }



}