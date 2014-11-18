<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('templateDb','templateDb');
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
		$result = $this->argv->getOptionInput(array('name','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$dataWhere = $result["data"];
		
		$result = $this->argv->getOptionInput(array('pageIndex','pageSize'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$dataLimit = $result["data"];
			
		//执行业务逻辑
		$data = $this->templateDb->search($dataWhere,$dataLimit);
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
		$result = $this->argv->getRequireInput(array('templateId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$templateId = $result["data"]["templateId"];
		
		//执行业务逻辑
		$data = $this->templateDb->get(
			$templateId
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
		$result = $this->argv->postRequireInput(array('name','url','remark','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//执行业务逻辑
		$data = $this->templateDb->add(
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
		$result = $this->argv->postRequireInput(array('templateId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$templateId = $result["data"]["templateId"];
		
		$result = $this->argv->postRequireInput(array('name','url','remark','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//执行业务逻辑
		$data = $this->templateDb->mod(
			$templateId,
			$data
		);
		$this->load->view('json',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
