<?php
include_once 'base.php';
if ($role != 1) {
	header ( "location:myreport.php" );
}
include_once 'dbconfig.php';
$typeName = "";
$year = $toyear = date ( "Y" );
$name = "";
$statement = "select work.id,work.year,work.teacherId,user.name,work.typeName,work.rankName,work.content,work.amount,work.classHour,work.money,work.status from work,user ";
$statement .= "where user.username = work.teacherId";
$data = array ();
if (filter_input(INPUT_POST,"year")){
    if ($_POST["year"]){
        $data["year"]=$_POST["year"];
        $year=$_POST["year"];
        $statement .="and work.year=:year ";
    }
    if ($_POST["typename"]){
        $data['typeName'] = $_POST["typename"];
        $typeName=$_POST["typename"];
        $statement .="and work.typeName=:typeName ";
    }
    if ($_POST["name"]){
        $data["name"]=$_POST["name"];
        $name = $_POST["name"];
        $statement .="and user.name=:name";
    }
}
$statmentObject = $pdo->prepare ($statement);
$statmentObject->execute ($data);
$result = $statmentObject->fetchAll ();

$queryBigType = "select distinct typeName from work";
$queryBigTypeObject = $pdo->prepare ($queryBigType);
$queryBigTypeObject->execute ();
$typeNameList = $queryBigTypeObject->fetchAll ();
?>
<!-- 正文开始 -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<!--div class="col-md-12"-->
			<div class="clearfix"></div>
			<div class="searchbody">
				<form method='post' action='check.php'>
					<div class="mytype">
						<p class="mytype-title">年度：</p>
						<select class="mytype-item" name="type_item" width=30>
							<option value="0" <?=empty($year)?"selected":''?>>全部</option>
							<option value="<?=$toyear-2?>"
								<?=$year==$toyear-2?"selected":''?>><?=$toyear-2?>年</option>
							<option value="<?=$toyear-1?>"
								<?=$year==$toyear-1?"selected":''?>><?=$toyear-1?>年</option>
							<option value="<?=$toyear?>" <?=$year==$toyear?"selected":''?>><?=$toyear?>年</option>
							<option value="<?=$toyear+1?>"
								<?=$year==$toyear+1?"selected":''?>><?=$toyear+1?>年</option>
							<option value="<?=$toyear+2?>"
								<?=$year==$toyear+2?"selected":''?>><?=$toyear+2?>年</option>
						</select>
					</div>
					<div class="mytype">
						<p class="mytype-title">大类：</p>
						<select class="mytype-item" name="typeName" width=30>
							<option value="0" <?=empty($typeName)?"selected":''?>>全部</option>
								<?php
								foreach ( $typeNameList as $row ) {
									$bigTypeName = $row ['typeName'];
									$select = ($typeName == $bigTypeName) ? " selected " : " ";
									echo "<option value='$bigTypeName' $select >$bigTypeName</option>";
								}
								?>
							</select>
					</div>
					<div class="mytype">
						<p class="mytype-title">教工名：</p>
						<input type='text' name="name" class="mytype-item" />
					</div>
					<div class="querybtn">
						<input type='submit' value='查询' />
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover"
								id="dataTables-example">
								<thead>
									<tr>
										<th>年度</th>
										<th>教工</th>
										<th>类别</th>
										<th>级别</th>
										<th>内容</th>
										<th>课时</th>
										<th>奖金</th>
										<th>状态</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
                        		<?php
									$line = 0;
									foreach ( $result as $row ) {
										$line ++;
										$linecolor = $line % 2 == 0 ? 'odd gradeX' : 'even gradeC';
										echo "<tr class='$linecolor'>";
										echo "<td>" . $row ['year'] . "</td>";
										echo "<td>" . $row ['name'] . "</td>";
										echo "<td>" . $row ['typeName'] . "</td>";
										echo "<td>" . $row ['rankName'] . "</td>";
										echo "<td>" . mb_substr ( $row ['content'], 0, 3, 'utf-8' ) . "......</td>";
										echo "<td>" . $row ['classHour'] . "</td>";
										echo "<td>" . $row ['money'] . "</td>";
										echo "<td>" . $row ['status'] . "</td>";
										$url = 'checkwork.php?id=' . $row ["id"].'&sta=1';
										$delurl = "deletework.php?id=" . $row ['id']."&ch=1";
										echo '<td style="width:180px;">';
										if($row['status'] == '保存'){
										    //echo "<a class='btn btn-primary btn-sm shiny' onclick='checkwork(".$row['id'].");'><i class='fa fa-edit'>&nbsp;审核</i></a>";
										    echo '<a class="btn btn-primary btn-sm shiny" onclick="pass('.$row['id'].')">&nbsp;通过</a>
                                                  <a class="btn btn-warning btn-sm shiny" onclick="refues('.$row['id'].')" >&nbsp;&nbsp;拒绝</a>&nbsp;&nbsp;';
										}
										echo "<a class='btn btn-danger btn-sm shiny' href='" . $delurl . "'><i class='fa fa-trash-o'>删除</i></a></td>";
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
<div id="modal-module-menus-pass"  class="modal fade" tabindex="-1" style="z-index: 1030;">
    <div class="modal-dialog" style='width: 520px;'>
        <div class="modal-content">
            <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3 id="heml">请填写拒绝原因</h3></div>
            <div class="modal-body">
                <form action="checkwork.php" method="post" class="form-horizontal  form-modal" onsubmit="return confirm('确认此操作吗？')">
					<div class="form-group" style="margin-bottom: 50px;" id="reason">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">拒绝原因</label>
						<div class="col-sm-9">
							<input class="form-control" name='reason' type="text">
							<input type="hidden" class="form-control" name='id' id="id">
							<input type="hidden" class="form-control" name='sta' value="" id="sta">
						</div>	
					</div>
                    <div class="form-group" style="text-align: center;margin-top: 20px;">
                         <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                         <button type="submit" style="margin-left: 50px;" class="btn btn-primary">提交</button>
                    </div>
                </form>
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
function pass(obj){
	$("#id").val(obj);
	$("#sta").val(1);
	$("#reason").hide();
	$('#heml').html('确认通过');
	$("#modal-module-menus-pass").modal();
}
function refues(obj){
	$("#id").val(obj);
	$("#sta").val(2);
	$("#modal-module-menus-pass").modal();
}
</script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>
<script src="layDate-v5.0.9/laydate/laydate.js"></script>
</body>
</html>