<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('loginAo','loginAo');
    }
	
	public function index()
	{
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			header("Location: /login.html");
		}else{
			header("Location: /index.html");
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
