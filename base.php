<?php
include_once 'authority.php';
if (!isset($_SESSION)){
session_start();
}
if(isset($_SESSION['authority'])){
	$authority = $_SESSION['authority'];
	$userName = $authority['userName'];
	$role = $authority['role'];
	if($role == 1) $ro = '管理员';
	else $ro = '教师';
	$fileName = $_SERVER['PHP_SELF'];
	//                            //后面的字母                                     //子串的长度,或者负数(表示位置)     
	$menuName = substr($fileName, 1+strrpos($fileName,"/"),strrpos($fileName,".")-strlen($fileName));
}else{
	header("location:login.php");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>非授课工作量</title>
     <link rel="stylesheet" href="assets/css/hu.css">
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href="assets/css/opensans.css" rel='stylesheet' type='text/css' />
    <script src="assets/js/jquery-1.10.2.js"></script>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">非授课工作量</a> 
            </div>
          <div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;"> 
          	 用户名:&nbsp;<?=$userName?> ,&nbsp;<?=$ro?>&nbsp; 
          	<a href="logout.php" class="btn btn-danger square-btn-adjust">退出</a> 
          </div>
        </nav>  
        <!-- /. NAV TOP  -->    
        <nav class="navbar-default navbar-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="main-menu">
			<li class="text-center"><img src="assets/img/heard.jpg"
				class="user-image img-responsive" /></li>
				<?php 
				if ($role==1){
					$selected = "work"==$menuName?'class="active-menu"':'';
					echo "<li><a $selected href='work.php'><i class='fa fa-edit fa-3x'></i>非授课工作</a></li>";
					$selected = "user"==$menuName?'class="active-menu"':'';
					echo "<li><a $selected href='user.php'><i class='fa fa-users fa-3x'></i>教师管理</a></li><li>";
					$selected = "worktype"==$menuName?'class="active-menu"':'';
					echo "<li><a $selected href='worktype.php'><i class='fa fa-folder-open-o fa-3x'></i>工作类别</a></li>";
					$selected = "department"==$menuName?'class="active-menu"':'';
					echo "<li><a $selected href='department.php'><i class='fa fa-gear fa-3x'></i>部门管理</a></li>";
					$selected = "check"==$menuName?'class="active-menu"':'';
					echo "<li><a $selected href='check.php'><i class='fa fa-check fa-3x'></i>授课量审核</a></li>	";
					$selected = "report"==$menuName?'class="active-menu"':'';
					echo "<li><a $selected href='report.php'><i class='fa fa-bar-chart fa-3x'></i>工作量统计</a></li>";					
				}else {
					$selected = "work"==$menuName?'class="active-menu"':'';
					echo "<li><a $selected href='mywork.php'><i class='fa fa-edit fa-3x'></i>非授课工作</a></li>";
					$selected = "report"==$menuName?'class="active-menu"':'';
					echo "<li><a $selected href='myreport.php'><i class='fa fa-bar-chart fa-3x'></i>工作量统计</a></li>";
				}				
				?>
		</ul>
	</div>
</nav>
 <!-- /. NAV SIDE  -->