<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * 日志系统
 * //输入日志       //接收到那些
 * //输出日志       //中间过程记录
 * //操作日志       //输出哪些
 * //==================================================================
 * 1 预制处理
 * //统一的代码,稍有区别
 * 2 接收参数
 * 接收参数成为变量//并且基本预处理
 * 3 前置判断
 * //对变量进行基本运算和判断
 * 5 过程
 * 程序流程 存储
 * 8 后置处理
 * //跟随主流程的后置处理过程
 * 9 输出
 * //输出结果
 * */

class Enter
{
    private $tmp = array();
    private $params = array();
    private $CI = null;
    private $de = array();
    private $log = array();
    private $sign = array();

//log格式
//==================================================================
//class
//aa
//code
//msg
//time [cutime / timebeg / endtime]
//get
//post
//sign
//params
    public function __construct($params)    //$params 是路由参数
    {
        $this->CI =& get_instance();
        $this->vdb = new V1db();                    //数据逻辑层
        $this->params = $params;                    //路由参数
        $this->tmp['timestamp_'] = Set::T();        //$sign //参数是签名
        //======================================================================
        !empty($params) && $this->log['params'] = $params;              //log
        $this->log['time']['timecu'] = time();;                         //log
        $this->log['time']['timebe'] = $this->tmp['timestamp_'];        //log
        $this->log['class'] = __class__;                                //log
        //======================================================================
        //print_r($this->log);
    }

    /*
     * 1 : 接口   /   注册用户    //接口 [adduser]
     * 输入
     * {
       "username":"ASDASDFASDF",
       "password":"wangjun1"
       }
    返回
    {
    "code":"200",
    "msg":"succeed",
    }
    */
    public function adduser($sign = array())
    {
        //-----------------------------------------------------------------
        //1 前置
        $this->sign = $sign;
        !empty($sign) && $this->log['sign'] = $sign;        //方法中截取
        $this->log['mothod'] = __METHOD__;                  //方法中截取
        $this->getpost($_POST);
        //-----------------------------------------------------------------


        //-----------------------------------------------------------------
        //2 : 接收参数
        $username = $this->CI->input->post('username');
        $password = $this->CI->input->post('password');
        //-----------------------------------------------------------------

        //-----------------------------------------------------------------
        //3 : 判断
        $_march = '/[^A-Za-z0-9]/';             //如果发现字母数字意外的字符 报错
        if (preg_match($_march, $username)) {
            $this->J(-200, '用户名非法，请重新输入正确的用户名');
        }
        if (preg_match($_march, $password)) {
            $this->J(-200, '密码非法，请重新输入正确的密码');
        }
        $ulen = strlen($username);
        $upwd = strlen($password);
        if ($ulen < 4 || $ulen > 16) {
            $this->J(-200, '用户名长度非法');
        }
        if ($upwd < 4) {
            $this->J(-200, '密码长度非法');
        }

        $se['user_login'] = $username;
        $row = $this->mdb->findOne("dy_user", $se);

        if ($row) {
            $this->J(-200, '该用户已经存在');
        }

        //-----------------------------------------------------------------
        //3 : 流程处理
        //===============================================================
        //添加用户操作
        $mc['user_login'] = $username;
        //$mc['user_password']= MD5($password.$sign['salt']);
        $mc['user_password'] = $password;
        $mc['open_id'] = substr(MD5($username . '_' . $sign['salt'] . '_' . Set::T()), 8, 16);                //计算生成一个  唯一
        $mc['enable'] = 1;
        $mc['f_regtime'] = time();

        $this->mdb->insert('dy_user', array_merge(V1db::table_dy_user(), $mc));               //添加数据

        //输出
        $this->J(200, 'succeed');
    }

    /*
        *  罚单app登录 [login]
    模块 :登录模块
    说明 :本接口能够实现登录功能
    参数 :"username":用户名，"password":密码
    成功 :登陆成功"code"的返回值为"200"
    失败 :返回值待定     *
         *
    提交 :
    {
    "username":"zhangbo",
    "password":"zhangbo"
    }
    返回 :
    {
    "code":"200",
    "msg":"succeed",
    }     *
    * */
    public function login($sign = array())
    {
        //-----------------------------------------------------------------
        //* 1 预制处理
        $this->sign = $sign;                                //签字获取
        !empty($sign) && $this->log['sign'] = $sign;        //方法中截取
        $this->log['mothod'] = __METHOD__;                  //方法中截取
        $this->getpost($_POST);                             //反馈获取到的数据
        //-----------------------------------------------------------------


        // * 2 接收参数
        $username = $this->CI->input->post('username');
        $password = $this->CI->input->post('password');

        // * 3 前置判断
        $_march = '/[^A-Za-z0-9]/';             //如果发现字母数字意外的字符 报错
        if (preg_match($_march, $username)) {
            $this->J(-200, '用户名非法，请重新输入正确的用户名');
        }


        //$sql = "select * from dy_user where user_login = '$username'";
        //$row = $this->CI->db->getrow($sql);

        $se['user_login'] = $username;
        $row = $this->mdb->findOne("dy_user", $se);

        if (empty($row)) {
            $this->J(-200, '该用户不存在');
        }
        if ($row['enable'] == 0) {
            $this->J(-200, '不是有效用户');
        }
//        if($row['user_password'] != MD5($password.$sign['salt'])){
//            $this->J(-200, '密码错误');
//        }
        if ($row['user_password'] != $password) {
            $this->J(-200, '密码错误');
        }

        //================================================================
        //$mc['f_logintime'] = $this->CI->T();

        // * 5 过程
        // * 8 后置处理
        $row['f_logintime'] = time();
        $row['f_loginip'] = Set::GetIP();

        //变更数据
        $this->mdb->update("dy_user", $se, $row);

        // * 9 输出
        $this->J(200, 'succeed');
    }


