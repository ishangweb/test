<?php
class Db
{
    private static $instance;
    public $db;
    public $config = [
        'dsn' => "mysql:host=127.0.0.1;port=3306;dbname=test",
        'username' => 'root',
        'password' => '',
        'options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ]
    ];
    private function __construct(array $config = [])
    {
        !empty($config) ? $this->config = $config : false;
        try {
            $this->db = new PDO($this->config['dsn'], $this->config['username'], $this->config['password'], $this->config['options']);
            return $this->db;
        } catch (PDOException $e) {
            die("Connect Error!:".$e->getMessage().'<br>');

        }
    }

    /**
     * 数据库链接参数
     *
     * @param array $config
     * @return Db
     */
    public static function connect(array $config = [])
    {
        if (false == (self::$instance instanceof self)) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * 绑定数组键值对参数方式执行sql语句
     *
     * @param string $sql 绑定执行的sql语句
     * @param array $data 需要绑定的参数
     * @return array
     */
    public function query($sql , array $data = [])
    {
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute($data);
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("SQL Error!:".$e->getMessage().'<br>');
        }
    }

    /**
     * 绑定数组键值对参数方式执行sql语句
     *
     * @param string $sql 绑定执行的sql语句
     * @param array $data 需要绑定的参数
     * @return int
     */
    public function exec($sql , array $data = [])
    {
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute($data);
            return $sth->rowCount();
        } catch (PDOException $e) {
            die("SQL Error!:".$e->getMessage().'<br>');
        }
    }
}
