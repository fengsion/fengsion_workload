<?php
if (filter_input(INPUT_GET, 'id')) {
    include_once 'dbconfig.php';
    // 查询数据
    $data = array(
        "id" => $_GET['id']
    );
    $statement = "select * from work where id = :id";
    $statementObject = $pdo->prepare($statement);
    $statementObject->execute($data);
    $result = $statementObject->fetch();
    if (! $result) {
        header("location:jump.php?error=无有效数据&url=work.php&wait=3");
    }
    
} elseif (filter_input(INPUT_POST, 'year')) {
    include_once 'dbconfig.php';
    $id = $_POST['id'];
    $year = $_POST['year'];
    $teacherId =  $_POST['teacherId'];
    $typeName = $_POST['typeName'];
    $rankName = $_POST['rankName'];
    $content =  $_POST['content'];
    $classHour = $_POST['classHour'];
    $money = $_POST['money'];
    $status = "确认";
    $data = array(
        "id" => $id,
        "year"=>$year,
        "teacherId"=>$teacherId,
        "typeName" =>$typeName,
    	"rankName" =>$rankName,
        "content"=>$content,
        "classHour"=>$classHour,
    	"money"=>$money,
    	"status"=>$status
    );
    $statement = "UPDATE work SET year=:year,teacherId=:teacherId,typeName=:typeName,rankName=:rankName, content=:content,classHour=:classHour,money=:money,status=:status WHERE id = :id";
    $statementObject = $pdo->prepare($statement);
    $result = $statementObject->execute($data);
    if ($result) {
        header("location:jump.php?error=数据修改成功&url=work.php&wait=3"); 
    } else {
        header("location:jump.php?error=数据修改失败&url=work.php&wait=3");
    }
    exit();
} else {
    header("location:work.php");
}
include_once 'base.php';
?>
<script>
function pickName(){
	window.open("pickname.php","_blank",
			"height=100,width=400,left=300,top=500,location=no,"+
			"menubar=no,titlebar=no,toolbar=no,resizable=no,scrollbars=no"
			);
}

</script>
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>修改工作量</h2>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-7 col-md-offset-0">
				<!-- class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1"> -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>编辑工作量</strong>
					</div>
					<div class="panel-body">
						<form role="form" action="editwork.php" method='post'>
							<input type="hidden" class="form-control" name='id'
								value="<?=$result['id']?>" /> <br />
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag">
										 年度</i></span>
									<select class="form-control" name="year">
            						<option value="0" >全部</option>
            						<option value="<?=$result['year']?>" selected><?=$result['year']?>年</option>
            					</select>
									
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 教工号</i></span>
								<input type="text" class="form-control" placeholder="教工号"
									name='teacherId' value="<?=$result['teacherId']?>"
									/>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-level-up">  &nbsp;类别</i></span>
								<input type="text" class="form-control" placeholder="类别"
									name='typeName' value="<?=$result['typeName']?>" />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-level-up">  &nbsp;级别</i></span>
								<input type="text" class="form-control" placeholder="级别"
									name='rankName' value="<?=$result['rankName']?>" />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-navicon">&nbsp;内容</i></span>
								<textarea class="form-control" rows="5" placeholder="工作内容" maxlength="499" 
									name='content'><?=$result['content']?></textarea>
							</div>
							
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-level-up">  &nbsp;课时</i></span>
								<input type="text" class="form-control" placeholder="课时"
									name='classHour' value="<?=$result['classHour']?>" />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-level-up">  &nbsp;奖金</i></span>
								<input type="text" class="form-control" placeholder="奖金"
									name='money' value="<?=$result['money']?>" />
							</div>
							<input type='submit' class="btn btn-primary" value='保存' />
							<a class="btn btn-primary" href="work.php">放弃</a>
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