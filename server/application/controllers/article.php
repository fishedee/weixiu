<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('articleAo','articleAo');
		$this->load->model('templateDb','templateDb');
		$this->load->model('loginAo','loginAo');
		$this->load->library('argv','argv');
    }
	public function render( $data ,$url ){
		require_once($url);
	}
	public function go(){
		//����������		
		$result = $this->argv->getOptionInput(array('articleId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$articleId = $result["data"]['articleId'];
		
		//ҵ���߼�
		$result = $this->articleAo->get($articleId);
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$article = $result['data'];
		
		//��ȡ���Ƶ�ģ���ַ
		$result = $this->templateDb->get($article['templateId']);
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$templateUrl = $result['data']['url'];
		$url = dirname(__FILE__).'/../../../static/public/'.$templateUrl;
		
		//��ȡ���Ƶ�����
		$data = array();
		$data['title'] = $article['title'];
		$data['sound'] = $article['sound'];
		$data['createTime'] = $article['createTime'];
		$data['content'] = '';
		foreach( $article['content'] as $single ){
			if( $single['type'] == 0 )
				$data['content'] .= '<p class="text-c1" style="text-indent:2em;">'.$single['data'].'<br></p>';
			else{
				$data['content'] .= '<p style="text-align:center;"><img class="img-c1"  src="'.$single['data'].'"></p>';
			}
		}
		
		//�������
		$this->render($data,$url);
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
		$data = $this->articleAo->search($dataWhere,$dataLimit);
		if( $data["code"] != 0 ){
			$this->load->view('json',$data);
			return;
		}
		
		$this->load->view('json',$data);
	}
	
	public function get()
	{
		//���Ȩ��
		/*
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		*/
		
		//����������
		$result = $this->argv->getRequireInput(array('articleId'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$articleId = $result["data"]["articleId"];
		
		//ִ��ҵ���߼�
		$result = $this->articleAo->get(
			$articleId
		);
		$this->load->view('json',$result);
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
		$result = $this->articleAo->add(
			$data
		);
		$this->load->view('json',$result);
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
		
		$result = $this->argv->postRequireInput(array('title','sound','templateId','remark','state'));
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
		
		//ִ��ҵ���߼�
		$result = $this->articleAo->mod(
			$articleId,
			$data
		);
		$this->load->view('json',$result);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
