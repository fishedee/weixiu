<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('accountAo','accountAo');
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
		$result = $this->argv->getOptionInput(array('name','remark','type','state','categoryId','money'));
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
		$data = $this->accountAo->search($dataWhere,$dataLimit);
		if( $data["code"] != 0 ){
			$this->load->view('json',$data);
			return;
		}
		
		$dataCount = $this->accountAo->count($dataWhere);
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
		$result = $this->argv->getRequireInput(array('accountId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$accountId = $result["data"]["accountId"];
		
		//ִ��ҵ���߼�
		$data = $this->accountAo->getByIdAndUser(
			$accountId,
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
		$result = $this->argv->postRequireInput(array('name','remark','type','state','categoryId','money'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//ִ��ҵ���߼�
		$data["userId"] = $userId;
		$data = $this->accountAo->add(
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
		$result = $this->argv->postRequireInput(array('accountId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$accountId = $result["data"]["accountId"];
		
		$result = $this->argv->postRequireInput(array('name','remark','type','state','categoryId','money'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//ִ��ҵ���߼�
		$data = $this->accountAo->modByIdAndUser(
			$accountId,
			$userId,
			$data
		);
		$this->load->view('json',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
