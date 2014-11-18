<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserDb extends CI_Model {

	var $tableName = "t_user";
	var $TYPE_ADMIN = 0;
	var $TYPE_USER = 1;
	var $STATE_VALID = 0;
	var $STATE_INVALID = 1;
    public function __construct()
    {
        parent::__construct();
    }
	
	public function search($where,$limit)
	{
		foreach( $where as $key=>$value ){
			if( $key == "name" )
				$this->db->like($key,$value);
			else if( $key == "type" || $key == "state" )
				$this->db->where($key,$value);
		}
		$count = $this->db->count_all_results($this->tableName);
		
		foreach( $where as $key=>$value ){
			if( $key == "name" )
				$this->db->like($key,$value);
			else if( $key == "type" || $key == "state" )
				$this->db->where($key,$value);
		}
		
		$this->db->order_by('createTime','desc');
		
		if( isset($limit["pageIndex"]) && isset($limit["pageSize"]))
			$this->db->limit($limit["pageSize"],$limit["pageIndex"]);
			
		$query = $this->db->get($this->tableName);
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>array(
				'count'=>$count,
				'data'=>$query->result_array()
			)
		);
	}
	
	public function get($userId){
		$this->db->where("userId",$userId);
		$query = $this->db->get($this->tableName)->result_array();
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
	
	public function mod( $userId , $data )
	{
		$data["modifyTime"] = date("Y-m-d H:i:s");
		
		$query = $this->db->update($this->tableName,$data,array("userId"=>$userId));
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
		);
	}
	
	public function modPassword( $userId , $oldPassword , $newPassword )
	{
		$data = array();
		$data["password"] = $newPassword;
		$data["modifyTime"] = date("Y-m-d H:i:s");
		
		$query = $this->db->update($this->tableName,$data,array("userId"=>$userId,"password"=>$oldPassword));
		$rows = $this->db->affected_rows();
		if( $rows == 0 ){
			return array(
				"code"=>1,
				"msg"=>"密码错误",
				"data"=>""
			);
		}
			
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
		);
	}
	
	public function getByNameAndPass($name,$password)
	{
		$this->db->where("name",$name);
		$this->db->where("password",$password);
		$this->db->where("state",0);
		$query = $this->db->get($this->tableName)->result_array();
		if( count($query) == 0 )
			return array(
				"code"=>1,
				"msg"=>"帐号或密码错误",
				"data"=>""
			);
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$query[0]
		);
	}
	
	public function getByName($name)
	{
		$this->db->where("name",$name);
		$query = $this->db->get($this->tableName)->result_array();
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$query
		);
	}
	
}