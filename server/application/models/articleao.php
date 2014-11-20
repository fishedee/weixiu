<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ArticleAo extends CI_Model {

	var $tableName = "t_article";
	var $STATE_VALID = 0;
	var $STATE_INVALID = 1;
    public function __construct()
    {
        parent::__construct();
		$this->load->model('articleContentDb','articleContentDb');
		$this->load->model('articleDb','articleDb');
    }
	
	public function search($where,$limit)
	{
		return $this->articleDb->search($where,$limit);
	}
	
	public function add( $data )
	{
		return $this->articleDb->add($data);
	}
	
	public function get($articleId){
		$result = $this->articleDb->get($articleId);
		if( $result['code'] != 0 )
			return $result;
		$article = $result['data'];
		
		$result = $this->articleContentDb->getByArticle($articleId);
		if( $result['code'] != 0 )
			return $result;
		$article['content'] = $result['data'];
		
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$article
		);
	}
	
	
	
	public function mod( $articleId , $data )
	{
		//删除原有content数据
		$result = $this->articleContentDb->delByArticle($articleId);
		if( $result['code'] != 0 )
			return $result;
		
		//添加新content数据
		$articleContent = $data['content'];
		$articleContent = matrix_set_column($articleContent,'articleId',$articleId);
		$result = $this->articleContentDb->addBatch($articleContent);
		
		//修改article数据
		$article = $data;
		unset($article['content']);
		$result = $this->articleDb->mod($articleId,$article);
		
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>''
		);
	}
	
}