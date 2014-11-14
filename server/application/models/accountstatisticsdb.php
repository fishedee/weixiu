<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountStatisticsDb extends CI_Model {
	var $tableName = "t_account";
	
    public function __construct()
    {
        parent::__construct();
    }
	
	public function getPayComponents($beginTime,$endTime)
	{
		$beginTime = $beginTime;
		$endTime = date('Y-m-d',strtotime($endTime) + 60*60*24);
		$sql = 'select categoryId , type, sum(money) as money from t_account '.
			'where createTime >= \''.$beginTime.'\' and createTime <= \''.$endTime.'\' and state = 0 '.
			'group by categoryId,type '.
			'order by money desc';
		$query = $this->db->query($sql);
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$query->result()
		);
	}
}