<?php
if (filter_input(INPUT_GET, 'id')) {
    include_once 'dbconfig.php';
    // 查询数据
    $data = array(
        "id" => $_GET['id']
    );
    $statement = "select * from department where id = :id";
    $statementObject = $pdo->prepare($statement);
    $statementObject->execute($data);
    $result = $statementObject->fetch();
    if (! $result) {
        header("location:jump.php?error=无有效数据&url=department.php&wait=3");
    }
    
} elseif (filter_input(INPUT_POST, 'departmentName')) {
    include_once 'dbconfig.php';
    $id = $_POST['id'];
    $departmentName = $_POST['departmentName'];
    $dutyPerson = $_POST['dutyPerson'];
    $data = array(
        "id" => $id,
       "departmentName"=>$departmentName,
        "dutyPerson"=>$dutyPerson,
    );
    $statement = "UPDATE department SET departmentName=:departmentName,dutyPerson=:dutyPerson WHERE id = :id";
    $statementObject = $pdo->prepare($statement);
    $result = $statementObject->execute($data);
    if ($result) {
        header("location:jump.php?error=数据修改成功&url=department.php&wait=3");
    } else {
        header("location:jump.php?error=数据修改失败&url=department.php&wait=3");
    }
    exit();
}
include_once 'base.php';
?>
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>录入工作类别信息</h2>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-7 col-md-offset-0">
				<!-- class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1"> -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>编辑部门</strong>
					</div>
					<div class="panel-body">
						<form role="form" action="editdepartment.php" method='post'>
							<input type="hidden" class="form-control" name='id'
								value=<?=$result['id']?> /> <br />
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag">
										部门名称</i></span> <input type="text" class="form-control"
									placeholder="请输入部门名称 " name='departmentName' value=<?=$result['departmentName']?> />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 负责人姓名</i></span>
								<input type="text" class="form-control" placeholder="请输入负责人姓名"
									name='dutyPerson' value=<?=$result['dutyPerson']?> />
							</div>
							<input type='submit' class="btn btn-primary" value='修 改' />
							<a class="btn btn-primary" href="department.php">放弃</a>
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