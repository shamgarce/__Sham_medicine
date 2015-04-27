<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class V1es extends CI_Controller
{

	private	$params = array();
	public 	$S 	= NULL;

	function __construct()
	{
		parent::__construct();
		//=========================================================
		//加载Seter组件
		include FCPATH.'Seter/Config.php';
		$this->S = new Seter();
		//=========================================================
		//=========================================================
	}



	//=========================================================
	//登陆
	function index()
	{
//		$data['log'] = $log;
		$this->load->view('V1se/index',$data);
	}

	function user()
	{
		//echo '用户管理';
		$this->load->view('V1se/user',$data);
	}

	function danhao()
	{
		$this->load->view('V1se/danhao',$data);
	}

	function guonei()
	{
		$this->load->view('V1se/guonei',$data);
	}

	function guowai()
	{
		$this->load->view('V1se/guowai',$data);
	}

	function login_exc()
	{
		$rs['code'] = 200;
		$rs['msg'] = 'dengchu';
		echo json_encode($rs);
	}

	function login()
	{
		$this->load->view('V1se/login',$data);
	}




}


