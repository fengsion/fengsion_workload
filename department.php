<?php 
include_once 'base.php';
include_once 'dbconfig.php';
$statement = "select * from department";
$statmentObject = $pdo->prepare($statement);
$statmentObject->execute();
$result = $statmentObject->fetchAll();
?>
<!-- 正文开始 -->
  <div id="page-wrapper" >
	<div id="page-inner">
		<hr />
		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<b><a href='insertdepartment.php' class="btn btn-primary">新增部门</a></b>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover"
								id="dataTables-example">
								<thead>
									<tr>
									    <th>部门名称</th><th>部门负责人</th> <th>操作</th> 
									</tr>
								</thead>
								<tbody>
                        		<?php
                                $line = 0;
                                foreach ($result as $row) {
                                    $line ++;
                                    $linecolor = $line % 2 == 0 ? 'odd gradeX' : 'even gradeC';
                                    echo "<tr class='$linecolor'>";
                                    echo "<td>" . $row['departmentName'] . "</td>";
                                    echo "<td>" . $row['dutyPerson'] . "</td>";
                                    $url = "editdepartment.php?id=".$row ['id'];
									$delurl = "deletedepartment.php?id=".$row ['id'];
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
<div id="foot-wrapper" align='center'>
			版权所有@2017-<?=date("Y")?>黎嘉荣<br /> 非授课工作量管理系统，网址：<a
		href='www.betgod.top/workload'>http://119.23.109.208/workload</a> <br /> <br />
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