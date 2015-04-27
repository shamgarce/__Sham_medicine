<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DEO extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('cookie');		//
		$this->S = new Seter();        //里面包含系列的单例对象
		$this->logininfo['username'] = 'admin';
		$this->logininfo['password'] = 'admin';
	}


	//是否登陆监测
	public function login_check(){
		if($_COOKIE['deo_admin'] == $this->logininfo['username']){
			//return true;
		}else{
			die('<a href="/DEO/LOGIN">sing in</a>');
		}
	}


	public function login_exc(){
		$username 		= $_POST['username'];
		$password 		= $_POST['password'];

		if($this->logininfo['username'] == $username && $this->logininfo['password'] == $password){
			$this->input->set_cookie("deo_admin",$username,86500);
			$res['code'] = 100;
			$res['msg'] = '登陆成功';
		}else{
			$res['code'] = -100;
			$res['msg'] = '登陆失败';
		}
		echo json_encode($res);
		exit;
	}

	public function login()
	{
		$this->load->view('DEO/DEO_login', $data);
	}


	public function index()
	{
		$this->login_check();
		//首页
		//===================================================================

$sql =  "select * from sy_user";
$rc = $this->S->db->getall($sql);



		$this->load->view('DEO/DEO_index', $data);
	}

	public function danhao($fistr,$page)
	{
		$this->login_check();

		//$page = intval($_GET['page']);
		$page = intval($page);
		if($page  == 0)$page = 1;
		$pageSize = 30;
		$start= ($page-1)*$pageSize;
		if($start <0)$start = 0;

		$fi["start"] =$start;
		$fi["limit"] =$pageSize;
		$fi["sort"] = array("odd_id"=>-1);

		//条件array()
		switch ($fistr)
		{
			case 'J':
				$fic = array('f'=>'J');
			break;
			case 'G':
				$fic = array('f'=>'G');
			break;
			default:
				$fistr = 'A';
				$fic = array();
			break;
		}

		//$_COOKIE['deo_qiyong']

		if($_COOKIE['deo_qiyong'] == 1){
			$fic['used'] = 1;
		}
		if($_COOKIE['deo_shangchuan'] == 1){
			$fic['up'] = 1;
		}


		$rc = $this->S->mdb->find("dy_typeoddid",$fic,$fi);

		//上一页 下一页计算
		$pre = $page - 1 ;
		$next = $page +1;
		if($pre <=0)$pre = 1;

		$data['pre'] = $pre;
		$data['next'] = $next;


		$data['page'] = $page;
		$data['fic'] = $fistr;


		$data['rc'] = $rc;
		$this->load->view('DEO/DEO_danhao', $data);
	}

	public function user()
	{
		$this->login_check();
		//====================================================

		//====================================================
		$rc = $this->S->mdb->find("dy_user",array());
//print_r($rc);
		//====================================================
		$data['rc'] = $rc;
		$this->load->view('DEO/DEO_user', $data);
	}



	//=========================================================
	//pop窗口
	public function guonei($danhao)
	{
		$this->login_check();
		$fi = array('SampleFormNumber'=>$danhao);
		$rc = $this->S->mdb->find("dy_zh_SampleForm",$fi);

		//dy_zh_SampleCondition
		$fi = array('odd_id'=>$danhao);
		$rc_con = $this->S->mdb->find("dy_zh_SampleCondition",$fi);

		//dy_zh_SampleDepartment
		$fi = array('odd_id'=>$danhao);
		$rc_dep = $this->S->mdb->find("dy_zh_SampleDepartment",$fi);


		$data['rc_dep'] = $rc_dep;		//单号
		$data['rc_con'] = $rc_con;		//单号
		$data['rc'] 	= $rc[0];		//结果集

		$data['danhao'] = $danhao;		//单号
		$this->load->view('DEO/DEO_guonei', $data);
	}

	//=========================================================
	//pop窗口
	public function guowai($danhao)
	{
		$this->login_check();
		$fi = array('SampleFormNumber'=>$danhao);
		$rc = $this->S->mdb->find("dy_SampleForm",$fi);

		//dy_zh_SampleCondition
		$fi = array('odd_id'=>$danhao);
		$rc_con = $this->S->mdb->find("dy_SampleCondition",$fi);

		//dy_zh_SampleDepartment
		$fi = array('odd_id'=>$danhao);
		$rc_dep = $this->S->mdb->find("dy_SampleDepartment",$fi);

		$data['rc_dep'] = $rc_dep;		//单号
		$data['rc_con'] = $rc_con;		//单号

		$data['danhao'] = $danhao;
		$data['rc'] 	= $rc[0];
		$this->load->view('DEO/DEO_guowai', $data);
	}

}




