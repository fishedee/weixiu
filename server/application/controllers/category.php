<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('categoryDb','categoryDb');
		$this->load->model('loginAo','loginAo');
		$this->load->library('argv','argv');
    }
	public function search()
	{
		//����¼̬
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"];
		
		//����������		
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
			
		//ִ��ҵ���߼�
		$dataWhere["userId"] = $userId;
		$data = $this->categoryDb->search($dataWhere,$dataLimit);
		if( $data["code"] != 0 ){
			$this->load->view('json',$data);
			return;
		}
		
		$dataCount = $this->categoryDb->count($dataWhere);
		if( $dataCount["code"] != 0 ){
			$this->load->view('json',$dataCount);
			return;
		}
		
		$result = array(
			"code"=>0,
			"msg"=>"",
			"data"=>array(
				"count"=>$dataCount["data"],
				"data"=>$data["data"]
			)
		);
		$this->load->view('json',$result);
	}
	
	public function getAll()
	{
		//����¼̬
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"];
		
		//ִ��ҵ���߼�
		$data = $this->categoryDb->getValidByUser(
			$userId
		);
		$this->load->view('json',$data);
	}
	
	
	public function get()
	{
		//����¼̬
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"];
		
		//����������
		$result = $this->argv->getRequireInput(array('categoryId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$categoryId = $result["data"]["categoryId"];
		
		//ִ��ҵ���߼�
		$data = $this->categoryDb->getByIdAndUser(
			$categoryId,
			$userId
		);
		$this->load->view('json',$data);
	}
	
	public function add()
	{
		//����¼̬
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"];
		
		//����������
		$result = $this->argv->postRequireInput(array('name','remark','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//ִ��ҵ���߼�
		$data["userId"] = $userId;
		$data = $this->categoryDb->add(
			$data
		);
		$this->load->view('json',$data);
	}
	
	public function mod()
	{
		//����¼̬
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"];
		
		//����������
		$result = $this->argv->postRequireInput(array('categoryId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$categoryId = $result["data"]["categoryId"];
		
		$result = $this->argv->postRequireInput(array('name','remark','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//ִ��ҵ���߼�
		$data = $this->categoryDb->modByIdAndUser(
			$categoryId,
			$userId,
			$data
		);
		$this->load->view('json',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
