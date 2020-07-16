<?php

if (filter_input(INPUT_GET, 'id')) {
	include_once 'base.php';
    include_once 'dbconfig.php';
    // 查询数据
    $data = array(
        "id" => $_GET['id']
    );
    $query = "select * from user where id = :id";
    $queryObject = $pdo->prepare($query);
    $queryObject->execute($data);
    $result = $queryObject->fetch();
    
    $departmentStatement = "select departmentName from department";
	$statmentObject = $pdo->prepare($departmentStatement);
	$statmentObject->execute();
	$departmentList = $statmentObject->fetchAll();
    
}else{
	header("location:jump.php?error=数据修改成功&url=user.php&wait=3");
}
if (filter_input(INPUT_POST, 'username')) {
    include_once 'dbconfig.php';
    $data = array(
       "id" => $_POST['id'],
    	"username"=>$_POST['username'],
    	"role"=>$_POST['role'],
    	"name"=>$_POST['name'],
    	"departmentName"=>$_POST['departmentName'],
    );
    $statement = "UPDATE user SET username=:username,role=:role,name=:name,departmentName=:departmentName WHERE id = :id";
    $statementObject = $pdo->prepare($statement);
    $result = $statementObject->execute($data);
    if ($result) {
        header("location:jump.php?error=数据修改成功&url=user.php&wait=3");
    } else {
        header("location:jump.php?error=数据修改失败&url=user.php&wait=3");
    }
    exit();
}

?>
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>编辑用户信息</h2>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-7 col-md-offset-0">
				<!-- class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1"> -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>编辑用户信息</strong>
					</div>
					<div class="panel-body">
						<form role="form" action="edituser.php" method='post'>
							<input type="hidden" class="form-control" name='id'
								value="<?=$result['id']?>"  /> <br />
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag">
										用户名</i></span> <input type="text" class="form-control" placeholder="用户名 " name='username' value="<?=$result['username']?>"  />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 角色</i></span>
								<?php 
								if($result['role'] == 1){ 
								    echo '<input type="text" class="form-control" placeholder="角色" name="role" value="管理员"/>';
								}elseif($result['role'] == 0) {
								    echo '<input type="text" class="form-control" placeholder="角色" name="role" value="教师"/>';
								}
								?>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 姓名</i></span>
								<input type="text" class="form-control" placeholder="姓名" name='name' value="<?=$result['name']?>"  />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 部门名称</i></span>
								<select class="form-control" name='departmentName'>
								<?php
								foreach ( $departmentList as $row ) {
									echo "<option value='".$row['departmentName']."' >".$row['departmentName']."</option>";
								}
								?>
								</select>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 密码</i></span>
								<input type="text" class="form-control" placeholder="密码" name='password' disabled="disabled" value="<?=$result['password']?>"  />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 状态</i></span>
								<select class="form-control" name='status'>
								<?php
								echo "<option value='1' >启用</option>";
								echo "<option value='0' >禁用</option>";
								?>
								</select>
							</div>
							<input type='submit' class="btn btn-primary" value='修 改' />
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