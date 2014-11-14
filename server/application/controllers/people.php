<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class People extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('peopleAo','peopleAo');
		$this->load->model('loginAo','loginAo');
		$this->load->library('argv','argv');
    }
	public function search()
	{
		//检查登录态
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"];
		
		//检查输入参数		
		$result = $this->argv->getOptionInput(array('name','remark','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$dataWhere = $result["data"];
		
		$result = $this->argv->getRequireInput(array('pageIndex','pageSize'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$dataLimit = $result["data"];
			
		//执行业务逻辑
		$dataWhere["userId"] = $userId;
		$data = $this->peopleAo->search($dataWhere,$dataLimit);
		if( $data["code"] != 0 ){
			$this->load->view('json',$data);
			return;
		}
		
		$this->load->view('json',$data);
	}
	
	public function get(){
		//检查登录态
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"];
		
		//检查输入参数
		$result = $this->argv->getRequireInput(array('peopleId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$peopleId = $result["data"]['peopleId'];
		
		//执行业务逻辑
		$data = $this->peopleAo->get($peopleId);
		if( $data["code"] != 0 ){
			$this->load->view('json',$data);
			return;
		}
		
		if( $data["data"]->userId != $userId ){
			$this->load->view('json',array(
				'code'=>1,
				'msg'=>'你没有权限执行此操作',
				'data'=>''
			));
			return;
		}
		
		$this->load->view('json',$data);
	}
	
	public function mod(){
		//检查登录态
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"];
		
		//检查输入参数
		$result = $this->argv->postRequireInput(array('peopleId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$peopleId = $result["data"]['peopleId'];
		
		$result = $this->argv->postRequireInput(array('name','sex','birthday','remark','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$data = $result["data"];
		
		$result = $this->argv->postOptionInput(array('event','contact','relation'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$data2 = $result["data"];
		if( isset($data2['event'] ) == false )
			$data2['event'] = array();
		if( isset($data2['contact'] ) == false)
			$data2['contact'] = array();
		if( isset($data2['relation'] ) == false)
			$data2['relation'] = array();
		$data = array_merge($data,$data2);
		
		//执行业务逻辑
		$result = $this->peopleAo->get($peopleId);
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		if( $result['data']->userId != $userId ){
			$this->load->view('json',array(
				'code'=>1,
				'msg'=>'你没有权限执行此操作',
				'data'=>''
			));
			return;
		}
		
		$result = $this->peopleAo->mod( $peopleId,$data);
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$this->load->view('json',$result);
	}
	
	public function add(){
		//检查登录态
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"];
		
		//检查输入参数
		$result = $this->argv->postRequireInput(array('name','sex','birthday','remark','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$data = $result["data"];
		
		//执行业务逻辑
		$data['userId'] = $userId;
		$result = $this->peopleAo->add( $data);
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$this->load->view('json',$result);
	}
	
}

