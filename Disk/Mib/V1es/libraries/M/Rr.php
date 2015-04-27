<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//这个是测试组件
class Rr
{
	//--
	private $route = array();
	private $db = null;
	private $params = array();
	public function __construct($params)
	{
		$this->params = $params;
		$CI =& get_instance();
		//$CI->load->library('Db');
	}

	public function Ss($sign=array())
	{
		$params = $sign['params'];
		print_r($params);
//array_shift($params);
//array_pop()
//array_push()
//array_unshift()
//array_shift()
	}

	public function __call($name,$arguments) {
		echo $name;
		print_r($arguments);
		exit;
		//查看在数据库中的映射,并且判断是否返回调试数据
	}

}