    public function changepassword($sign = array())
    {
        //-----------------------------------------------------------------
        //* 1 预制处理
        $this->sign = $sign;                                //签字获取
        !empty($sign) && $this->log['sign'] = $sign;        //方法中截取
        $this->log['mothod'] = __METHOD__;                  //方法中截取
        $this->getpost($_POST);                             //反馈获取到的数据
        //-----------------------------------------------------------------
        // * 2 接收参数
        $username       = $this->CI->input->post('username');
        $newPassword    = $this->CI->input->post('newPassword');

        $se['user_login'] = $username;
        $row = $this->mdb->findOne("dy_user", $se);
        if ($row['enable'] == 0) {
            $this->J(-200, '不是有效用户');
        }
        $row['user_password'] = $newPassword;

        $this->mdb->update("dy_user", array("user_login"=>$username),$row);
        //-----------------------------------------------------------------
        $this->J(200, 'ok1');
    }


    /*
    *  返回本地剩余的抽样单号 [enter/chexiao]
     * //国内 国外调用的同一个
     */
    public function chexiao($sign = array())
    {
        //-----------------------------------------------------------------
        $this->sign = $sign;
        !empty($sign) && $this->log['sign']    = $sign;        //方法中截取
        $this->log['mothod']    = __METHOD__;        //方法中截取
        $this->getpost($_POST);
        //-----------------------------------------------------------------

        $SimpleNumber = $_POST['SimpleNumber'];
        $SimpleNumber = json_decode($SimpleNumber);
//        print_r($SimpleNumber);
//        exit;
        $this->get($SimpleNumber);
        //============================================================
        if(empty($SimpleNumber))$SimpleNumber = array();
        foreach($SimpleNumber as $value){
            $row = $this->mdb->findone("dy_typeoddid", array("odd_id"=>$value));
            $row['used'] = 0;
            $this->mdb->update("dy_typeoddid", array("odd_id"=>$value),$row);
        }
        $this->J(200, 'succeed');
    }














    //获取预定单号, 分国内国外
    //book / book_gn
    public function book($sign = array())
    {
        //-----------------------------------------------------------------
        $this->sign = $sign;
        !empty($sign) && $this->log['sign'] = $sign;        //方法中截取
        $this->log['mothod'] = __METHOD__;                  //方法中截取
        $this->getpost($_POST);
        //-----------------------------------------------------------------
        //参数
        $_f = 'J';              // $_f 国外
        $_s = '46';             // $_s 省
        $_y = date('Y');        // $_y 年
        $_n = intval($_POST['count']);        // $_n 数量
        $de = $this->book_do($_n,$_f,$_s,$_y);

        $this->data($de['data']);
        $this->data2($de['data2']);
        $this->J(200, 'succeed');
    }

    public function book_gn($sign = array())
    {
        //-----------------------------------------------------------------
        $this->sign = $sign;
        !empty($sign) && $this->log['sign'] = $sign;        //方法中截取
        $this->log['mothod'] = __METHOD__;                  //方法中截取
        $this->getpost($_POST);
        //-----------------------------------------------------------------

        //参数
        $_f = 'G';              // 国内
        $_s = '46';             // $_s 省
        $_y = date('Y');        // $_y 年
        $_n = intval($_POST['count']);        // $_n 数量
        $de = $this->book_do($_n,$_f,$_s,$_y);

        $this->data($de['data']);
        $this->data2($de['data2']);
        $this->J(200, 'succeed');
    }

