<?php
/**
 *  管理 /T/mem.php   [admin / admin]
 * Memcache 操作类
 * 在config文件中 添加
     相应配置(可扩展为多memcache server)
    define('MEMCACHE_HOST', '10.35.52.33');
    define('MEMCACHE_PORT', 11211);
    define('MEMCACHE_EXPIRATION', 0);
    define('MEMCACHE_PREFIX', 'licai');
    define('MEMCACHE_COMPRESSION', FALSE);
/* Mcache beging */
/*-------------------------------------------------------------------------------

    //格式
    //==================================================================
//class     //class cu中
//params    //class cu中
//time [cutime / timebeg / endtime] //class cu cu log

//code      //方法e
//msg       //方法e
//get       //log中
//post      //log中
//mothod    //方法中
//sign      //方法中
    //==================================================================

------------------------------------------------------------------------------* /
 */
class Sham_Logmon{


    protected $errors = array();


    public function __construct()
    {
        $this->CI =& get_instance();
    }

    //系统的开发日志
    public function L($code,$info,$loginfo)
    {
        $loginfo['code'] = $code;        //code
        $loginfo['info'] = $info;        //info


        !empty($_GET) && $loginfo['_GET']   = $_GET;            //log
        $loginfo['_POST'] = $_POST;        //log
        $loginfo['time']['timeen']  = Set::T();      //log
        $this->CI->S->mdb->insert('dy_log',$loginfo);
        return true;
    }

    //格式
    //==================================================================
    //code
    //msg
    //time
    //input
    //==================================================================


}// END class









