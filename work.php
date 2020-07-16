<?php 
include_once 'base.php';
include_once 'dbconfig.php';
//查询变量初始化
$typeName = "";
$year = $toyear =date("Y");
$name = "";
//查询语句
$statement = "select work.id,work.year,user.name,work.typeName,work.rankName,work.content,work.amount,work.classHour,work.money,work.status from work,user ";
$statement .="where user.username=work.teacherId ";
$data = array();
//数据来自表单
if (filter_input(INPUT_POST,"year")){
	if ($_POST["year"]){
		$data["year"]=$_POST["year"];
		$year=$_POST["year"];
		$statement .="and work.year=:year ";
	}
	if ($_POST["typename"]){
		$data['typeName'] = $_POST["typename"];
		$typeName=$_POST["year"];
		$statement .="and work.typeName=:typeName ";
	}
	if ($_POST["name"]){
		$data["name"]=$_POST["name"];
		$name = $_POST["name"];
		$statement .="and user.name=:name";		
	}
}
$statmentObject = $pdo->prepare($statement);
$statmentObject->execute($data);
$result = $statmentObject->fetchAll();
?>
<!-- 正文开始 -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<!--div class="col-md-12"-->
			<div class="clearfix"></div>
			<div class="searchbody">
				<form method='post' action='work.php'>
					<div class="mytype">
						<p class="mytype-title">年度:&nbsp;&nbsp;</p>
						<select class="mytype-item" name="year" width=30>
							<option value="0" <?=empty($type)?"selected":''?>>全部</option>
							<option value="<?=$toyear-2?>" <?=$year==$toyear-2?"selected":''?>><?=$toyear-2?>年</option>
							<option value="<?=$toyear-1?>" <?=$year==$toyear-1?"selected":''?>><?=$toyear-1?>年</option>
							<option value="<?=$toyear?>" <?=$year==$toyear?"selected":''?>><?=$toyear?>年</option>
							<option value="<?=$toyear+1?>" <?=$year==$toyear+1?"selected":''?>><?=$toyear+1?>年</option>
							<option value="<?=$toyear+2?>" <?=$year==$toyear+2?"selected":''?>><?=$toyear+2?>年</option>
						</select>
					</div>
					<div class="mytype">
						<p class="mytype-title">按类别:&nbsp;&nbsp;</p>
						<select class="mytype-item" name="typename" width=30>
							<option value="0" <?=empty($typeName)?"selected":''?>>全部</option>
							<option value="论文" <?=$typeName=='论文'?"selected":''?>>论文</option>
							<option value="著作" <?=$typeName=='著作'?"selected":''?>>著作</option>
							<option value="科研" <?=$typeName=='科研'?"selected":''?>>科研</option>
							<option value="专利" <?=$typeName=='专利'?"selected":''?>>专利</option>
							<option value="教科研成果奖" <?=$typeName=='教科研成果奖'?"selected":''?>>教科研成果奖</option>
							<option value="技能竞赛" <?=$typeName=='技能竞赛'?"selected":''?>>技能竞赛</option>
							<option value="教练奖" <?=$typeName=='教练奖'?"selected":''?>>教练奖</option>
							<option value="其它" <?=$typeName=='其它'?"selected":''?>>其它</option>
						</select>
					</div>
					<div class="mytype">
						<p class="mytype-title">教工名:&nbsp;&nbsp;</p>
						<input type='text' name="name" class="mytype-item" />
					</div>
						<div class="querybtn">
							<input type='submit' value='查询' />
						</div>
						<div class="clearfix"></div>
				</form>
			</div>
		</div>
		<div class="clearfix"></div>
		<!-- /. ROW  -->
		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<b><a href='insertwork.php' class="btn btn-primary">新增非授课工作</a></b>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover"
								id="dataTables-example">
								<thead>
									<tr>
										<th>年度</th>
										<th>教工</th>
										<th>类别</th>
										<th>工作内容</th>
										<th>数量</th>
										<th>证据</th>
										<th>课时</th>
										<th>奖励</th>
										<th>状态</th>
										<th width='140'>操作</th>
									</tr>
								</thead>
								<tbody>
                        		<?php
                                $line = 0;
                                foreach ($result as $row) {
                                    $line ++;
                                    $linecolor = $line % 2 == 0 ? 'odd gradeX' : 'even gradeC';
                                    echo "<tr class='$linecolor'>";
                                    echo "<td>" . $row['year'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['typeName'] . "</td>";
                                    echo "<td>" . $row['rankName'] . "</td>";
                                    echo "<td>" .mb_substr($row['content'],0,20,'utf-8')."......</td>";
                                    echo "<td>" . $row['amount'] . "</td>";        
                                    echo "<td>" . $row['classHour'] . "</td>";
                                    echo "<td>" . $row['money'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";                                   
                                    $url = "editwork.php?id=".$row ['id'];
									$delurl = "deletework.php?id=".$row ['id'];
									echo "<td style='width:150px;'><a class='btn btn-primary btn-sm shiny' href='".$url."'><i class='fa fa-edit'>&nbsp;编辑</i></a>
								    &nbsp;&nbsp;<a class='btn btn-danger btn-sm shiny' href='" . $delurl . "'><i class='fa fa-trash-o'>&nbsp;删除</i></a></td>";
									echo "</tr>";
                                }
                                ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
				<!--End Advanced Tables -->
			</div>
		</div>

	</div>

</div>
<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="./assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="./assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="./assets/js/jquery.metisMenu.js"></script>
<!-- DATA TABLE SCRIPTS -->
<script src="./assets/js/dataTables/jquery.dataTables.js"></script>
<script src="./assets/js/dataTables/dataTables.bootstrap.js"></script>
<script>
		$(document).ready(function() {
			$('#dataTables-example').dataTable();
		});
	</script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>
<script src="layDate-v5.0.9/laydate/laydate.js"></script>
</body>
</html>