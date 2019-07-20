<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/6/22
 * Time: 12:07
 * file: 数据库配置类
 */
namespace lib;
class DbConfig
{

    private static $db_name = 'blog';//    数据库名字
    private static $host = '127.0.0.1';//   主机名
    private static $user = 'root';// 用户名
    private static $password = 'goldenleek'; //用户密码
    private static $db_type = 'mysql'; //数据库类型
    private static $port = '3306';

    /**
     * @return string
     */
    public static  function getDbType()
    {
       return self::$db_type;
    }

    /**
     * @return string
     */
    public static function getDsn()
    {
        switch (strtolower(trim(self::getDbType()))){
            case 'mysql':
               return "mysql:host=".self::getHost().";dbname=".self::getDbName();
                break;
            case 'oracle':
               return  "oci:dbname=//".self::getDbName().":1521/".self::getUser();
                break;
            default:
                return '';
        }
    }


    /**
     * @return string
     */
    public static function getDbName()
    {
       return self::$db_name;
    }


    /**
     * @return string
     */
    public static function getHost()
    {
        return self::$host;
    }


    /**
     * @return string
     */
    public static function getUser()
    {
       return self::$user;
    }


    /**
     * @return string
     */
    public static function getPassword()
    {
       return self::$password;
    }


}