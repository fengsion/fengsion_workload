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
}else {
    header("location:work.php");
}
include_once 'base.php';
?>
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>查看工作量</h2>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-7 col-md-offset-0">
				<!-- class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1"> -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>查看工作量</strong>
					</div>
					<div class="panel-body">
						<form role="form" action="editmywork.php" method='post'>
							<input type="hidden" class="form-control" name='id'
								value="<?=$result['id']?>" disabled="disabled" /> <br />
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag">
										 年度</i></span>
								<select class="form-control" disabled="disabled" name="year">
            						<option value="0" >全部</option>
            						<option value="<?=$result['year']?>" selected><?=$result['year']?>年</option>
            					</select>
										 
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 教工</i></span>
								<input type="text" class="form-control" placeholder="教工"
									name='teacherId' disabled="disabled" value="<?=$result['teacherId']?>" />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-level-up">  &nbsp;类别</i></span>
								<input type="text" class="form-control" placeholder="类别"
									name='typeName' disabled="disabled" value="<?=$result['typeName']?>" />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-level-up">  &nbsp;级别</i></span>
								<input type="text" class="form-control" placeholder="级别"
									name='rankName' disabled="disabled" value="<?=$result['rankName']?>" />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-navicon">&nbsp;内容</i></span>
								<textarea class="form-control" rows="5" placeholder="工作内容" id="content" maxlength="499" 
									name='content' disabled="disabled"><?=$result['content']?></textarea>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-level-up">  &nbsp;课时</i></span>
								<input type="text" class="form-control" placeholder="课时"
									name='classHour' disabled="disabled" value="<?=$result['classHour']?>" />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-level-up">  &nbsp;奖金</i></span>
								<input type="text" class="form-control" placeholder="奖金"
									name='money' disabled="disabled" value="<?=$result['money']?>" />
							</div>
<!-- 							<input type='submit' name="save" class="btn btn-primary" value='修改' /> -->
							<a class="btn btn-primary" href="mywork.php">返回</a>
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