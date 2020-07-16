<?php
if(filter_input(INPUT_POST, 'bigType')){
    include_once 'dbconfig.php';
    $bigType = $_POST['bigType'];
    $typeName =  $_POST['typeName'];
    $rank = $_POST['rank'];
    $content =  $_POST['content'];
    $classHour = array(
        "C"  =>  $_POST['classHour'],
        "L"  =>  $_POST['minClassHour'],
        "H"  =>  $_POST['maxClassHour'],
        "TL"  =>  $_POST['totalMinClassHour'],
        "TH"  =>  $_POST['totalMaxClassHour'],
    );
    $price = array(
        "C"  =>  $_POST['price'],
        "L"  =>  $_POST['minPrice'],
        "H" =>  $_POST['maxPrice'],
        "TL"  =>  $_POST['totalMinPrice'],
        "TH"  =>  $_POST['totalMaxPrice'],
    );
    $data = array(
        "bigType"=>$bigType,
        "typeName"=>$typeName,
        "rank" =>$rank,
        "content"=>$content,
        "classHour"=>serialize($classHour),
        "price"=>serialize($price),
    );
    $statement = "INSERT INTO worktype(id, bigType, typeName, rank, content, classHour, price) VALUES (null, :bigType, :typeName, :rank, :content, :classHour, :price)";
    $statementObject =  $pdo->prepare($statement);
    $result = $statementObject->execute($data);
    if($result){
        header("location:jump.php?error=数据保存成功&url=worktype.php&wait=3");
    }else{
        header("location:jump.php?error=数据保存失败&url=worktype.php&wait=3");
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
						<strong>增加工作类别</strong>
					</div>
					<div class="panel-body">
						<form role="form" action="insertworktype.php" method='post'>
							<br />
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag">
										 大类名称</i></span> <input type="text" class="form-control"
									placeholder="大类名称 " name='bigType' />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag"> 类别名称</i></span>
								<input type="text" class="form-control" placeholder="类别名称"
									name='typeName'/>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-level-up">  &nbsp;级别名称</i></span>
								<input type="text" class="form-control" placeholder="级别名称"
									name='rank'/>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-navicon"> 类别描述</i></span>
								<textarea class="form-control" rows="5" placeholder="类别描述"
									name='content'></textarea>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-clock-o"> 折算课时</i></span>
								<input type="text" class="form-control" placeholder="范围最小值"
									name='minClassHour'/><span class="input-group-addon">~</span><input type="text" class="form-control" placeholder="范围最大值"
									name='maxClassHour'/><span class="input-group-addon">或</span><input type="text" class="form-control" placeholder="固定课时"
									name='classHour'/>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-clock-o"> 总量约束</i></span>
								<input type="text" class="form-control" placeholder="课时总量最小约束值"
									name='totalMinClassHour'/><span class="input-group-addon">~</span><input type="text" class="form-control" placeholder="课时总量最大约束值"
									name='totalMaxClassHour'/>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-yen"> &nbsp;奖励金额</i></span>
								<input type="text" class="form-control" placeholder="范围最小值"
									name='minPrice'/><span class="input-group-addon">~</span><input type="text" class="form-control" placeholder="范围最大值" name='maxPrice'/>
							    <span class="input-group-addon">或</span><input type="text" class="form-control" placeholder="固定奖励额"
									name='price'/>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-yen"> &nbsp;总额约束</i></span>
								<input type="text" class="form-control" placeholder="奖励总额最小约束值"
									name='totalMinPrice'/><span class="input-group-addon">~</span>
									<input type="text" class="form-control" placeholder="奖励总额最大约束值" name='totalMaxPrice'/>
							</div>
							<input type='reset'  class="btn btn-primary" value=' 重 置 ' />&nbsp;&nbsp;
							<input type='submit'  class="btn btn-primary" value=' 保 存 ' />
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