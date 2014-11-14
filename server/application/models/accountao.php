<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountAo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('accountDb','accountDb');
		$this->load->model('categoryDb','categoryDb');
    }
	
	public function search($where,$limit)
	{
		$accounts = $this->accountDb->search($where,$limit);
		if( $accounts['code'] != 0 )
			return $accounts;
			
		if( count($accounts['data']) == 0 )
			return $accounts;
			
		$categoryIds = array();
		foreach( $accounts["data"] as $single )
			if( in_array($single->categoryId,$categoryIds) == false )
				$categoryIds[] = $single->categoryId;
		
		$categorys = $this->categoryDb->getByIds($categoryIds);
		if( $categorys['code'] != 0 )
			return $categorys;
			
		foreach( $accounts["data"] as $key=>$value ){
			$accounts["data"][$key]->categoryName = $categorys["data"][$value->categoryId];
		}
		
		return $accounts;
	}
	
	public function count($where)
	{
		return $this->accountDb->count($where);
	}
	
	public function getByIdAndUser($accountId , $userId)
	{
		return $this->accountDb->getByIdAndUser($accountId,$userId);
	}
	
	public function add( $data )
	{
		$categoryId = $data['categoryId'];
		$categorys = $this->categoryDb->get($categoryId);
		if( $categorys['code'] != 0 )
			return $categorys;
		
		if( $categorys['data']->state != $this->categoryDb->STATE_VALID )
			return array(
				"code"=>1,
				"msg"=>"不可用的类目id",
				"data"=>""
			);
		
		return $this->accountDb->add($data);
	}
	
	public function modByIdAndUser( $accountId , $userId , $data )
	{
		$categoryId = $data['categoryId'];
		$categorys = $this->categoryDb->get($categoryId);
		if( $categorys['code'] != 0 )
			return $categorys;
		
		if( $categorys['data']->state != $this->categoryDb->STATE_VALID )
			return array(
				"code"=>1,
				"msg"=>"不可用的类目id",
				"data"=>""
			);
		
		return $this->accountDb->modByIdAndUser($accountId , $userId , $data);
	}
}