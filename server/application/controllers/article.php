<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('articleDb','articleDb');
		$this->load->model('loginAo','loginAo');
		$this->load->library('argv','argv');
    }
	
	public function search()
	{
		//���Ȩ��
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//����������		
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
			
		//ִ��ҵ���߼�
		$data = $this->articleDb->search($dataWhere,$dataLimit);
		if( $data["code"] != 0 ){
			$this->load->view('json',$data);
			return;
		}
		
		$this->load->view('json',$data);
	}
	
	public function get()
	{
		//���Ȩ��
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//����������
		$result = $this->argv->getRequireInput(array('articleId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$articleId = $result["data"]["articleId"];
		
		//ִ��ҵ���߼�
		$data = $this->articleDb->get(
			$articleId
		);
		$this->load->view('json',$data);
	}
	
	public function add()
	{
		//���Ȩ��
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//����������
		$result = $this->argv->postRequireInput(array('title','templateId','remark','state'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//ִ��ҵ���߼�
		$data = $this->articleDb->add(
			$data
		);
		$this->load->view('json',$data);
	}
	
	public function mod()
	{
		//���Ȩ��
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//����������
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
		
		//ִ��ҵ���߼�
		$data = $this->articleDb->mod(
			$articleId,
			$data
		);
		$this->load->view('json',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
