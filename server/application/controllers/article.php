<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('articleAo','articleAo');
		$this->load->model('articleDb','articleDb');
		$this->load->model('templateDb','templateDb');
		$this->load->model('loginAo','loginAo');
		$this->load->library('argv','argv');
    }
	
	public function go(){
		//检查输入参数		
		$result = $this->argv->getOptionInput(array('articleId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$articleId = $result["data"]['articleId'];
		
		//业务逻辑
		$result = $this->articleDb->get($articleId);
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$article = $result['data'];
		
		$result = $this->templateDb->get($article['templateId']);
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$templateUrl = $result['data']['url'];
		
		require_once(dirname(__FILE__).'/../../../static/public/'.$templateUrl);
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
		$result = $this->argv->getOptionInput(array('title','templateId','state'));
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
		$data = $this->articleAo->search($dataWhere,$dataLimit);
		if( $data["code"] != 0 ){
			$this->load->view('json',$data);
			return;
		}
		
		$this->load->view('json',$data);
	}
	
	public function get()
	{
		//检查权限
		/*
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		*/
		
		//检查输入参数
		$result = $this->argv->getRequireInput(array('articleId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$articleId = $result["data"]["articleId"];
		
		//执行业务逻辑
		$result = $this->articleAo->get(
			$articleId
		);
		$this->load->view('json',$result);
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
		$result = $this->argv->postRequireInput(array('title','templateId','remark','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//执行业务逻辑
		$result = $this->articleAo->add(
			$data
		);
		$this->load->view('json',$result);
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
		$result = $this->argv->postRequireInput(array('articleId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$articleId = $result["data"]["articleId"];
		
		$result = $this->argv->postRequireInput(array('title','templateId','remark','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		$result = $this->argv->postDefaultInput(array('content'),array());
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = array_merge($data,$result["data"]);
		
		//执行业务逻辑
		$result = $this->articleAo->mod(
			$articleId,
			$data
		);
		$this->load->view('json',$result);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
