<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uedit extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
		$this->load->model('loginAo','loginAo');
		$this->load->library('argv','argv');
    }
	
	public function control()
	{
		//检查权限
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//检查输入参数
		$result = $this->argv->getRequireInput(array('action'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		
		include('uedit/controller.php');
	}
};