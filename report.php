<?php
include_once 'base.php';
if ($role != 1) {
	header ( "location:myreport.php" );
}
include_once 'dbconfig.php';
$name = "";
$statement = "select work.teacherId,sum(work.classHour) as classHour,sum(work.money) as money from work,user ";
$statement .= "where user.username = work.teacherId and work.status='确认' ";
$data = array ();
if (filter_input ( INPUT_POST, "name" )) {
	if ($_POST ["name"]) {
		$data ["name"] = $_POST ["name"];
		$name = $_POST ["name"];
		$statement .= "and user.username=:name ";
	}
}
$statement .= "group by work.teacherId";
$statmentObject = $pdo->prepare ( $statement );
$statmentObject->execute ( $data );
$result = $statmentObject->fetchAll ();
?>
<!-- 正文开始 -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<!--div class="col-md-12"-->
			<div class="clearfix"></div>
			<div class="searchbody">
				<form method='post' action='report.php'>
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