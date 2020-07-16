<?php
include_once 'base.php';
include_once 'dbconfig.php';
//查询部门列表
$departmentStatement ="select departmentName from department";
$statmentObject = $pdo->prepare($departmentStatement);
$statmentObject->execute();
$departmentList = $statmentObject->fetchAll();
//被部门查询
if(filter_input(INPUT_POST, 'departmentName')){
	$departmentName = $_POST['departmentName'];
	$data = array(
			'departmentName'=>$departmentName
	);
	$statement = "select * from user where departmentName=:departmentName";
	$statmentObject = $pdo->prepare($statement);
	$statmentObject->execute($data);
}else {
	$depdepartmentName = "";
	$statement = "select * from user";
	$statmentObject = $pdo->prepare($statement);
	$statmentObject->execute();
}
$result = $statmentObject->fetchAll();

?>
<!-- 正文开始 -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<!-- class="col-md-12 -->
			<div class="clearfix"></div>
			<div class="serachbody">
				<form method='post' action='user.php'>
					<div class="mycheak">
    					<div class="mytype">
    						<p class="mytype-title">按类别:&nbsp;&nbsp;</p>
    						<select class="mytype-item" name="departmentName" width=30>
    							<option value="0" <?= empty($departmentName)?"select":''?>>全部</option>
                                 <?php
    		                     foreach ( $departmentList as $row ) {
    			                     echo "<option value='" . $row ["departmentName"] . "'>" . $row ["departmentName"] . "</option>";
    		                      }
    		                     ?>
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
	<!-- /. Row  -->
   <hr/>
   <div class="row">
   <div class="col-md-12">
   <!-- Advanced Tables -->
   <div class="panel panel-default">
   <div class="panel-heading">
   <b><a href='insertuser.php' class="btn btn-primary">新增教师</a></b>
   </div>
   <div class="panel-body">
   <div class="table-responsive">
   <table class="table table-striped table-bordered table-hover"
        id="dataTables-example">
        <thead>
        <tr>
        <th>登录帐号</th>
         <th>角色</th>
           <th>姓名</th>
            <th>部门</th>
             <th>状态</th>
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
            	echo "<td>" . $row['username'] . "</td>";
            	if($row['role'] == 0){
            	    echo "<td>教师</td>";
            	}elseif ($row['role'] == 1){
            	    echo "<td>管理员</td>";
            	}
            	echo "<td>" . $row['name']. "</td>";
            	echo "<td>" . $row['departmentName'] . "</td>";
            	if($row['status'] == 0){
            	    echo "<td><label class='label label-default'>禁用</label></td>";
            	}elseif ($row['status'] == 1){
            	    echo "<td><label class='label label-success'>启用</label></td>";
            	}
            	$url = "edituser.php?id=".$row ['id'];
            	$delurl = "deleteuser.php?id=".$row ['id'];
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
   <!-- End Advanced Tables -->
   
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