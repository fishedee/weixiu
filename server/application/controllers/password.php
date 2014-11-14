<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('loginAo','loginAo');
		$this->load->model('userDb','userDb');
		$this->load->library('argv','argv');
    }
	
	public function mod()
	{
		//检查登录态
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"];
		
		//检查输入参数
		$result = $this->argv->postRequireInput(array('oldpassword','newpassword'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		
		//执行业务逻辑
		$data = $this->userDb->modPassword(
			$userId,
			sha1($result['data']['oldpassword']),
			sha1($result['data']['newpassword'])
		);
		$this->load->view('json',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
