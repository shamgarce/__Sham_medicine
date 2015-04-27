<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class test extends CI_Controller
{
	/**
	 * 通用过程 :
	 * 根据salt / timestamp / deviceid / signature / 判断是否合法的请求
	 * 根据salt / timestamp / openid 判断是否合法用户
	 */
	private $salt = 'ccab8f440ff0825e';
	private $db = NULL;

	function __construct()
	{
		parent::__construct();
		//连接数据库================================================
		!defined('MBASE') && define('MBASE', dirname(__FILE__) . "\\" . 'lib');    //v31 EASY的绝对路径
		include(MBASE . '\Mysql.class.php');
		$this->db = Mysql::getInstance();
		//连接数据库================================================
	}

	public function _remap($method, $params = array())
	{
		if($method == 'index') $this->jout(405);		//不可以调用的方法名
		//=============================================
		$ver = 'test';				//版本
		//$method = '';				//模块
		//$action = $params[0]		//方法

		//=========================================================
		$sign['salt'] 		= $this->salt;				//
		$sign['timestamp'] 	= $_GET['timestamp'];	//时间
		$sign['deviceid'] 	= $_GET['deviceid'];	//设备id
		$sign['openid'] 	= $_GET['openid'];		//设备id
		//$sign['actionid'] = $_GET['actionid'];	//动作id用来验证是否重复提交	//暂时不处理
		$sign['signature'] 	= $_GET['signature'];	//计算出来的签名比对 2014087451d28443c11e84107dfaae1f
		$sign['user'] 		= $_GET['ush'];			//ush //获取得到 再次获取则会更换
		$sign['sign'] 		= false;



		$mo = $ver.'/'.ucwords($method);				//如果数据库监测没通过,则载入默认处理的	R/S


		//=============================================
		$this->load->library($mo);				//载入模块






//		$array = $this->uri->uri_to_assoc(3);
//		$uri = $this->uri->assoc_to_uri($array);

		$array = $this->uri->uri_to_assoc(1);
		print_r($array);

		echo 'http://192.168.1.200/test/123/name/12/cate/12';
		echo '<br>';
		print_r($method);
		echo '<br>';
		print_r($params);
		$this->load->library('v1/Caroute');
		echo '<hr>';



		$this->caroute->run();






exit;

//		array_unshift($params,$method);		array_shift()
		if($method == 'index') $this->jout(405);		//不可以调用的方法名

		//=========================================================
		$sign['salt'] 		= $this->salt;				//
		$sign['timestamp'] 	= $_GET['timestamp'];	//时间
		$sign['deviceid'] 	= $_GET['deviceid'];	//设备id
		$sign['openid'] 	= $_GET['openid'];		//设备id
		//$sign['actionid'] = $_GET['actionid'];	//动作id用来验证是否重复提交	//暂时不处理
		$sign['signature'] 	= $_GET['signature'];	//计算出来的签名比对 2014087451d28443c11e84107dfaae1f
		$sign['user'] 		= $_GET['ush'];			//ush //获取得到 再次获取则会更换
		$sign['sign'] 		= false;

		//=========================================================
		//数据验证计算	http://m.so/v1/adduser/?timestamp=1422963025&deviceid=10052424&signature=2014087451d28443c11e84107dfaae1f
		(md5("{$sign['salt']}_{$sign['timestamp']}_{$sign['deviceid']}") == $_GET['signature']) && $sign['sign'] = true;
		($sign['timestamp']>time()+100*60 || $sign['timestamp'] < time()-100*60) 				&& $sign['sign'] = false;			//时间判断
		$sign['sign'] = false;


//这个地方要写成一个模块专门处理
//输入 参数字段
//输出映射


		//匹配模式
		$sql = "select * from userapi where enable = 1 AND  v = 'v1'";
		$rc = $this->db->getall($sql);
		foreach($rc as $key=>$value){
			$ar 	= explode('/',$value['api']);
			$___m 	= array_shift($ar);
			$___aj	= array_shift($ar);
			$___a 	= (substr($___aj, 0, 1) != ':')? empty($___aj)?'index':$___aj:'index';
			$map[$___m][$___a] = array($value['id'],$value['ys']);
		}

		//等待匹配的map

		$sign['method'] = $method;
		$sign['params'] = $params;
		//根据 mothod 和 params 进行路由,指向可运行的方法
		//加载子函数执行方法,传递参数
		$_mm = $method;
		$_aa = empty($params[0])?'index':$params[0];

		//$__aa转义
		if(!empty($map[$_mm]['index']))$_aa = 'index';
		$sign['ma'] = $_mm.'/'.$_aa;

		//根据映射值,获取真正要调用的方法
		$ys 		= $map[$_mm][$_aa][1];
		$sign['se'] = $map[$_mm][$_aa];

		if($ys) {					//如果调试模式，直接跳r/s
			$tid = $map[$_mm][$_aa][0];
			$sql = "select * from userapi where id = $tid";
			$rs = $this->db->getRow($sql);
			if($rs['debug'] == 1){
				if(empty($rs['response']))$rs['response'] = '{"code":200,"msg":"操作完成"}';
				$r = json_decode($rs['response']);
				$r->timestamp = time();
				$r->debugpath = 'v1';
				echo json_encode($r);	exit;
			}
			$sp 	= explode('/',$ys);
			$this->load->library('M/'.ucwords($sp[0]),$params);
			$this->$sp[0]->$sp[1]($sign);							//把头部签名文件传递进去
		}else{
			//
			$this->jout(200,'designing api closed');
		}
		//===============================================================
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */