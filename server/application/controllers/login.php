<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('loginAo','loginAo');
		$this->load->library('argv','argv');
    }
	
	public function islogin()
	{
		$result = $this->loginAo->islogin();
		$this->load->view('json',$result);
	}
	
	public function checkout()
	{
		$result = $this->loginAo->logout();
		$this->load->view('json',$result);
	}
	public function checkin()
	{
		//����������
		$result = $this->argv->postRequireInput(array('name','password'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		
		//ִ��ҵ���߼�
		$result = $this->loginAo->login(
			$result["data"]["name"],
			$result["data"]["password"]
		);
		$this->load->view('json',$result);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
