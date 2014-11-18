<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('userDb','userDb');
		$this->load->model('loginAo','loginAo');
		$this->load->library('argv','argv');
    }
	private function _checkAdmin(){
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 )
			return $result;
		
		$userId = $result["data"];
		$result = $this->userDb->get($userId);
		if( $result["code"] != 0 )
			return $result;
			
		if( $result["data"]['type'] != $this->userDb->TYPE_ADMIN )
			return array(
				"code"=>1,
				"msg"=>"你没有权限执行此操作",
				"data"=>""
			);
		
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$userId
		);
	}
	
	public function search()
	{
		//检查权限
		$result = $this->_checkAdmin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//检查输入参数		
		$result = $this->argv->getOptionInput(array('name','type','state'));
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
		$data = $this->userDb->search($dataWhere,$dataLimit);
		if( $data["code"] != 0 ){
			$this->load->view('json',$data);
			return;
		}
		
		$this->load->view('json',$data);
	}
	
	public function get()
	{
		//检查权限
		$result = $this->_checkAdmin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//检查输入参数
		$result = $this->argv->getRequireInput(array('userId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"]["userId"];
		
		//执行业务逻辑
		$data = $this->userDb->get(
			$userId
		);
		$this->load->view('json',$data);
	}
	
	public function add()
	{
		//检查权限
		$result = $this->_checkAdmin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//检查输入参数
		$result = $this->argv->postRequireInput(array('name','password','type','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//执行业务逻辑
		$userResult = $this->userDb->getByName($data['name']);
		if( $userResult["code"] != 0 ){
			$this->load->view('json',$userResult);
			return $result;
		}
		
		if( count($userResult["data"]) != 0 ){
			$this->load->view('json',array(
				"code"=>1,
				"msg"=>"重复的用户名",
				"data"=>""
			));
			return $userResult;
		}
			
		$data['password'] = sha1($data['password']);
		$data = $this->userDb->add(
			$data
		);
		$this->load->view('json',$data);
	}
	
	public function mod()
	{
		//检查权限
		$result = $this->_checkAdmin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//检查输入参数
		$result = $this->argv->postRequireInput(array('userId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"]["userId"];
		
		$result = $this->argv->postRequireInput(array('type','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//执行业务逻辑
		$data = $this->userDb->mod(
			$userId,
			$data
		);
		$this->load->view('json',$data);
	}
	
	public function modPassword()
	{
		//检查权限
		$result = $this->_checkAdmin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//检查输入参数
		$result = $this->argv->postRequireInput(array('userId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"]["userId"];
		
		$result = $this->argv->postRequireInput(array('password'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$password = $result["data"]["password"];
		
		//执行业务逻辑
		$password = sha1($password);
		$data = $this->userDb->mod(
			$userId,
			array("password"=>$password)
		);
		$this->load->view('json',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
