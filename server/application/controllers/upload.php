<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->library('argv','argv');
    }
	
	public function img()
	{
		//检查输入参数
		$result = $this->argv->postRequireInput(array('data'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$data = $result["data"]["data"];
			
		//执行业务逻辑
		$uniqueName = md5(uniqid()).'.jpg';
		$fileName = dirname(__FILE__).'/../../../data/upload/'.$uniqueName ;
		$file = fopen($fileName,"wb");
		fwrite($file,base64_decode($data));
		fclose($file);
		$data = array(
			'code'=>0,
			'msg'=>'',
			'data'=>'/upload/'.$uniqueName
		);
		$this->load->view('json',$data);
	}
	
	public function img4Origin()
	{
		$config = array();
		$config['upload_path'] = dirname(__FILE__).'/../../../data/upload/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '2048';

		$this->load->library('upload', $config);

		if( ! $this->upload->do_upload('data')){
			$result = array(
				'code' =>1,
				'msg'=>$this->upload->display_errors(),
				'data'=>''
			);
			$this->load->view('json', $result);
			return;
		}
		
		$data = $this->upload->data();
		if( $data['is_image'] == false ){
			$result = array(
				'code' =>1,
				'msg'=>'不合法的图像文件',
				'data'=>''
			);
			unlink($data['full_path']);
			$this->load->view('json', $result);
			return;
		}
		
		$newFileName = md5(uniqid()).$data['file_ext'];
		$newFileAddress = dirname(__FILE__).'/../../../data/upload/'.$newFileName;
		rename($data['full_path'],$newFileAddress);
		$result = array(
			'code' =>0,
			'msg'=>'',
			'data'=>'/upload/'.$newFileName
		);
		$this->load->view('json', $result);
	}
	
	public function img4Progress()
	{
		//检查输入参数
		$result = $this->argv->postRequireInput(array('id','totalSize','beginSize','endSize','data'));
		if( $result["code"] != 0 ){
			$this->load->view('json',$result);
			return;
		}
		$id = $result["data"]["id"];
		$totalSize = $result["data"]["totalSize"];
		$beginSize = $result["data"]["beginSize"];
		$endSize = $result["data"]["endSize"];
		$data = $result["data"]["data"];
		
		//执行业务逻辑
		if( $totalSize > 1024*1024*5){
			$data = array(
				'code'=>1,
				'msg'=>'上传文件太大',
				'data'=>''
			);
			$this->load->view('json',$data);
			return;
		}
		//$uniqueName = md5($_SERVER['HTTP_REFERER'].$_SERVER['REMOTE_ADDR'].$id).'.jpg';
		$uniqueName = md5($id).'.jpg';
		$fileName = dirname(__FILE__).'/../../../data/upload/'.$uniqueName ;
		if($beginSize == 0 )
			$file = fopen($fileName,"wb");
		else
			$file = fopen($fileName,"ab+");
		$fileSize=abs(filesize($fileName));
		if( ($fileSize/3)*4 != $beginSize){
			$data = array(
				'code'=>1,
				'msg'=>'校验文件大小失败'.$fileSize.','.$beginSize,
				'data'=>''
			);
			$this->load->view('json',$data);
			return;
		}
		fwrite($file,base64_decode($data));
		fclose($file);
		$data = array(
			'code'=>0,
			'msg'=>'',
			'data'=>'/upload/'.$uniqueName
		);
		$this->load->view('json',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
