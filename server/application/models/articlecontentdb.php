<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ArticleContentDb extends CI_Model {

	var $tableName = "t_article_content";
	var $STATE_VALID = 0;
	var $STATE_INVALID = 1;
    public function __construct()
    {
        parent::__construct();
    }
	
	public function get($articleContentId){
		$this->db->where("articleContentId",$articleContentId);
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
	
	public function getByArticle($articleId){
		$this->db->where("articleId",$articleId);
		$this->db->where("state",0);
		$query = $this->db->get($this->tableName)->result_array();
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$query
		);
	}
	
	public function delByArticle($articleId){
		$data = array();
		$data['state'] = 1;
		$data["modifyTime"] = date("Y-m-d H:i:s");
		$this->db->update($this->tableName,$data,array("articleId"=>$articleId));
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>''
		);
	}
	
	public function addBatch($data){
		if( count($data) == 0 ){
			return array(
				"code"=>0,
				"msg"=>"",
				"data"=>""
			);
		}
		foreach( $data as $key=>$value ){
			$data[$key]['state'] = 0;
			$data[$key]["createTime"] = date("Y-m-d H:i:s");
			$data[$key]["modifyTime"] = date("Y-m-d H:i:s");
		}
		foreach( $data as $key=>$value ){
			$this->db->insert($this->tableName,$value);
		}
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
		);
	}
	
	public function search($where,$limit)
	{
		foreach( $where as $key=>$value ){
			if( $key == "articleId" || $key == "state" )
				$this->db->where($key,$value);
		}
		$count = $this->db->count_all_results($this->tableName);
		
		foreach( $where as $key=>$value ){
			if( $key == "articleId" || $key == "state" )
				$this->db->where($key,$value);
		}
		
		$this->db->order_by('weight','asc');
		
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
	
	public function mod( $articleContentId , $data )
	{
		$data["modifyTime"] = date("Y-m-d H:i:s");
		
		$query = $this->db->update($this->tableName,$data,array("articleContentId"=>$articleContentId));
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
		);
	}
	
}