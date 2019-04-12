<?php
namespace Admin\Controller;

use Think\Controller;

class PartController extends CommonController
{
	//增加分区
	public function create()
	{
		$this->display();
	}
	public function save()
	{
		
		$row = M('bbs_part')->add($_POST);
		if($row){
			$this->success('增加分区成功');
		}else{
			$this->error('增加分区失败');
		}

	}
	//显示分区
    public function index()
    {
    	$parts = M('bbs_part')->select();
    	$this-> assign('parts',$parts);
        $this->display();
     }
     //删除分区
     public function del()
     {
     	$pid = $_GET['pid'];
     	$row = M('bbs_part')->where("pid=$pid")->delete($_POST);
     	if($row){
     		$this->success('删除分区成功');
     	}else{
     		$this->error('删除分区失败');
     	}
     }
     //修改分区
     public function edit()
     {
     	$pid = $_GET['pid'];
     	$parts = M('bbs_part')->find($pid);
     	$this->assign('parts',$parts);
     	$this->display();
     }
     public function update()
     {
     	$pid = $_GET['pid'];
     	$row = M('bbs_part')->where("pid=$pid")->save($_POST);
     	if($row){
     		$this->success('修改分区成功','/index.php?&m=admin&c=part&a=index');
     	}else{
     		$this->error('修改分区失败');
     	}
     }
}