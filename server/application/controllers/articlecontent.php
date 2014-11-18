<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ArticleContent extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('articleContentDb','articleContentDb');
		$this->load->model('loginAo','loginAo');
		$this->load->library('argv','argv');
    }
	
	public function search()
	{
		//检查权限
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//检查输入参数
		$result = $this->argv->getOptionInput(array('articleId','state'));
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
		$data = $this->articleContentDb->search(
			$dataWhere,$dataLimit
		);
		$this->load->view('json',$data);
	}
	
	public function get()
	{
		//检查权限
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//检查输入参数
		$result = $this->argv->getRequireInput(array('articleContentId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$articleContentId = $result["data"]["articleContentId"];
		
		//执行业务逻辑
		$data = $this->articleContentDb->get(
			$articleContentId
		);
		$this->load->view('json',$data);
	}
	
	public function add()
	{
		//检查权限
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//检查输入参数
		$result = $this->argv->postRequireInput(array('articleId','type','data','weight'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//执行业务逻辑
		$data = $this->articleContentDb->add(
			$data
		);
		$this->load->view('json',$data);
	}
	
	public function mod()
	{
		//检查权限
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//检查输入参数
		$result = $this->argv->postRequireInput(array('articleContentId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$articleContentId = $result["data"]["articleContentId"];
		
		$result = $this->argv->postRequireInput(array('type','data','weight','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//执行业务逻辑
		$data = $this->articleContentDb->mod(
			$articleContentId,
			$data
		);
		$this->load->view('json',$data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