    // $_f 国内国外
    // $_s 省
    // $_y 年
    // $_n 数量
    private function book_do($_n=1,$_f='',$_s='',$_y=''){
        if(empty($_f))  $_f = 'J';
        if(empty($_s))  $_s = '46'; //海南
        if(empty($_y))  $_y = date('Y'); //海南
        $pre = $_f.$_s.$_y;

        $rc = $this->mdb->find("dy_typeoddid", array("f"=>$_f), array("sort" => array("odd_id" => -1), "limit" => 1));
        $max = $rc[0]['odd_id'];        //系统中最大的id
        //截取max获得数字
        $max_num = substr($max, -6);
        $max = intval($max_num);

        // ========================================================
        //空闲单号中最大的
        $nd = $this->mdb->find("dy_typeoddid", array("f"=>$_f,"enable" => 1, "up" => 0, "used" => 0), array("sort" => array("odd_id" => 1), "limit" => $_n));
        $j = 0;
        $nw = array();
        foreach ($nd as $key => $value) {
            if ($j < $_n) {
                $nw[]   = $value['odd_id'];
                $me     = $value;
                $me['openid'] = '';
                $me['used'] = 1;
                $me['up'] = 0;
                $this->mdb->update("dy_typeoddid", array("odd_id" => $value['odd_id']), $me);
            }
            $j++;
        }

        for ($i = 0; $i < $_n - $j; $i++) {
            $tn = $max + $i + 1;
            $tn_od  = substr(strval($tn + 1000000), 1, 7);
            $nw[]   = $pre. $tn_od;
//            $md['type_id']  = 1;
            $md['odd_id']   = $pre. $tn_od;
            $md['f']        = $_f;
            $md['user']     = (string)$this->sign['user'];
            $md['used']     = 1;
            $md['up']       = 0;
            $md['enable']   = 1;
//            $this->CI->db->autoexecute('dy_typeoddid',$md,'INSERT');
            $this->mdb->insert('dy_typeoddid', array_merge(V1db::table_dy_typeoddid(), $md));
        }

        $user = (string)$this->sign['user'];
        $rc = $this->mdb->find("dy_typeoddid", array("f"=>$_f,"enable" => 1, "up" => 0, "used" => 1, "user" => "$user"));
        foreach ($rc as $key => $value) {
            $dt[] = $value["odd_id"];
        }
        $dt = array_diff($dt, $nw);
        $dt = array_values($dt);

        $me['data']     = $nw;
        $me['data2']    = $dt;
        return $me;
    }



    /*
     * 上传文件数据
     * */
    public function upfile($sign = array())
    {
        //-----------------------------------------------------------------
        $this->sign = $sign;
        !empty($sign) && $this->log['sign']    = $sign;         //方法中截取
        $this->log['mothod']    = __METHOD__;                   //方法中截取
        //$this->getpost($_FILES);
        //-----------------------------------------------------------------
        if(empty($_FILES['tfile']['name'])) $this->J(-200, 'error');        //文件名空
        //接收数据上传文件
        //-----------------------------------------------------------------
        $dirp = './A/upload/v1/'.date("Ym").'/';
        !is_dir($dirp) && @mkdir($dirp);
        $dirp = './A/upload/v1/'.date("Ym").'/'.date("d").'/';
        !is_dir($dirp) && @mkdir($dirp);
        //-----------------------------------------------------------------
        $target_path = $dirp . basename($_FILES['tfile']['name']);
        //-----------------------------------------------------------------
        if(move_uploaded_file($_FILES['tfile']['tmp_name'], $target_path)) {
            $refile = $target_path;
            $msg = " 上传成功";
        }  else{
            $refile = "";
            $msg = " error, please try again!" . $_FILES['tfile']['error'];
        }
        $this->data($refile);
        $this->msg($msg);
        //-----------------------------------------------------------------
        $this->J(200, 'succeed');
    }

    /**********************************************************************
    /**********************************************************************
    /**********************************************************************
    /**********************************************************************
    /**********************************************************************
    /**********************************************************************
     * */
    private function data($data)
    {
        $this->de['data'] = $data;
    }
    private function data2($data)
    {
        $this->de['data2'] = $data;
    }
    private function msg($msg = '')
    {
        $this->de['msg'] = $msg;
    }
    private function get($msg = '')
    {
        $this->de['get'] = $msg;
    }
    private function getpost($arr = '')
    {
        $this->de['getpost'] = print_r($arr,true);
    }

    //输出json
    public function J($code=0,$msg='')
    {
        $code = intval($code);
        if(!empty($code))  $this->de['code'] = $code;
        if(!empty($msg))   $this->de['msg']  = $msg;

        //$this->de['timestamp_'] = $this->tmp['timestamp_'];
        //$this->de['timestamp']  = Set::T();
        $this->de['ExecuteTime'] = Set::T() - $this->tmp['timestamp_'];
        $this->de['ExecuteModel']  = 'Enter';
        //print_r($this->de);
        $this->logmon->L($code,$msg,$this->log);
        echo json_encode($this->de);
        exit;
    }

    //魔术
    public function __call($name,$arguments) {
        echo $name;
        print_r($arguments);
        echo 'miss';
        exit;
    }

    //资源重定向到ci->s下
    public function __get($key)
    {
        return $this->CI->S->$key;
    }

    public function __set($key, $value)
    {
        return $this->CI->S->$key = $value;
    }

    public function __isset($key)
    {
        return isset($this->CI->S->$key);
    }

    public function __unset($key)
    {
        unset($this->CI->S->$key);
    }

}