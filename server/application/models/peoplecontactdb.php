<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PeopleContactDb extends CI_Model {

	var $tableName = "t_people_contact";
	var $STATE_VALID = 0;
	var $STATE_INVALID = 1;
    public function __construct()
    {
        parent::__construct();
    }
	
	public function get($peopleContactId){
		$this->db->where("peopleContactId",$peopleContactId);
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
	
	public function getByPeople( $peopleId ){
		$this->db->where("peopleId",$peopleId);
		$this->db->where("state",0);
		$query = $this->db->get($this->tableName)->result();
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
	
	public function mod( $peopleContactId , $data )
	{
		$data["modifyTime"] = date("Y-m-d H:i:s");
		
		$query = $this->db->update($this->tableName,$data,array("peopleContactId"=>$peopleContactId));
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
		);
	}
	
}