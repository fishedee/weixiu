<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PeopleAo extends CI_Model {

	var $tableName = "t_people";
	var $STATE_VALID = 0;
	var $STATE_INVALID = 1;
    public function __construct()
    {
        parent::__construct();
		$this->load->model('peopleDb','peopleDb');
		$this->load->model('peopleEventDb','peopleEventDb');
		$this->load->model('peopleContactDb','peopleContactDb');
		$this->load->model('peopleRelationDb','peopleRelationDb');
    }
	
	public function search($where,$limit)
	{
		return $this->peopleDb->search($where,$limit);
	}
	
	public function add( $data ){
		return $this->peopleDb->add($data);
	}

	public function get( $peopleId ){
		$result = $this->peopleDb->get($peopleId);
		if( $result['code'] != 0 )
			return $result;
		$people = $result['data'];
		
		$result = $this->peopleEventDb->getByPeople($peopleId);
		if($result['code'] != 0 )
			return $result;
		$people->event = $result['data'];
		
		$result = $this->peopleContactDb->getByPeople($peopleId);
		if($result['code'] != 0 )
			return $result;
		$people->contact = $result['data'];
		
		$result = $this->peopleRelationDb->getByPeople($peopleId);
		if($result['code'] != 0 )
			return $result;
		$people->relation = $result['data'];
		
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$people
		);
	}
	
	private function modEvent( $peopleId , $data ){
		//获取人物原来的事件
		$result = $this->peopleEventDb->getByPeople($peopleId);
		if($result['code'] != 0 )
			return $result;
		$oldEvent = array();
		foreach( $result['data'] as $single )
			$oldEvent[$single->peopleEventId] = $single;
		
		//添加人物事件
		foreach( $data as $single ){
			if( trim($single['peopleEventId']) == ""){
				$peopleEvent = array(
					'peopleId'=>$peopleId,
					'name'=>$single['name'],
					'remark'=>$single['remark'],
					'state'=>0,
				);
				$result = $this->peopleEventDb->add($peopleEvent);
				if( $result['code'] != 0 )
					return $result;
			}
		}
		
		//修改人物事件
		foreach( $data as $single ){
			if( array_key_exists($single['peopleEventId'],$oldEvent) == true ){
				if( $oldEvent[$single['peopleEventId']]->peopleId != $peopleId )
					return array(
						'code'=>1,
						'msg'=>'不合法的eventId',
						'data'=>''
					);
				$peopleEvent = array(
					'peopleId'=>$peopleId,
					'name'=>$single['name'],
					'remark'=>$single['remark'],
					'state'=>0,
				);
				$result = $this->peopleEventDb->mod($single['peopleEventId'],$peopleEvent);
				if( $result['code'] != 0 )
					return $result;
				unset($oldEvent[$single['peopleEventId']]);
			}
		}
		//删除人物事件
		foreach( $oldEvent as $single ){
			$peopleEvent = array(
				'state'=>1,
			);
			$result = $this->peopleEventDb->mod($single->peopleEventId,$peopleEvent);
			if( $result['code'] != 0 )
				return $result;
		}
		
		//返回结果
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>''
		);
	}
	
	private function modContact( $peopleId,$data){
		
		//获取人物原来的联系方式
		$result = $this->peopleContactDb->getByPeople($peopleId);
		if($result['code'] != 0 )
			return $result;
		$oldContact = array();
		foreach( $result['data'] as $single )
			$oldContact[$single->peopleContactId] = $single;
		
		//添加人物联系方式
		foreach( $data as $single ){
			if( trim($single['peopleContactId']) == ""){
				$peopleContact = array(
					'peopleId'=>$peopleId,
					'name'=>$single['name'],
					'value'=>$single['value'],
					'remark'=>$single['remark'],
					'state'=>0,
				);
				$result = $this->peopleContactDb->add($peopleContact);
				if( $result['code'] != 0 )
					return $result;
			}
		}
		
		//修改人物联系方式
		foreach( $data as $single ){
			if( array_key_exists($single['peopleContactId'],$oldContact) == true ){
				if( $oldContact[$single['peopleContactId']]->peopleId != $peopleId )
					return array(
						'code'=>1,
						'msg'=>'不合法的contactId',
						'data'=>''
					);
				$peopleContact = array(
					'peopleId'=>$peopleId,
					'name'=>$single['name'],
					'value'=>$single['value'],
					'remark'=>$single['remark'],
					'state'=>0,
				);
				$result = $this->peopleContactDb->mod($single['peopleContactId'],$peopleContact);
				if( $result['code'] != 0 )
					return $result;
				unset($oldContact[$single['peopleContactId']]);
			}
		}
		//删除人物联系方式
		foreach( $oldContact as $single ){
			$peopleContact = array(
				'state'=>1,
			);
			$result = $this->peopleContactDb->mod($single->peopleContactId,$peopleContact);
			if( $result['code'] != 0 )
				return $result;
		}
		
		//返回结果
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>''
		);
	}
	
	private function modRelation( $peopleId , $data ){
		//获取人物原来的关系
		$result = $this->peopleRelationDb->getByPeople($peopleId);
		if($result['code'] != 0 )
			return $result;
		$oldRelation = array();
		foreach( $result['data'] as $single )
			$oldRelation[$single->peopleRelationId] = $single;
		
		//添加人物关系
		foreach( $data as $single ){
			if( trim($single['peopleRelationId']) == ""){
				$peopleRelation = array(
					'firstPeopleId'=>$peopleId,
					'secondPeopleId'=>$single['peopleId'],
					'relation'=>$single['relation'],
					'remark'=>$single['remark'],
					'state'=>0,
				);
				$result = $this->peopleRelationDb->add($peopleRelation);
				if( $result['code'] != 0 )
					return $result;
			}
		}
		
		//修改人物关系
		foreach( $data as $single ){
			if( array_key_exists($single['peopleRelationId'],$oldRelation) == true ){
				if( $oldRelation[$single['peopleRelationId']]->firstPeopleId != $peopleId 
					&& $oldRelation[$single['peopleRelationId']]->secondPeopleId != $peopleId  )
					return array(
						'code'=>1,
						'msg'=>'不合法的relationId',
						'data'=>''
					);
				$peopleRelation = array(
					'firstPeopleId'=>$peopleId,
					'secondPeopleId'=>$single['peopleId'],
					'relation'=>$single['relation'],
					'remark'=>$single['remark'],
					'state'=>0,
				);
				$result = $this->peopleRelationDb->mod($single['peopleRelationId'],$peopleRelation);
				if( $result['code'] != 0 )
					return $result;
				unset($oldRelation[$single['peopleRelationId']]);
			}
		}
		//删除人物关系
		foreach( $oldRelation as $single ){
			$peopleRelation = array(
				'state'=>1,
			);
			$result = $this->peopleRelationDb->mod($single['peopleRelationId'],$peopleRelation);
			if( $result['code'] != 0 )
				return $result;
		}
		
		//返回结果
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>''
		);
	}
	
	public function mod( $peopleId , $data ){
		$peopleBaseInfo = array(
			'name'=>$data['name'],
			'sex'=>$data['sex'],
			'birthday'=>$data['birthday'],
			'remark'=>$data['remark'],
			'state'=>$data['state'],
		);
		$result = $this->peopleDb->mod($peopleId,$peopleBaseInfo);
		if( $result['code'] != 0 )
			return $result;
		
		$result = $this->modRelation( $peopleId,$data['relation']);
		if( $result['code'] != 0 )
			return $result;
			
		$result = $this->modEvent( $peopleId,$data['event']);
		if( $result['code'] != 0 )
			return $result;
			
		$result = $this->modContact( $peopleId,$data['contact']);
		if( $result['code'] != 0 )
			return $result;
		
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>''
		);
	}
	
}