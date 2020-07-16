<?php
include_once 'base.php';
include_once 'dbconfig.php';
$bigType = "";
$year = $toyear = date ( "Y" );
$name = "";
$authority = $_SESSION['authority'];
$teacherId = $authority['userName'];
$statement = "select work.teacherId,sum(work.classHour) as classHour,sum(work.money) as money from work,user ";
$statement .= "where user.username = work.teacherId and work.status='确认' and work.teacherId = $teacherId ";
$data = array ();
if (filter_input ( INPUT_POST, "year" )) {
	if ($_POST ["year"]) {
		$data ["year"] = $_POST ["year"];
		$year = $_POST ["year"];
		$statement .= "and work.year=:year ";
	}
	if ($_POST ["bigType"]) {
		$data ["bigType"] = $_POST ["bigType"];
		$bigType = $_POST ["bigType"];
		$statement .= "and work.typeName in (select typeName from worktype where bigType=:bigType) ";
	}
	if ($_POST ["name"]) {
		$data ["name"] = $_POST ["name"];
		$name = $_POST ["name"];
		$statement .= "and user.name=:name ";
	}
}
$statement .="group by work.teacherId";
$statmentObject = $pdo->prepare ( $statement );
$statmentObject->execute ( $data );
$result = $statmentObject->fetchAll ();

$queryBigType = "select bigType from worktype group by bigType";
$queryBigTypeObject = $pdo->prepare($queryBigType);
$queryBigTypeObject->execute();
$bigTypeList = $queryBigTypeObject->fetchAll();
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
						<select class="mytype-item" name="bigType" width=30>
							<option value="0" <?=empty($bigType)?"selected":''?>>全部</option>
								<?php
								foreach ( $bigTypeList as $row ) {
									$bigTypeName = $row ['bigType'];
									$select = ($bigType == $bigTypeName) ? " selected " : " ";
									echo "<option value='$bigTypeName' $select >$bigTypeName</option>";
								}
								?>
							</select>
					</div>
					<div class="mytype">
						<p class="mytype-title">教工号：</p>
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
										<th>教工号</th>
										<th>折算课时</th>
										<th>奖金</th>
									</tr>
								</thead>
								<tbody>
                        		<?php
									$line = 0;
									foreach ( $result as $row ) {
										$line ++;
										$linecolor = $line % 2 == 0 ? 'odd gradeX' : 'even gradeC';
										echo "<tr class='$linecolor'>";
										echo "<td>" . $row ['teacherId'] . "</td>";
										echo "<td>" . $row ['classHour'] . "</td>";
										echo "<td>" . $row ['money'] . "</td>";
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
<?php
//include_once 'floor.php';
?>
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