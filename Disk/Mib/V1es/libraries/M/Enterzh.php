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

class Enterzh
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
     * 国内功能
     * 1 : 上传         uploading_inland
     * 2 : 单号检索     simplenumber
     * 3 : 综合检索     search_gn
     * */


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

        //$phaForm = $phaForm['pharmaceuticalForm'];
        $phaForm['SampleFormNumber'] = (string)($phaForm['SampleFormNumber']);
       // $phaForm['for'] = substr($phaForm['SampleFormNumber'],0,1);
        $odd_id = $phaForm['SampleFormNumber'];

//        print_r($phaForm);
//        exit;

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
        $simpleConditionList = $phaForm['inLandSampleCondition']['sampleConditionList'];
        $simpleDepartmentList = $phaForm['inLandEnforcementUnitSign']['sampleDepartmentList'];

        unset($phaForm['inLandSampleCondition']['sampleConditionList']);
        unset($phaForm['inLandEnforcementUnitSign']['sampleDepartmentList']);

        $this->mdb->insert('dy_zh_SampleForm', $phaForm);        //主记录

        foreach ($simpleConditionList as $key => $value) {
            unset($me);
            $me['odd_id'] = $odd_id;
            $me = array_merge($me, $value);
            $this->mdb->insert('dy_zh_SampleCondition', $me);
        }

        foreach ($simpleDepartmentList as $key => $value) {
            unset($me);
            $me['odd_id'] = $odd_id;
            $me = array_merge($me, $value);
            $this->mdb->insert('dy_zh_SampleDepartment', $me);
        }

        //上传完毕,更改状态
        // print_r($row);
//        $this->mdb->update("test_table", array("id"=>1),array("id"=>1,"title"=>"bbb"));
        $row['up'] = 1;
        $this->mdb->update("dy_typeoddid", array("odd_id" => $row['odd_id']), $row);

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
    public function simplenumber_zh($sign = array())
    {
        //-----------------------------------------------------------------
        $this->sign = $sign;
        !empty($sign) && $this->log['sign']    = $sign;        //方法中截取
        $this->log['mothod']    = __METHOD__;        //方法中截取
        //-----------------------------------------------------------------

        $oddid =  (string)$_POST['SampleFormNumber'];
//echo $oddid;
        $row = $this->mdb->findone("dy_zh_SampleForm", array("SampleFormNumber"=>$oddid));
if(empty($row)) $this->J(508, 'error');

        $row['inLandSampleCondition']['sampleConditionList']        = $this->mdb->find("dy_zh_SampleCondition", array("odd_id"=>$oddid));
        $row['inLandEnforcementUnitSign']['sampleDepartmentList']   = $this->mdb->find("dy_zh_SampleDepartment", array("odd_id"=>$oddid));



        $this->getpost($row);
        $this->data($row);
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


        $se = array();
        //接收参数
//        "phaSampleNumber":"5",
//        "sampledate":"2015-02-12",
//        "startDate":"2015-01-11",
//        "endDate":"2015-02-28",

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
        isset($_POST['sampleName'])         && $se['inLandPhaInformation.phaName'] = $_POST['sampleName'];                 //条件二 : 药品名称
        isset($_POST['sampledDepartment'])   && $se['inLandSuperviseOffereeSign.sampledDepartment'] = $_POST['sampledDepartment'];         //条件三 : 抽样单位

        $md["\$gte"] = $_POST['startDate'];
        $md["\$lte"] = $_POST['endDate'];
        ( isset($_POST['startDate']) && isset($_POST['endDate']) )  && $se["inLandEnforcementUnitSign.sampleDate"] = $md;      //"\$gt '{$_POST['startDate']}'";
        isset($_POST['sampledate'])    && $se["inLandEnforcementUnitSign.sampleDate"] = $_POST['sampledate'];


        $start= ($page-1)*$pageSize;

        $fi["start"] =$start;
        $fi["limit"] =$pageSize;
        $fi["sort"] = array("inLandEnforcementUnitSign.sampleDate"=>-1);

       // print_r($se);
        $rc = $this->mdb->find("dy_zh_SampleForm", $se,$fi);
        // print_r($rc);
        $nrc  = array();
        foreach($rc as $key=>$value){
            $ou['SampleFormNumber'] = (string)$value['SampleFormNumber'];
            $ou['pharmaceuticalName'] = $value['inLandPhaInformation']['phaName'];
            $ou['OnLine'] = (int)$value['OnLine'];
            $nrc[] = $ou;
        }


        $this->data($nrc);
        $this->J(200, 'succeed');
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
        $this->de['ExecuteModel']  = 'Enterzh';
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