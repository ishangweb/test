<?php
include __DIR__.'/Db.php';
class LoginModel
{
    public $id;
    public $username;
    public $password;
    public $time;

    public $returnInfo = [
        'msg' => '',
        'status' => 1,
        'data' => []
    ];

    public function __construct()
    {
        $this->time =  date('Y-m-d H:i:s');
    }

    /**
     * 检测用户登陆，如果没登陆，进行用户注册
     *
     * @param string $username  POST提交的用户名
     * @param string $password  POST提交的密码
     * @param string $csrfToken POST提交的csrfToken
     * @return array
     */
    public function checkLogin($username, $password, $csrfToken)
    {
        $this->username = $username;
        $this->password = $password;

        session_start();
        $cookieCsrf = isset($_COOKIE['csrf_key']) ? $_COOKIE['csrf_key'] : '';
        $sessionCsrf = isset($_SESSION['csrf_key']) ? $_SESSION['csrf_key'] : '';
        // 验证token是否正确以及合法性
        if ( $sessionCsrf !== $csrfToken || $sessionCsrf !== $cookieCsrf) {
            $this->returnInfo = [
                'msg' => '请求参数丢失，请刷新后在登录',
                'status' => 0
            ];
            return $this->returnInfo;
        }

        $sql = "SELECT id, password FROM user WHERE username=:username LIMIT 1";
        $userInfo = Db::connect()->query($sql,['username' =>$this->username]);
        // 判断数据库是否能查询用户信息数据，如果存在，则用户名正确
        if(!$userInfo){
            return $this->register($this->username, $this->password);
        }
        // 判断数据库查询出来的MD5加密的密码和用户输入的密码再次加密对比后，是否一样，如果不一样，则密码错误
        if ( $userInfo[0]['password'] !== md5($password. 'key')){
            $this->returnInfo = [
                'msg' => '亲，您的输入的密码错误哦！',
                'status' => 0
            ];
            return $this->returnInfo;
        }
        return $this->updateTime($userInfo[0]['id']);
    }

    /**
     * 注册用户
     *
     * @return array|string
     */
    public function register($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        $sql = "INSERT INTO user SET username=:username, password=:password, create_time=:create_time, update_time=:update_time";
        $bandParam = [
            'username' => $this->username,
            'password' => md5($this->password. 'key'),
            'create_time' => $this->time,
            'update_time' => $this->time
        ];
        $rowCount = Db::connect()->exec($sql, $bandParam);
        if ($rowCount) {
            $this->returnInfo['msg'] = '用户注册成功';
            $this->returnInfo['data']['username'] = $username;
        } else {
            $this->returnInfo = [
                'msg' => '用户注册失败',
                'status' => 0
            ];
        }
        return $this->returnInfo;
    }

    /**
     * 更新用户信息
     *
     * @param int $id 主键id
     * @return array
     */
    public function update($id)
    {
        $sql = "UPDATE `user` SET `username`=':username', `password`=':password', `update_time`=':update_time' WHERE `id`=:id";
        $bandParam = [
            'username' => $this->username,
            'password' => $this->password,
            'update_time' => $this->time,
            'id' => $id
        ];
        $rowCount = Db::connect()->exec($sql, $bandParam);
        if ($rowCount) {
            $this->returnInfo['msg'] = '数据更新成功';
        } else {
            $this->returnInfo['msg'] = '数据更新成功';
            $this->returnInfo['status'] = 0;
        }
        return $this->returnInfo;
    }

    /**
     * 更新用户信息
     *
     * @param int $id 主键id
     * @return array
     */
    public function updateTime($id)
    {
        $sql = "UPDATE `user` SET `update_time`=:update_time WHERE `id`=:id";
        $bandParam = [
            'update_time' => $this->time,
            'id' => $id
        ];
        $rowCount = Db::connect()->exec($sql, $bandParam);
        if ($rowCount) {
            $this->returnInfo['msg'] = '用户登陆成功,并且更新用户时间成功';
        } else {
            $this->returnInfo = [
                'msg' => '用户登陆成功，但更新用户时间失败',
                'status' => 1
            ];
        }
        return $this->returnInfo;
    }
}
