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
		//���Ȩ��
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//����������
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
		
		//ִ��ҵ���߼�
		$data = $this->articleContentDb->search(
			$dataWhere,$dataLimit
		);
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
		$result = $this->argv->getRequireInput(array('articleContentId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$articleContentId = $result["data"]["articleContentId"];
		
		//ִ��ҵ���߼�
		$data = $this->articleContentDb->get(
			$articleContentId
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
		$result = $this->argv->postRequireInput(array('articleId','type','data','weight'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$data = $result["data"];
		
		//ִ��ҵ���߼�
		$data = $this->articleContentDb->add(
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
		
		//ִ��ҵ���߼�
		$data = $this->articleContentDb->mod(
			$articleContentId,
			$data
		);
		$this->load->view('json',$data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
