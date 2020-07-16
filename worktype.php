<?php 
include_once 'base.php';
include_once 'dbconfig.php';
$typeName = "";
$statement = "select * from worktype";
$data = array();
//数据来自表单
if (filter_input(INPUT_POST,"typename")){
    if ($_POST["typename"]){
        $data['typeName'] = $_POST["typename"];
        $statement .=" where typeName=:typeName ";
    }
}
$statmentObject = $pdo->prepare($statement);
$statmentObject->execute($data);
$result = $statmentObject->fetchAll();
?>
<!-- 正文开始 -->
  <div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<!--div class="col-md-12"-->
			<div class="clearfix"></div>
			<div class="searchbody">
				<form method='post' action='worktype.php'>
					<div class="mycheck">
						<div class="mytype">
							<p class="mytype-title">按类别：</p>
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
							<div class="clearfix"></div>
						</div>
						<div class="querybtn">
							<input type='submit' value='查询' />
						</div>
						<div class="clearfix"></div>
					</div>
				</form>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<b><a href='insertworktype.php' class="btn btn-primary">新增类别</a></b>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover"
								id="dataTables-example">
								<thead>
									<tr>
									    <th>大类</th>	 
									    <th>类别</th> 
									    <th>级别</th>  
									    <th>工作内容</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
                        		<?php
                                $line = 0;
                                foreach ($result as $row) {
                                    $line ++;
                                    $linecolor = $line % 2 == 0 ? 'odd gradeX' : 'even gradeC';
                                    echo "<tr class='$linecolor'>";
                                    echo "<td>" . $row['bigType'] . "</td>";
                                    echo "<td>" . $row['typeName'] . "</td>";
                                    echo "<td>" . $row['rank'] . "</td>";
                                    echo "<td>" .mb_substr($row['content'],0,20,'utf-8')."......</td>";
                                    $url = "editworktype.php?id=".$row ['id'];
									$delurl = "deleteworktype.php?id=".$row ['id'];
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