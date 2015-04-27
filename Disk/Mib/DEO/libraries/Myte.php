<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *详细地址 http://codeigniter.org.cn/user_guide/general/creating_libraries.html
 *
    你可以创建全新的类库.
    你可以扩展原始类库.
    你可以替换原始类库.
    你的类库文件必须保存在 application/libraries 文件夹,CodeIgniter将在这个文件夹中寻找并初始化它们.
    文件名首字母大写. 例如:  Myclass.php
    类声明首字母大写. 例如:  class Myclass
    类的名字和文件名应相同.
    $params = array('type' => 'large', 'color' => 'red');
    $this->load->library('Someclass', $params);
    $this->load->helper('url');
    $this->load->library('session');
    $this->config->item('base_url');
    $CI =& get_instance();
    一旦定义某个对象为一个变量,你就可以使用那个变量名 取代 $this:
    $CI =& get_instance();
    $CI->load->helper('url');
    $CI->load->library('session');
    $CI->config->item('base_url');

好了,尽情发挥吧

 *
 * 		$this->load->library('myte');
		$this->myte->run();
 * */

class Myte
{
    //--
    //private $route = array();

    public function __construct($params)
    {
        print_r($params);
    }

    public function run()
    {
//        $CI =& get_instance();
//        $CI->load->helper('url');
//        $CI->load->library('encrypt');			//http://codeigniter.org.cn/user_guide/libraries/encryption.html

       // echo 555;
        //echo '2222222';
        //先决条件
        //v = v1
        //$method,$params 两个参数
        //====================================================
        /*
         * 任务,完成有效性判定,自动载入文件进行运算,输出json
         * */
    }

}