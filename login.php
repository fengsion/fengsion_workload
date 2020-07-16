<?php 
if(filter_input(INPUT_POST, 'userName')){
    include_once 'dbconfig.php';
    $userName = trim($_POST['userName']);
    $password = trim($_POST['password']);
    $remember = intval($_POST['remember']);
    $sha1Password = sha1($password);
    $data = array(
        "userName"=>$userName,
        "password"=>$sha1Password
    );
    $statement = "select * from user where userName=:userName and password=:password";
    $statementObject = $pdo->prepare($statement);
    $statementObject->execute($data);
    $result = $statementObject->fetch();
    if(empty($result)){
       header("location:jump.php?error=账号或密码有误&url=login.php&wait=3");
    }else{
    	session_start();
    	$authority = array(
    			"userName"=>$userName,
    			"role"=>$result['role']
    			);
    	$_SESSION['authority'] = $authority;
    	if($remember == 1){
    	    setcookie("username", $userName,time() + 3600*24*7);
    	    setcookie("password", $password,time() + 3600*24*7); 
    	    setcookie("remember", $remember,time() + 3600*24*7);
    	}else{
    	    setcookie("username", '',time() + 3600*24*7);
    	    setcookie("password", '',time() + 3600*24*7);
    	    setcookie("remember", '',time() + 3600*24*7);
    	}
       header("location:jump.php?error=登录成功&url=index.php&wait=3");
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>非授课工作量管理系统登录</title>
<!-- BOOTSTRAP STYLES-->
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<!-- FONTAWESOME STYLES-->
<link href="assets/css/font-awesome.css" rel="stylesheet" />
<!-- CUSTOM STYLES-->
<link href="assets/css/custom.css" rel="stylesheet" />
<!-- GOOGLE FONTS-->
<link href="assets/css/opensans.css" rel='stylesheet' type='text/css' />
</head>
<body>
	<div class="container">
		<div class="row text-center ">
			<div class="col-md-12">
				<br/>
				<br/>
				<h2>非授课工作量管理登录</h2>
				<h5>(授权访问)</h5>
				<br />
			</div>
		</div>
		<div class="row ">
			<div
				class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>输入登录信息</strong>
					</div>
					<div class="panel-body">
						<form role="form" action="login.php" method="post">
							<br />
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag"></i></span>
								<input type="text" name="userName" class="form-control" placeholder="填写用户名 " value="<?php if($_COOKIE['username']){echo $_COOKIE['username'];}else{echo '';}?>"/>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span>
								<input type="password"  name="password"  class="form-control" placeholder="填写密码" value="<?php if($_COOKIE['password']){echo $_COOKIE['password'];}else{echo '';}?>" />
							</div>
							<div class="form-group">
								<label class="checkbox-inline"> <input type="checkbox" name="remember" value="1" <?php if($_COOKIE['remember']){echo 'checked="checked"';}else{echo '';}?> />记住密码</label> 
								<span class="pull-right"><a href="#">忘记密码 ?</a></span>
							</div>
							<input type='submit' class="btn btn-primary" value="登录"/>&nbsp;&nbsp;
							<input type='reset' class="btn btn-primary" value="重置"/>
							<hr />
							未注册 ? <a href="registeration.php">点这儿！</a>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
	<!-- JQUERY SCRIPTS -->
	<script src="assets/js/jquery-1.10.2.js"></script>
	<!-- BOOTSTRAP SCRIPTS -->
	<script src="assets/js/bootstrap.min.js"></script>
	<!-- METISMENU SCRIPTS -->
	<script src="assets/js/jquery.metisMenu.js"></script>
	<!-- CUSTOM SCRIPTS -->
	<script src="assets/js/custom.js"></script>
</body>
</html>
