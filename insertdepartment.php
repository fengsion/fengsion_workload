<?php
if(filter_input(INPUT_POST, 'departmentName')){
    include_once 'dbconfig.php';
    $departmentName = $_POST['departmentName'];
    $dutyPerson = $_POST['dutyPerson'];
    $data = array(
        "departmentName"=>$departmentName,
        "dutyPerson"=>$dutyPerson,
    );
    $statement = "INSERT INTO department(id, departmentName, dutyPerson)".
        " VALUES (null, :departmentName, :dutyPerson)";
    $statementObject =  $pdo->prepare($statement);
    $result = $statementObject->execute($data);
    if($result){
        header("location:jump.php?error=数据保存成功&url=department.php&wait=3");
    }else{
        header("location:jump.php?error=数据保存失败&url=department.php&wait=3");
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
						<strong>增加部门</strong>
					</div>
					<div class="panel-body">
						<form role="form" action="insertdepartment.php" method='post'>
							<br />
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag">
										部门名称</i></span> <input type="text" class="form-control"
									placeholder="请输入部门名称 " name='departmentName' />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 负责人姓名</i></span>
								<input type="text" class="form-control" placeholder="请输入负责人姓名"
									name='dutyPerson'/>
							</div>
							<input type='reset'  class="btn btn-primary" value=' 重 置 ' />&nbsp;&nbsp;
							<input type='submit'  class="btn btn-primary" value=' 保 存 ' />
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