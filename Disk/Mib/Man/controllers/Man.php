<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Man extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 * Maps to the following URL
	 *        http://example.com/index.php/welcome
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
	{
		parent::__construct();
		//连接数据库================================================两种方式都可以
//		include(FCPATH.APPPATH.'libraries\Db.php');
//		$this->db = Db::getInstance();
		//连接数据库================================================
		$this->S = new Set();

		$this->load->library('Db');			//数据库
	}

	public function r($id)
	{
		//根据id读取信息返回
		$sql = "select `response` from userapi where id = $id";
		$res= $this->db->getone($sql);
		$res = str_replace(" ","",$res);
		$res = str_replace("\n","",$res);
		$res = str_replace("\r","",$res);
		echo $res;
		exit;
	}

	//自动生成接口文档
	public function doc($ver = 0,$mm=0)
	{
		$sql = !empty($ver)?" v= '$ver'":" 1";
		$sql .= !empty($mm)?" and (`api` like '$mm%')":"";

		$sql = "select * from userapi where $sql order by sort desc";
		$rc = $this->db->getall($sql);

		foreach($rc as $key=>$value){
			$apis = explode('/',$value['api']);
			$ma[$apis[0]][$apis[1]] = 1;
		}

		$data['msg'] 	= "默认m";
		$data['rc'] 	= $rc;
		$data['ver'] 	= $ver;
		$data['mm'] 	= $mm;
		$data['ma'] 	= $ma;

		$this->load->view('Man/Man_doc',$data);
	}



	public function Docviewlog()
	{
		$rout = Set::getarr($_GET['re'],0,"/");
		$rout[0] 	= (substr($rout[0], 0, 1) != ':')? empty($rout[0])?'index':$rout[0]:'index';

		$rout[0] 	= ucfirst($rout[0]);
		$rout[1] 	= (substr($rout[1], 0, 1) != ':')? empty($rout[1])?'index':$rout[1]:'index';
		$ar['mothod'] = "{$rout[0]}::{$rout[1]}";
		$ar['mothod'] = str_replace('R::s','R::__call',$ar['mothod']);


		$log = $this->S->mdb->find("dy_log",$ar,array("sort"=>array("time.timecu"=>-1),"limit"=>5));
		foreach($log as $key=>$value){
			$log[$key]['time']['timecu'] = date('Y-m-d H:i:s', $log[$key]['time']['timecu']);
			!empty($log[$key]['_GET']) && $log[$key]['_GET'] = json_encode($log[$key]['_GET']);
			!empty($log[$key]['_POST']) && $log[$key]['_POST'] = json_encode($log[$key]['_POST']);
			!empty($log[$key]['sign']) && $log[$key]['sign'] = json_encode($log[$key]['sign']);
		}

		//检索日志并且显示
		$data['log'] = $log;
		$this->load->view('Man/Man_Docviewlog',$data);
	}
	//单个查看接口详细
	public function Docview($num = 0)
	{
		$sql = "select * from userapi where id = $num";
		$data['row'] = $this->db->getrow($sql);
		$data['id'] = $num;
		$this->load->view('Man/Man_docview',$data);
	}

	//主要的管理界面
	public function index($ver = 0,$mm=0)
	{

		$sql = !empty($ver)?" v= '$ver'":" 1";
		$sql .= !empty($mm)?" and (`api` like '$mm%')":"";
		$sql = "select * from userapi where $sql order by sort desc";

		$rc = $this->S->db->getall($sql);

		foreach($rc as $key=>$value){
			$apis = explode('/',$value['api']);
			$ma[$apis[0]][$apis[1]] = 1;
		}

		$data['ver'] 	= $ver;
		$data['mm'] 	= $mm;
		$data['ma'] 	= $ma;

		$data['msg'] = "默认m";
		$data['rc'] = $rc;

		$this->load->view('Man/Man_index',$data);
	}




	//添加新的接口
	public function addnew()
	{
		//==========================================================
		$this->load->view('Man/Man_addnew',$data);
	}



	//编辑接口
	public function edit($id)
	{
		//对该ID进行编辑
		$data['row'] = $this->db->getrow("select * from userapi where id = $id");
		//==========================================================
		$this->load->view('Man/Man_edit',$data);
	}
	//编辑接口操作
	public function edit_exec()
	{

		//$rc['id'] = $_POST['id'];
		$rc['v']		= $_POST['v'];
		$rc['api']		= $_POST['api'];
		$rc['ys'] 		= $_POST['ys'];
		$rc['dis'] 		= $_POST['dis'];

		$rc['name'] 	= $_POST['name'];
		$rc['sort'] 	= $_POST['sort'];

		$rc['request'] 	= $_POST['request'];
		$rc['response'] = $_POST['response'];
//		$rc['request'] 	= stripslashes($_POST['request']);
//		$rc['response'] = stripslashes($_POST['response']);
//		$rc['request'] = str_replace("'","\"",$rc['request']);
//		$rc['response'] = str_replace("'","\"",$rc['response']);
		$rc['request'] 	= addslashes($rc['request']);
		$rc['response'] = addslashes($rc['response']);

		$rc['enable'] 	= $_POST['enable']==1?true:false;
		$rc['debug'] 	= $_POST['debug']==1?true:false;
		$this->db->autoExecute('userapi',$rc,'UPDATE',"ID = {$_POST['id']}");
		$res['code'] = 200;
		$res['msg'] ='完成';
		echo json_encode($res);

	}


	public function changedebug($id,$rel)
	{
		$rc['debug'] = $rel;
		$this->db->autoExecute('userapi',$rc,'UPDATE',"ID = $id");
		$res['code'] = 200;
		$res['msg'] ='完成';
		echo json_encode($res);
		//==========================================================
	}


	//获得api接口示例代码
	public function apicode()
	{
		echo 'no';
		//==========================================================
		$this->load->view('Man/Man_code',$data);
	}

	//添加操作的执行
	public function addnew_exc()
	{

		$rc['v']  	= $_POST['addnew_v'];
		$rc['api']  = $_POST['addnew_api'];
		$rc['ys'] 	= $_POST['addnew_ys'];
		$rc['dis'] = $_POST['addnew_dis'];
		$rc['enable'] 	= $_POST['enable'];
		$rc['debug'] 	= $_POST['debug'];

		$rc['name']  = $_POST['addnew_ypiname'];

		$rc['request'] 	= stripslashes($_POST['addnew_apirequest']);
		$rc['response'] = stripslashes($_POST['addnew_apiresponse']);
		$rc['request'] = str_replace("'","\"",$rc['request']);
		$rc['response'] = str_replace("'","\"",$rc['response']);
		$rc['request'] 	= addslashes($rc['request']);
		$rc['response'] = addslashes($rc['response']);


		$this->db->autoExecute('userapi',$rc,'INSERT');
		$res['code'] = 200;
		$res['msg'] ='完成';
		echo json_encode($res);

	}

	//=============================================================
	//模块管理界面
	//=============================================================
	public function model()
	{
		$rc = $this->db->getall("select m from user_model order by m");
		//==========================================================
		$data['rc'] = $rc;
		$this->load->view('Man/Man_model',$data);
	}

	//添加模块 - 执行
	public function Model_add_exe()
	{
		$rc['v'] = $_POST['model_v'];
		$rc['m'] = $_POST['model_m'];
		$rc['a'] = $_POST['model_a'];

		$this->db->autoExecute('user_model',$rc,'INSERT');
		$res['code'] = 200;
		$res['msg'] ='完成';
		echo json_encode($res);
	}

	//添加模块
	public function model_add()
	{
		$this->load->view('Man/Man_model_add');
	}


	public function Model_del_exc()
	{
		$id = $_POST['id'];
		$this->db->query("delete from user_model where id = $id");

		$res['code'] = 200;
		$res['msg'] ='完成';
		echo json_encode($res);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

