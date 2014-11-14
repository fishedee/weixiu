<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics extends CI_Controller 
{

	public function __construct()
    {
        parent::__construct();
		$this->load->model('loginAo','loginAo');
		$this->load->library('argv','argv');
		$this->load->model('accountStatisticsAo','accountStatisticsAo');
    }
	
	public function payComponents()
	{
		//检查登录态
		$result = $this->loginAo->islogin();
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		$userId = $result["data"];
		
		//检查输入参数
		$result = $this->argv->getRequireInput(array('beginTime','endTime'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return $result;
		}
		
		//执行业务逻辑
		$result = $this->accountStatisticsAo->getPayComponents(
			$result['data']['beginTime'],
			$result['data']['endTime']
		);
		$this->load->view('json',$result);
	}
}