<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginAo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('userDb','userDb');
    }
	
	public function islogin(){
		$userId = $this->session->userdata('userId');
		if( $userId >= 10000 ){
			$result = $this->userDb->get($userId);
			if( $result["code"] != 0 )
				return $result;
				
			if( $result["data"]['state'] != $this->userDb->STATE_VALID )
				return array(
					"code"=>1,
					"msg"=>"该用户不可用",
					"data"=>$userId
				);
				
			return array(
				"code"=>0,
				"msg"=>"",
				"data"=>$userId
			);
		}else{
			return array(
				"code"=>1,
				"msg"=>"帐号未登录",
				"data"=>""
			);
		}
	}
	
	public function logout(){
		$this->session->unset_userdata('userId');
		return array(
				"code"=>0,
				"msg"=>"",
				"data"=>""
			);
	}
	
	public function login( $name , $password ){
		
		$result = $this->userDb->getByNameAndPass($name,sha1($password));
		if( $result["code"] != 0 )
			return $result;
		
		if( $result["data"]['state'] != $this->userDb->STATE_VALID )
			return array(
				"code"=>1,
				"msg"=>"该用户不可用",
				"data"=>$userId
			);
			
		$user = $result["data"];
		
		$this->session->set_userdata('userId',$user['userId']);
		return array(
				"code"=>0,
				"msg"=>"",
				"data"=>""
			);
	}
}