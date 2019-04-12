<?php
namespace Admin\Controller;

use Think\Controller;

class CateController extends CommonController
{
	//增加板块
	 public function create()
	 {
	 	$parts = M('bbs_part')->select();
	 	$this->assign('parts',$parts);
	 	$this->display();
	 }
	 public function save()
	 {
	 	
	 	
	 	$row = M('bbs_cate')->add($_POST);
	 	if($row){
	 		$this->success('添加板块成功');
	 	}else{
	 		$this->error('添加板块失败');
	 	}
	 }
	//板块显示
    public function index()
    {
    	$parts = M('bbs_part')->select();
    	$users = M('bbs_user')->select();
    	$cates = M('bbs_cate')->select();
    	$parts = array_column($parts,'pname','pid');
    	$users = array_column($users,'uname','uid');
    	$this -> assign('parts',$parts);
    	$this -> assign('users',$users);
    	$this -> assign('cates',$cates);
        $this->display();
     }
     //删除板块
     public function del()
     {
     	$cid = $_GET['cid'];
     	$row = M('bbs_cate')->delete($cid);
     	if($row){
     		$this->success('删除板块成功');
     	}else{
     		$this->error('删除板块失败');
     	}
     }
     //修改板块
     public function edit()
     {
     	
     	$cid = $_GET['cid'];
     	$cate = M('bbs_cate')->find($cid);
     	$parts = M('bbs_part')->select();    	
		$this -> assign('parts',$parts);
     	$this->assign('cate',$cate);
     	$this->display();
     }
     public function update()
     {
     	$cid = $_GET['cid'];
     	$row = M('bbs_cate')->where("cid=$cid")->save($_POST);
     	if($row){
     		$this->success('修改板块成功','index.php?m=admin&c=cate&a=index');
     	}else{
     		$this->error('修改板块失败');
     	}
     }
}