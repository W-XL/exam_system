<?php
// 应用公共文件
use think\Session;
//判断是否登录
function check_login_common(){
    if (!Session::get('user_id')){
        Session::delete('err_msg');
        return false;
    }
    return true;
}

function succeed_msg($message='操作成功'){
    $result['statusCode']="200";
    $result['closeCurrent']="true";
    $result['message']=$message;
    return json_encode($result);
}

function error_msg($message='操作失败'){
    $result['statusCode']="300";
    $result['closeCurrent']="false";
    $result['message']=$message;
    return json_encode($result);
}