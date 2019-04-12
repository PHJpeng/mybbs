<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    public function login()
    {
    	
        $this->display();
     }
     //接收登录验证信息
     public function dologin()
     {
     	$uname = $_POST['uname'];
     	$upwd = $_POST['upwd'];

     	$code = $_POST['code'];
     	$verify = new \Think\Verify();
		if( !$verify->check($code)){
			$this->error('验证码输入错误');
		}

     	$user = M('bbs_user')->where("uname='$uname'")->find();
     	
     	if($user && password_verify($upwd,$user['upwd'])){
     		//回话跟踪 
     		$_SESSION['userInfo'] = $user;
     		$_SESSION['flag'] = true;
     		$this->success('登录成功','index.php?m=admin&c=user&a=index');
     	}else{
     		$this->error('登录失败');
     	}
     }

     //退出方法
     public function logout()
     {
     	$_SESSION['userInfo'] = false;
     	$_SESSION['flag'] = false;
     	$this->success('正在退出...','index.php?m=admin&c=login&a=login');
     }
     //生成验证码
     public function code()
     {
     	$config = array(
						'fontSize' => 20, // 验证码字体大小
						'length' => 3, // 验证码位数
						'useNoise' => false, // 关闭验证码杂点
						'useCurve' => false, //是否使用混淆曲线
						'imageH' => 40,
						'imageW' => 120,

						);
     	$Verify = new \Think\Verify($config);
		$Verify->entry();
     }
     		
}