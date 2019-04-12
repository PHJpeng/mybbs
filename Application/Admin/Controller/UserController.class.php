<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Image;
class UserController extends CommonController
{
	
	//添加部分
    public function create()
    {
        $this->display();
     }
     //接收部分
     public function save()
     {
     	$data = $_POST;
     	$data['created_at'] = time();
     	//判断密码是否为空
     	if(empty($data['upwd'])||empty($data['reupwd'])){
     		$this->error('密码不能为空');
     	}
     	//判断两个密码是否一致
     	if($data['upwd']!==$data['reupwd']){
     		$this->error('两个密码不一致');
     	}
     	//加密密码
     	$data['upwd'] = password_hash($data['upwd'],PASSWORD_DEFAULT);
			
     	//上传头像部分
     	
				$data['uface'] = $this->doUp();
				//小图片部分
				$this->doSm();
     	//保存数据到数据库返回受影响行数
     	$row = M('bbs_user') -> add($data);
     	//判断是否添加成功
     	if($row){
     		$this->success('添加成功');
     	}else if($row){
     		$this->error('添加失败');
     	}
     }
     //查看部分
     public function index()

     {
     	//定义一个空数组
     	$array = [];
     	//判断是否有条件值
     	if(!empty($_GET['sex'])){
     		$array['sex'] = ['eq',"{$_GET['sex']}"];
     	}
     	//判断是否有姓名判断
     	if(!empty($_GET['uname'])){
     		$array['uname'] = ['like',"%{$_GET['uname']}%"];
     	}
     	//分页部分
     	$User = M('bbs_user'); // 实例化User对象
     	$count = $User->where($array)->count();// 查询满足要求的总记录数
     	$Page = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数
     	$list = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
     	
     	// 获取数据
		$users = $User->where($array)->limit($Page->firstRow,$Page->listRows)->select();
		// 显示数据
		
		
		$this->assign('list',$list);// 赋值数据集
		$this->assign('users', $users);
		$this->display(); // 在 View/User/index.html

     }
    //删除部分
     public function del()
     {
     	$uid = $_GET['uid'];
     	$row = M('bbs_user') -> delete($uid);
     	if($row){
     		$this->success('删除成功');
     	}else if($row){
     		$this->error('删除失败');
     	}
     }
     //修改部分 第一步
      public function edit()
     {
     	$uid = $_GET['uid'];
     	$user = M('bbs_user')->find($uid);
     	$this -> assign('user',$user);
     	$this->display();

     }
     //修改部分第二部
     public function update()
     {
     	$uid = $_GET['uid'];
          $data = $_POST;
          if($_FILES['uface']['error']!==4){
               $data['uface'] = $this->doUp();
               $this->doSm();
               
               }
     	$row = M('bbs_user')->where("uid=$uid")->save($data);
     	if($row){
     		$this->success("修改成功",'/index.php?m=admin&c=user&a=index');
     	}else if($row){
     		$this->error("修改失败");
     	}
     }
     //上传图片部分
     private function doUp()
     {
          $config = [
                         'maxSize' => 3145728,
                         'rootPath' => './',
                         'savePath' => 'Public/Uploads/',
                         'saveName' => array('uniqid',''),
                         'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                         'autoSub' => true,
                         'subName' => array('date','Ymd'),
                    ];
                    
                    $upload = new \Think\Upload($config);// 实例化上传类
                    $info = $upload->upload();
                    if(!$info) {// 上传错误提示错误信息
                         $this->error($upload->getError());
                    }
                    //拼接上传完整图片文件名
               return $this->filename = $info['uface']['savepath'].$info['uface']['savename'];
     }
     //生成小图片部分
     private function doSm()
     {
          $image = new Image(Image::IMAGE_GD,$this->filename);
                    
          $image->thumb(150, 150)->save('./'.getSm($this->filename));

     }

}