<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CI_Argv{
	var $CI;
	
	public function __construct()
    {
		$this->CI = & get_instance();
	}
	
	public function postRequireInput( $input )
	{
		$result = array();
		foreach( $input as $key=>$value ){
			if( $this->CI->input->post($value,true) === false ){
				return array(
					"code"=>1,
					"msg"=>"请输入post参数".$value,
					"data"=>""
				);
			}else{
				$result[$value] = $this->CI->input->post($value,true);
			}
		}
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$result
		);
	}
	
	public function postOptionInput( $input )
	{
		$result = array();
		foreach( $input as $key=>$value ){
			if( $this->CI->input->post($value,true) === false ){
				continue;
			}else{
				$result[$value] = $this->CI->input->post($value,true);
			}
		}
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$result
		);
	}
	
	public function getRequireInput( $input )
	{
		$result = array();
		foreach( $input as $key=>$value ){
			if( $this->CI->input->get($value,true) === false ){
				return array(
					"code"=>1,
					"msg"=>"请输入get参数".$value,
					"data"=>""
				);
			}else{
				$result[$value] = $this->CI->input->get($value,true);
			}
		}
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$result
		);
	}
	
	public function getOptionInput( $input ){
		$result = array();
		foreach( $input as $key=>$value ){
			if( $this->CI->input->get($value,true) === false ){
				continue;
			}else{
				$result[$value] = $this->CI->input->get($value,true);
			}
		}
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>$result
		);
	}
}
?>