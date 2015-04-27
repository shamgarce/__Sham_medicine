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

    public function uploading_inland($sign = array())
    {

        //-----------------------------------------------------------------
        $this->sign = $sign;
        !empty($sign) && $this->log['sign'] = $sign;        //方法中截取
        $this->log['mothod'] = __METHOD__;                  //方法中截取
        //-----------------------------------------------------------------

        $phaForm = $_POST['phaForm'];
        $phaForm = json_decode($phaForm, true);
//        $phaForm = Set::ob2ar($phaForm);


        $this->getpost($phaForm);


        //echo $md;
        //$this->getarr($md);

        $phaForm = $phaForm['pharmaceuticalForm'];
        $phaForm['SampleFormNumber'] = (string)($phaForm['SampleFormNumber']);
        $phaForm['for'] = substr($phaForm['SampleFormNumber'],0,1);


        $odd_id = $phaForm['SampleFormNumber'];
        //首先检查抽样id的合法性
        //============================================================
        $cond['odd_id'] = $odd_id;
        $this->get($phaForm);
        $row = $this->mdb->findOne("dy_typeoddid", $cond);
        if (empty($row)) {
            $this->J(-201, '无效的预定单号' . $odd_id);
        }

        if ($row['used'] == 0) {
            $this->J(-202, '非有效');
        }
        if ($row['up'] == 1) {
            $this->J(-203, '过期的单号');
        }

        //============================================================
        $simpleConditionList = $phaForm['sampleCondition']['sampleConditionList'];
        $simpleDepartmentList = $phaForm['sampleDepartment']['sampleDepartmentList'];

        unset($phaForm['sampleCondition']['sampleConditionList']);
        unset($phaForm['sampleDepartment']['sampleDepartmentList']);

        $this->mdb->insert('dy_SampleForm', $phaForm);        //主记录

        foreach ($simpleConditionList as $key => $value) {
            unset($me);
            $me['odd_id'] = $odd_id;
            $me = array_merge($me, $value);
            $this->mdb->insert('dy_SampleCondition', $me);
        }

        foreach ($simpleDepartmentList as $key => $value) {
            unset($me);
            $me['odd_id'] = $odd_id;
            $me = array_merge($me, $value);
            $this->mdb->insert('dy_SampleDepartment', $me);
        }

        //上传完毕,更改状态
        // print_r($row);
//        $this->mdb->update("test_table", array("id"=>1),array("id"=>1,"title"=>"bbb"));
        $row['up'] = 1;
        $this->mdb->update("dy_typeoddid", array("odd_id" => $row['odd_id']), $row);

        $this->J(200, 'succeed');
    }

    /*
     * 接口 : 上传抽样单    [enter/uploading]
     * 录入模块中的上传模块，将抽样单中的所有信息通过json串上传，
     * 上传成功后code返回200，上传失败返回505。
     * 提交 数据
     *返回    { "code":"200","msg":"succeed","data":{"name":"name"}}
     * */
    public function uploading($sign = array())
    {
        //-----------------------------------------------------------------
        $this->sign = $sign;
        !empty($sign) && $this->log['sign'] = $sign;        //方法中截取
        $this->log['mothod'] = __METHOD__;                  //方法中截取
        //-----------------------------------------------------------------

        $phaForm = $_POST['phaForm'];
        $phaForm = json_decode($phaForm, true);

        $this->getpost($phaForm);

//        $phaForm = Set::ob2ar($phaForm);
        $phaForm = $phaForm['pharmaceuticalForm'];
        $phaForm['SampleFormNumber'] = (string)($phaForm['SampleFormNumber']);
        $phaForm['for'] = substr($phaForm['SampleFormNumber'],0,1);
        $odd_id = $phaForm['SampleFormNumber'];
        //首先检查抽样id的合法性
        //============================================================
        $cond['odd_id'] = $odd_id;
        $this->get($phaForm);
        $row = $this->mdb->findOne("dy_typeoddid", $cond);
        if (empty($row)) {
            $this->J(-201, '无效的预定单号' . $odd_id);
        }

        if ($row['used'] == 0) {
            $this->J(-202, '非有效');
        }
        if ($row['up'] == 1) {
            $this->J(-203, '过期的单号');
        }

        //============================================================
        $simpleConditionList = $phaForm['sampleCondition']['sampleConditionList'];
        $simpleDepartmentList = $phaForm['sampleDepartment']['sampleDepartmentList'];

        unset($phaForm['sampleCondition']['sampleConditionList']);
        unset($phaForm['sampleDepartment']['sampleDepartmentList']);

        $this->mdb->insert('dy_SampleForm', $phaForm);        //主记录

        foreach ($simpleConditionList as $key => $value) {
            unset($me);
            $me['odd_id'] = $odd_id;
            $me = array_merge($me, $value);
            $this->mdb->insert('dy_SampleCondition', $me);
        }

        foreach ($simpleDepartmentList as $key => $value) {
            unset($me);
            $me['odd_id'] = $odd_id;
            $me = array_merge($me, $value);
            $this->mdb->insert('dy_SampleDepartment', $me);
        }

        //上传完毕,更改状态
        // print_r($row);
//        $this->mdb->update("test_table", array("id"=>1),array("id"=>1,"title"=>"bbb"));
        $row['up'] = 1;
        $this->mdb->update("dy_typeoddid", array("odd_id" => $row['odd_id']), $row);

        $this->J(200, 'succeed');
    }

    /*
     *  上传预定 [enter/book/]
     *  模块 : 抽样单号管理
        说明 : 本接口为上传预定的接口;
        参数 : 为要预定的抽样单号的数量;
        成功 : code返回200并且在data数组中返回所预定的抽样单号号码
        失败 : 预定失败则返回506.
     * ========================================================
     * 输入
     *{
        "count":2
        }
     * ========================================================
     * 输出
     * {
        "code":"200",
        "msg":"succeed",
        "data":["j2015000001","j2015000002"]
        }
     */
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
    *  返回本地剩余的抽样单号 [enter/chexiao]
     *
       模块 :录入
       说明 :录入模块中的撤销功能，此功能会把手机端数据库中没有用过的抽样单号返回给数据库。
       参数 :SimpleNumber
       成功 :"code"的值为200
       失败 :“code”的值为507
     * 提交 :
       {
           "SimpleNumber":[]
       }
     * 返回 :
       {
       "code":"200",
       "data":[],
       "msg":"succeed"
       }
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


    /*
    *  抽样号检索 [search/simplenumber]
        模块 :检索模块中的抽样单号检索
        说明 :此接口用于实现在服务器上根据抽样单号
        参数 :"phaSimpleNumber":要查询的抽样单号
        成功 :查询成功"code"返回200，同时"data"中带有查询到的抽样单表的信息
        失败 :查询失败"code"返回508
     * 输入
     * {
        "phaSimpleNumber":"1312122"
        }
     * 输出
    */
    public function simplenumber($sign = array())
    {
        //-----------------------------------------------------------------
        $this->sign = $sign;
        !empty($sign) && $this->log['sign']    = $sign;        //方法中截取
        $this->log['mothod']    = __METHOD__;        //方法中截取
        $this->getpost($_POST);
        //-----------------------------------------------------------------


        $oddid =  (string)$_POST['SampleFormNumber'];
//echo $oddid;
        $row = $this->mdb->findone("dy_SampleForm", array("SampleFormNumber"=>$oddid));
if(empty($row)) $this->J(508, 'error');
        $row['sampleCondition']['sampleConditionList']     = $this->mdb->find("dy_SampleCondition", array("odd_id"=>$oddid));
        $row['sampleDepartment']['sampleDepartmentList']   = $this->mdb->find("dy_SampleDepartment", array("odd_id"=>$oddid));
        $this->data($row);
        $this->J(200, 'succeed');
    }

    public function search($sign = array())
    {
        //-----------------------------------------------------------------
        $this->sign = $sign;
        !empty($sign) && $this->log['sign']    = $sign;        //方法中截取
        $this->log['mothod']    = __METHOD__;        //方法中截取
        $this->getpost($_POST);
        //-----------------------------------------------------------------
        $nrc = $this->search_do("J");
        $this->data($nrc);
        $this->J(200, 'succeed');
    }

    public function search_gn($sign = array())
    {
        //-----------------------------------------------------------------
        $this->sign = $sign;
        !empty($sign) && $this->log['sign']    = $sign;        //方法中截取
        $this->log['mothod']    = __METHOD__;        //方法中截取
        $this->getpost($_POST);
        //-----------------------------------------------------------------
        $nrc = $this->search_do("G");
        $this->data($nrc);
        $this->J(200, 'succeed');
    }

    public function upfile($sign = array())
    {
        //-----------------------------------------------------------------
        $this->sign = $sign;
        !empty($sign) && $this->log['sign']    = $sign;        //方法中截取
        $this->log['mothod']    = __METHOD__;        //方法中截取
        //$this->getpost($_FILES);
        //-----------------------------------------------------------------
        //接收数据上传文件
        //-----------------------------------------------------------------
        $target_path  = "./A/upload/";//接收文件目录
        //if(empty($_FILES['uploadedfile']['name'])) $this->J(200, 'succeed');        //文件名空
        //-----------------------------------------------------------------
        $dirp = $target_path.'v1/'.date("Ym").'/';
        !is_dir($dirp) && @mkdir($dirp);
        $dirp = $target_path.'v1/'.date("Ym").'/'.date("d").'/';
        !is_dir($dirp) && @mkdir($dirp);

        //-----------------------------------------------------------------
        $filename = basename($_FILES['tfile']['name'],'jpg');
        $extname = substr(strrchr($_FILES['tfile']['name'], '.'), 1);
        if(empty($extname))$extname = "jpg";
        $target_path = $dirp . $filename.".".$extname;
        //-----------------------------------------------------------------
        if(move_uploaded_file($_FILES['tfile']['tmp_name'], $target_path)) {
            $refile = $target_path;
            $msg = " 上传成功";
        }  else{
            $msg = " error, please try again!" . $_FILES['tfile']['error'];
        }
        $this->data($refile);
        $this->msg($msg);
        //-----------------------------------------------------------------
        $this->J(200, 'succeed');
    }


    private function search_do($_f='J')
    {


        $se = array();
        //接收参数
//        "phaSampleNumber":"5",
//        "sampledate":"2015-02-12",
//        "startDate":"2015-01-11",
//        "endDate":"2015-02-28",

        $se['for'] = $_f;
        isset($_POST['SampleFormNumber'])    && $se['SampleFormNumber'] = (string)$_POST['SampleFormNumber'];      //抽样单号
//        isset($_POST['sampledate'])         && $sampledate     = $_POST['sampledate'];            //抽样日期
//        isset($_POST['startDate'])          && $startDate      = $_POST['startDate'];             //开始日期
//        isset($_POST['endDate'])            && $endDate        = $_POST['endDate'];               //终止日期
//
//        isset($_POST['sampleName'])         && $sampleName     = $_POST['sampleName'];             //检品名称
//        isset($_POST['sampleDepartment'])   && $sampleDepartment = $_POST['sampleDepartment'];     //被抽样单位
        isset($_POST['pageSize'])           && $pageSize       = $_POST['pageSize'];               //每次访问能够返回的最大数据量
        isset($_POST['page'])               && $page           = $_POST['page'];

        // $se = array();
//        isset($_POST['SampleFormNumber'])   && $se["SampleFormNumber"] = (string)$_POST['SampleFormNumber'];     //条件一 : 检验单号
        isset($_POST['sampleName'])         && $se['pharmaceuticalInforamation.pharmaceuticalName'] = $_POST['sampleName'];                 //条件二 : 药品名称

        isset($_POST['sampleDepartment'])   && $se['sampleDepartment.sampleDepartment'] = $_POST['sampleDepartment'];         //条件三 : 抽样单位

        $md["\$gte"] = $_POST['startDate'];
        $md["\$lte"] = $_POST['endDate'];
        ( isset($_POST['startDate']) && isset($_POST['endDate']) )  && $se["sampleDepartment.sampleDate"] = $md;      //"\$gt '{$_POST['startDate']}'";
        isset($_POST['sampledate'])    && $se["sampleDepartment.sampleDate"] = $_POST['sampledate'];

        // print_r($se);
        $start= ($page-1)*$pageSize;

        $fi["start"] =$start;
        $fi["limit"] =$pageSize;
        $fi["sort"] = array("sampleDepartment.sampleDate"=>-1);


        $rc = $this->mdb->find("dy_SampleForm", $se,$fi);
        // print_r($rc);
        $nrc  = array();
        foreach($rc as $key=>$value){
            $ou['SampleFormNumber'] = (string)$value['SampleFormNumber'];
            $ou['pharmaceuticalName'] = $value['pharmaceuticalInforamation']['pharmaceuticalName'];
            $ou['OnLine'] = (int)$value['OnLine'];
            $nrc[] = $ou;
        }


        return $nrc;
    }




    /*
    *  当天被抽样单位检索 [search/todaysearch]
     *
        模块 :检索模块中的当天被抽样单位检索
        说明 :此接口用于实现检索模块中的当天被抽样单位检索功能
        参数 :"simpledepartment":被抽样单位，"simpledate":抽样日期
        成功 :查询成功，"code"的值返回"200",同时"data"数组中携带查询到的抽样单表信息
        失败 :查询失败，"code"的值返回"509"。
         *
提交 :
{
"simpledepartment":"tianjinchouyang",
"simpledate":"2015-02-12"
}
    */
    public function todaysearch($sign = array())
    {
        !empty($sign) && $this->log['sign']    = $sign;        //方法中截取
        $this->log['mothod']    = __METHOD__;        //方法中截取
        $this->getpost($_POST);


    }

    /*
    *  抽样单位检索 [search/simpledepartment]
模块 :检索模块中的抽样单位检索
说明 :本接口能够实现检索模块中的抽样单位检索功能
参数 :"startDate":开始日期,"endDate":终止日期,"simpleName":检品名称
成功 :查询成功，"code"的返回值为200，并且在"data"数组中有返回的抽样单表信息
失败 :查询失败，"code"的返回值为510。     *
     *
提交 :

{
"startDate":"2015-01-11",
"endDate":"2015-02-28",
"simpleName":"wahaha"
}
    */



    /*
     * 测试
     * */
    public function test($sign=array())
    {
        $this->log['sign']    = $sign;        //方法中截取

        $m["12"] = "[\"1\",\"2\"]";

        echo json_encode($m);
        exit;
        //该用户已经存在
        //// $sql = "select count(*) from dy_user where user_login = '$username'";
        //// $count = $this->CI->S->Db->getone($sql);
//        $user['name'] = 'yangjun';
//        $user['pwd'] = 'yangjun';
//        //$this->CI->S->Mongodb->insert("table_user", $user);
//echo 'test2';
//        $params = $sign['params'];
//        print_r($params);
//array_shift($params);
//array_pop()
//array_push()
//array_unshift()
//array_shift()
        $this->ver = '123456789';
        echo($this->CI->S->ver);
        exit;
    }

    /**********************************************************************
    /**********************************************************************
    /**********************************************************************
    /**********************************************************************
    /**********************************************************************
    /**********************************************************************
    /**********************************************************************
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