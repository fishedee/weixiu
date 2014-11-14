<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountDb extends CI_Model {

	var $tableName = "t_account";
	
    public function __construct()
    {
        parent::__construct();
    }
	
	public function search($where,$limit)
	{
		foreach( $where as $key=>$value ){
			if( $key == "name" || $key == "remark")
				$this->db->like($key,$value);
			else if( $key == "type" || $key == "state" || $key == "categoryId"  || $key == "userId" || $key == "money")
				$this->db->where($key,$value);
		}
		
		$this->db->order_by('createTime','desc');
		
		if( isset($limit["pageIndex"]) && isset($limit["pageSize"]))
			$this->db->limit($limit["pageSize"],$limit["pageIndex"]);
		
		
		
		$query = $this->db->get($this->tableName);
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$query->result()
		);
	}
	
	public function get($accountId)
	{
		$this->db->where("accountId",$accountId);
		$query = $this->db->get($this->tableName)->result();
		if( count($query) == 0 )
			return array(
				"code"=>1,
				"msg"=>"找不到此数据",
				"data"=>""
			);
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$query[0]
		);
	}
	
	public function count($where)
	{
		foreach( $where as $key=>$value ){
			if( $key == "name" || $key == "remark")
				$this->db->like($key,$value);
			else if( $key == "type" || $key == "state" || $key == "categoryId"  || $key == "userId" || $key == "money")
				$this->db->where($key,$value);
		}
		
		$query = $this->db->count_all_results($this->tableName);
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$query
		);
	}
	
	public function add( $data )
	{
		$data["createTime"] = date("Y-m-d H:i:s");
		$data["modifyTime"] = date("Y-m-d H:i:s");
		
		$query = $this->db->insert($this->tableName,$data);
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
		);
	}
	
	public function mod( $accountId , $data )
	{
		$data["modifyTime"] = date("Y-m-d H:i:s");
		
		$query = $this->db->update($this->tableName,$data,array("accountId"=>$accountId));
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
		);
	}
	
	public function modByIdAndUser( $accountId , $userId , $data )
	{
		$data["modifyTime"] = date("Y-m-d H:i:s");
		
		$query = $this->db->update($this->tableName,$data,array("accountId"=>$accountId,"userId"=>$userId));
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
		);
	}
	
	public function getByIdAndUser( $accountId , $userId )
	{
		$this->db->where("accountId",$accountId);
		$this->db->where("userId",$userId);
		$query = $this->db->get($this->tableName)->result();
		if( count($query) == 0 )
			return array(
				"code"=>1,
				"msg"=>"找不到此数据",
				"data"=>""
			);
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$query[0]
		);
	}
	
	
}