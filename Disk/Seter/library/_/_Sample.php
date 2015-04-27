<?php
/*示例
*/
class Sample{

    private $CI = null;
    public static $instance;

    public function __construct(){
        $this->CI =& get_instance();
    }

    //user add
    public function user_add($mc){
        if(empty($mc['user_login']) || empty($mc['user_password'])) return false;
        $mc['f_regtime']    = time();
        $mc['enable']       = 1;
        $this->CI->S->Mdb->insert('dy_user',array_merge(static::table_dy_user(), $mc));
        return true;
    }

    //添加检验单号
    public function typeoddid_add($mc){
        if(empty($mc['odd_id']))            return false;
        $mc['type_id']  = 1;
        $mc['enable']   = 1;
        $mc['odd_id']   = is_int($mc['odd_id']) ?$mc['odd_id']  : intval($mc['odd_id']);
        isset($mc['used'])  && $mc['used']  = is_int($mc['used'])   ?$mc['used']    : intval($mc['used']);
        isset($mc['up'])    && $mc['up']    = is_int($mc['up'])     ?$mc['up']      : intval($mc['up']);
        $this->CI->S->Mdb->insert('dy_typeoddid',array_merge(static::table_dy_typeoddid(), $mc));
        return true;
    }

    //typeoddid add
    public function SampleForm_add($mc){
        if(empty($mc['SampleFormNumber']))            return false;
        $mc['OnLine']           = $mc['OnLine']=="true"?1:0;
        $mc['SampleFormNumber'] = intval($mc['SampleFormNumber']);
        $mc['labelCheck']['lotNumber']          = ($mc['labelCheck']['lotNumber'] == 'true')?1:0;
        $mc['labelCheck']['number']             = ($mc['labelCheck']['number'] == 'true')?1:0;
        $mc['labelCheck']['packageGuiGe']       = ($mc['labelCheck']['packageGuiGe'] == 'true')?1:0;
        $mc['labelCheck']['pharmaceuticalName'] = ($mc['labelCheck']['pharmaceuticalName'] == 'true')?1:0;
        $mc['labelCheck']['productDepartment']  = ($mc['labelCheck']['productDepartment'] == 'true')?1:0;
        $mc['labelCheck']['registerNumber']     = ($mc['labelCheck']['registerNumber'] == 'true')?1:0;
        $mc['labelCheck']['specification']      = ($mc['labelCheck']['specification'] == 'true')?1:0;
        $mc['labelCheck']['unitsNumber']        = ($mc['labelCheck']['unitsNumber'] == 'true')?1:0;
        $mc['labelCheck']['validityPeriod']     = ($mc['labelCheck']['validityPeriod'] == 'true')?1:0;
        $mc['enable']   =   1;
        $mc['putime']   =   time();
        $mc['openid']   =   1;

        unset($mc['sampleCondition']['simpleConditionList']);
        unset($mc['simpleDepartment']['simpleDepartmentList']);

        $this->CI->S->Mdb->insert('dy_SampleForm',$mc);
        return true;
    }

    //SampleForm add
    public function SampleCondtion_add($mc){
        $this->CI->S->Mdb->insert('wwwwww',array_merge(static::table_dy_user(), $mc));
    }

    //SampleCondition add
    public function SampleDepartment_add($mc){
        $this->CI->S->Mdb->insert('wwwwwwwwww',array_merge(static::table_dy_user(), $mc));
    }

    //===========================================================================
    //===========================================================================
    //===========================================================================
    //===========================================================================
    //===========================================================================
    //===========================================================================
    //===========================================================================
    //===========================================================================
    //===========================================================================
    //===========================================================================
    //初始化的数据 使用方法   array_merge(static::table_dy_user(), $userSettings);

    public static function table_dy_user(){
        return array(
            "user_login"    => "",          //用户名
            "user_password" => "",          //密码
            "user_name"     => "",
            "user_tel"      => "",
            "device_id"     => "",
            "open_id"       => "",
            "f_logintime"   => "",
            "f_loginip"     => "",
            "f_regtime"     => 0,          //注册时间
            "enable"        => 1            //是否有效
        );
    }

    public static function table_dy_typeoddid(){
        return array(
            "type_id"       => 1,          //检验单id
            "odd_id"        => 0,          //单号
            "openid"        => "",         //客户端id
            "used"          => 0,           //是否已经占用
            "device_id"     => "",          //设备id
            "up"            => 0,           //是否已经上传
            "enable"        => 1            //是否有效
        );
    }


}

