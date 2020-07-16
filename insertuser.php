<?php
if(filter_input(INPUT_POST, 'username')){
    include_once 'dbconfig.php';
    $data = array(
        "username"=>$_POST['username'],
    	"role"=>intval($_POST['role']),
    	"name"=>$_POST['name'],
    	"departmentName"=>$_POST['departmentName'],
    	"password" => sha1("123456"),
        "status"=>intval($_POST['status']),
    );
    $statement = "INSERT INTO user(id, username,role,name,departmentName,password,status) VALUES (null, :username, :role,:name,:departmentName,:password,:status)";
    $statementObject =  $pdo->prepare($statement);
    $result = $statementObject->execute($data);
    if($result){
    	header("location:jump.php?error=数据保存成功&url=user.php&wait=3");
    }else{
    	header("location:jump.php?error=数据保存失败&url=user.php&wait=3");
    }
    exit();
}
include_once 'base.php';
include_once 'dbconfig.php';
$departmentStatement = "select departmentName from department";
$statmentObject = $pdo->prepare($departmentStatement);
$statmentObject->execute();
$departmentList = $statmentObject->fetchAll();
?>
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>录入用户信息</h2>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-7 col-md-offset-0">
				<!-- class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1"> -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>增加用户信息</strong>
					</div>
					<div class="panel-body">
						<form role="form" action="insertuser.php" method='post'>
							<br />
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag">
										用户名</i></span> <input type="text" class="form-control"
									placeholder="用户名 " name='username' />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 角色名</i></span>
								<select class="form-control" name="role" width=30>
									<option value='1'>管理员</option>
									<option value='0'>教师</option>
								</select>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag">
										姓名</i></span> <input type="text" class="form-control"
									placeholder="姓名 " name='name' />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 部门名称</i></span>
								<select class="form-control" name="departmentName" width=30>
								<?php
								foreach ( $departmentList as $row ) {
									echo "<option value='".$row['departmentName']."' >".$row['departmentName']."</option>";
								}
								?>
							</select>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 状态</i></span>
								<select class="form-control" name="status" width=30>
									<option value='1'>启用</option>
									<option value='0'>禁用</option>
								</select>
							</div>
							</div>
							<input type='reset'  class="btn btn-primary" value=' 重 置 ' />&nbsp;&nbsp;
							<input type='submit'  class="btn btn-primary" value=' 保 存 ' />
							<a class="btn btn-primary" href="user.php">放弃</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
!function(){
	laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
	laydate({elem: '#birthday'});//绑定元素
}();
</script>
</body>
</html>