<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//初始测试组件
class R
{
	//--
	private $tmp = array();
	private $params = array();
	private $CI = null;
	private $de = array();
	private $log = array();

	public function __construct($params)
	{
		$this->params = $params;
		$this->CI =& get_instance();
		$this->tmp['timestamp_'] = Set::T();        //$sign //参数是签名
		//======================================================================
		!empty($params) && $this->log['params']    = $params;              //log
		$this->log['time']['timecu'] = time();;        //log
		$this->log['time']['timebe'] = $this->tmp['timestamp_'];        //log
		$this->log['class']     = __class__;        //log
		//======================================================================
	}

	public function __call($name,$arguments) {
		!empty($sign) && $this->log['sign']    = $sign;        //方法中截取
		$this->log['mothod']    = __METHOD__;        //方法中截取
		//在这里
		$id = $arguments[0]['dbid'];
		$sql = "select response from userapi where id = $id";
		$rs = $this->db->getone($sql);
		if(empty($rs))$rs = '{"code":200,"msg":"操作完成r/s"}';
		$rs = json_decode($rs);
		if(is_object($rs)){

			$code 	= $rs->code;
			$msg 	= $rs->msg;
			$data 	= $rs->data;
		}
		if(is_array($rs)){
			$code 	= $rs['code'];
			$msg 	= $rs['msg'];
			$data 	= $rs['data'];
		}
		$this->data($data);
		$this->J($code,$msg);
		exit;
		//查看在数据库中的映射,并且判断是否返回调试数据
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
	 *
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
	private function code($code = '')
	{
		$code = intval($code);
		$this->de['code'] = $code;
	}
	public function D($code = 0, $data)
	{
		$code = intval($code);
		if (!empty($code)) $this->de['code'] = $code;
		$this->de['data'] = $data;
		$this->de['ExecuteTime'] = Set::T() - $this->tmp['timestamp_'];
		$this->de['ExecuteModel'] = 'Enter';
		$this->logmon->L($code,$this->de['msg'],$this->log);
		echo json_encode($this->de);
		exit;
	}

	public function J($code=0,$msg='')
	{
		$code = intval($code);
		if(!empty($code))  $this->de['code'] = $code;
		if(!empty($msg))   $this->de['msg']  = $msg;
		$this->de['ExecuteTime'] = Set::T() - $this->tmp['timestamp_'];
		$this->de['ExecuteModel']  = 'Enter';
		$this->logmon->L($code,$msg,$this->log);
		echo json_encode($this->de);
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