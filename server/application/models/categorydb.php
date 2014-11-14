<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CategoryDb extends CI_Model {

	var $tableName = "t_category";
	var $STATE_VALID = 0;
	var $STATE_INVALID = 1;
    public function __construct()
    {
        parent::__construct();
    }
	
	public function search($where,$limit)
	{
		foreach( $where as $key=>$value ){
			if( $key == "name" || $key == "remark")
				$this->db->like($key,$value);
			else if( $key == "state" || $key == "userId"  )
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
	
	public function get($categoryId){
		$this->db->where("categoryId",$categoryId);
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
			else if( $key == "state" || $key == "userId"  )
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
	
	public function mod( $categoryId , $data )
	{
		$data["modifyTime"] = date("Y-m-d H:i:s");
		
		$query = $this->db->update($this->tableName,$data,array("categoryId"=>$categoryId));
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
		);
	}
	
	public function getByIds($categoryIds)
	{
		$this->db->where_in("categoryId",$categoryIds);
		$query = $this->db->get($this->tableName);
		$result = $query->result();
		$data = array();
		foreach( $result as $single )
			$data[$single->categoryId] = $single->name;
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$data
		);
	}
	
	public function modByIdAndUser( $categoryId , $userId , $data )
	{
		$data["modifyTime"] = date("Y-m-d H:i:s");
		
		$query = $this->db->update($this->tableName,$data,array("categoryId"=>$categoryId,"userId"=>$userId));
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
		);
	}
	
	public function getByIdAndUser( $categoryId , $userId )
	{
		$this->db->where("categoryId",$categoryId);
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
	
	public function getValidByUser( $userId )
	{
		$this->db->where("userId",$userId);
		//$this->db->where("state",$this->STATE_VALID);
		$query = $this->db->get($this->tableName)->result();
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$query
		);
	}
}