<?php

include 'LoginModel.php';
$info = [
    'msg' => 'request type error',
    'status' => 0,
    'data' => []
];
function dataFire($var)
{
    $data = [];
    foreach ($var as $k=>$v) {
        if (is_array($v)) {
            $data[$k] = dataFire($v);
        } else {
            $data[$k] = addslashes($v);
        }
    }
    return $data;
}

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $_POST  = dataFire($_POST);
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $csrfKey = isset($_POST['csrf_key']) ? $_POST['csrf_key'] : '';
    if (!preg_match('/^[\da-zA-z]{6,12}$/',$username) || empty($password)) {

        $info['msg'] = '用户名或密码错误s';
    }else{
        $loginModel = new LoginModel();
        $info = $loginModel->checkLogin($username, $password, $csrfKey);
    }
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($info);
