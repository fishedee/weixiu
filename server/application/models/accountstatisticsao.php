<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountStatisticsAo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('accountStatisticsDb','accountStatisticsDb');
		$this->load->model('categoryDb','categoryDb');
    }
	
	public function getPayComponents($beginTime,$endTime)
	{
		$result = $this->accountStatisticsDb->getPayComponents($beginTime,$endTime);
		if( $result['code'] != 0 )
			return $result;
		
		if( count($result['data']) == 0 )
			return $result;
		
		
		//获取每个数据下的categoryName
		$categoryIds = array();
		foreach( $result["data"] as $single )
			if( in_array($single->categoryId,$categoryIds) == false )
				$categoryIds[] = $single->categoryId;
		
		$categorys = $this->categoryDb->getByIds($categoryIds);
		if( $categorys['code'] != 0 )
			return $categorys;
			
		foreach( $result["data"] as $key=>$value ){
			$result["data"][$key]->categoryName = $categorys["data"][$value->categoryId];
		}
		
		//根据支付类型分类数据
		$data = array();
		foreach( $result['data'] as $single ){
			$data[$single->type][] = $single;
		}
		
		//统计每个支付类型下的总数及百分比
		foreach( $data as $type=>$value ){
			$total = 0;
			foreach( $value as $singleItem )
				$total += $singleItem->money;
			foreach( $value as $key=>$singleItem )
				$data[$type][$key]->percentage = $singleItem->money/$total*100%100;
			$data[$type][] = array(
				'categoryName'=>'合计',
				'money'=>$total,
				'percentage'=>100
			);
		}
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data
		);
	}
	
}