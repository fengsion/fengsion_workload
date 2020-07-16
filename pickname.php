<html>
<head>
<title>new</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>非授课工作量管理系统</title>
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

<script>
function getdata(data)
{
    window.opener.document.getElementById("teacherId").value = data;
    window.close();
}
</script>
</head>
<body>
<div class="row">
<div class="panel-body"> 
<?php 
//查询大类
include_once 'dbconfig.php';
$queryType = "select * from user";
$queryTypeObject = $pdo->prepare($queryType);
$queryTypeObject->execute();
$users = $queryTypeObject->fetchAll();
foreach ($users as $user){
    $username = $user["username"];
    $role = $user["role"];
    $name = $user["name"];
    echo "<a href='javascript:getdata(\"$username\")' class=\"btn btn-info btn-sm\">$name</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
?>
</div>
</div>
</body>
</html>