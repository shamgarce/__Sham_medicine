<?php
/**
 * 添加数据
 * $mongo->insert("test_table", array("id"=>2, "title"=>"asdqw"));
 * 更新记录
 * $mongo->update("test_table", array("id"=>1),array("id"=>1,"title"=>"bbb"));
 * 更新记录-存在时更新，不存在时添加-相当于set
 * $mongo->update("test_table", array("id"=>1),array("id"=>1,"title"=>"bbb"),array("upsert"=>1));
 * 查找记录
 * $mongo->find("c", array("title"=>"asdqw"), array("start"=>2,"limit"=>2,"sort"=>array("id"=>1)))
 * 查找一条记录
 * $mongo->findOne("$mongo->findOne("ttt", array("id"=>1))", array("id"=>1));
 * 删除记录
 * $mongo->remove("ttt", array("title"=>"bbb"));
 * 仅删除一条记录
 * $mongo->remove("ttt", array("title"=>"bbb"), array("justOne"=>1));
 * //集成这些操作,并且集成操作前的数据初始化
 *
 * 经过的数据 检查和类型转换
 * //insert / update / find
 */
class V1db
{
    public $data = array();
    public function __construct()
    {
        //$this->CI =& get_instance();
    }

    //初始化的数据 使用方法   array_merge(static::table_dy_user(), $userSettings);
    public static function table_dy_user(){
        return array(
            "user_login"    => "",          //用户名
            "user_password" => "",          //密码
            "user_name"     => "",
            "user_tel"      => "",
            "device_id"     => "",
            "open_id"       => "",
            "f_logintime"   => 0,
            "f_loginip"     => "",
            "f_regtime"     => "",          //注册时间
            "enable"        => 1            //是否有效
        );
    }

    public static function table_dy_typeoddid(){
        return array(
            "type_id"    => 1,          //检验单id
            "odd_id"    => 0,          //单号
            "openid"     => "",         //客户端id
            "used"      => 0,           //是否已经占用
            "device_id" => "",          //设备id
            "up"        => 0,           //是否已经上传
            "enable"    => 1            //是否有效
        );
    }









}
