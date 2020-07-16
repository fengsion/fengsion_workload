<?php
include_once 'base.php';
include_once 'dbconfig.php';
$authority = $_SESSION['authority'];
$teacherId = $authority['userName'];
$type = "";
$statement = "select * from work where teacherId = $teacherId";
$statmentObject = $pdo->prepare($statement);
$statmentObject->execute();
$result = $statmentObject->fetchAll();
?>
<!-- 正文开始 -->
  <div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<!--div class="col-md-12"-->
			<div class="clearfix"></div>
			<div class="searchbody">
				<form method='post' action='mywork.php'>
					<div class="mycheck">
						<div class="mytype">
							<p class="mytype-title">按类别：</p>
							<select class="mytype-item" name="type_item" width=30>
								<option value="0" <?=empty($type)?"selected":''?>>全部</option>
								<option value="论文" <?=$type=='论文'?"selected":''?>>论文</option>
								<option value="著作" <?=$type=='著作'?"selected":''?>>著作</option>
								<option value="科研" <?=$type=='科研'?"selected":''?>>科研</option>
								<option value="专利" <?=$type=='专利'?"selected":''?>>专利</option>
								<option value="教科研成果奖" <?=$type=='教科研成果奖'?"selected":''?>>教科研成果奖</option>
								<option value="技能竞赛" <?=$type=='技能竞赛'?"selected":''?>>技能竞赛</option>
								<option value="教练奖" <?=$type=='教练奖'?"selected":''?>>教练奖</option>
								<option value="其它" <?=$type=='其它'?"selected":''?>>其它</option>
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
						<b><a href='insertmywork.php' class="btn btn-primary">新增工作量</a></b>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover"
								id="dataTables-example">
								<thead>
									<tr>
									    <th>年度</th>	 <th>教工</th> <th>类别</th> <th>级别</th> <th>内容</th>
										<th>课时</th><th>奖金</th><th>状态</th><th>操作</th>
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
                                    echo "<td>" . $row['teacherId'] . "</td>";
                                    echo "<td>" . $row['typeName'] . "</td>";
                                    echo "<td>" . $row['rankName'] . "</td>";
                                    echo "<td>" . mb_substr($row['content'],0,3,'utf-8') ."......</td>";
                                    echo "<td>" . $row['classHour'] . "</td>";
                                    echo "<td>" . $row['money'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    $url = "editmywork.php?id=".$row ['id'];
									$delurl = "deletemywork.php?id=".$row ['id'];
									$view = "viewmywork.php?id=".$row ['id'];
                                    /* if($row['status'] == "确认" || $row['status'] == "待审"){
                                    	echo "<td><a class='btn btn-primary btn-sm shiny' href='".$view."'><i class='fa fa-edit'>&nbsp;查看</i></a></td>";
                                    }else{ */
									if($row['status'] == '保存'){
									    echo "<td><a class='btn btn-primary btn-sm shiny' href='".$url."'><i class='fa fa-edit'>&nbsp;编辑</i></a>
								    	&nbsp;&nbsp;<a class='btn btn-danger btn-sm shiny' href='" . $delurl . "'><i class='fa fa-trash-o'>&nbsp;删除</i></a></td>";
									}else{
									    echo "<td><a class='btn btn-success btn-sm shiny' href='".$view."'>&nbsp;查看</a></td>";
									}
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