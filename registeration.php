<?php
if(filter_input(INPUT_POST, 'username')){
    include_once 'dbconfig.php';
    $data = array(
        "username"=>$_POST['username'],
    	"role"=>0,
    	"name"=>$_POST['name'],
        "departmentName"=>'',
        "password" => sha1($_POST['password']),
    	"status"=>1,
    );
    $statement = "INSERT INTO user(id, username,role,name,departmentName,password,status) VALUES (null, :username,:role,:name,:departmentName,:password,:status)";
    $statementObject =  $pdo->prepare($statement);
    $result = $statementObject->execute($data);
    if($result){
    	header("location:jump.php?error=注册成功&url=login.php&wait=3");
    }else{
    	header("location:jump.php?error=注册失败&url=registeration.php&wait=3");
    }
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>注册用户</title>
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
        <div class="row text-center  ">
            <div class="col-md-12">
                <br /><br />
                <h2>非授课工作量管理注册</h2>

				<h5>(注册获取授权访问)</h5>
                 <br />
            </div>
        </div>
         <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                    		<strong>注册新用户</strong>  
                        </div>
                        <div class="panel-body">
                            <form role="form" action="registeration.php" method='post' onsubmit="return formcheck();">
									<br/>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="用户名" />
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="姓名" />
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                    <input type="password" name="password" id="pass" class="form-control" placeholder="登录密码" />
                                </div>
                                <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                        <input type="password" id="pass2" class="form-control" placeholder="确认密码" />
                                </div>
                                <input type='submit' class="btn btn-success" value="立即注册"/>
                                <hr/>
                                	已经注册?<a href="login.php">点击登录</a>
                            </form>
                        </div>
                    </div>
               </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    <script>
		function formcheck(){
			var pass = $('#pass').val();
			var pass2 = $('#pass2').val();
			if(pass != pass2){
				alert('密码不一致');
				return;
			}
		}
    </script>
</body>
</html>
