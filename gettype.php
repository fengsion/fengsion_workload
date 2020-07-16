<?php
header("content-type:text/html;charset=utf-8");
$bigtype = $_GET["bigtype"];
include_once 'dbconfig.php';
$data = array("bigType"=>$bigtype);
$statement = "select distinct typeName from worktype where bigType=:bigType";
$statmentObject = $pdo->prepare($statement);
$statmentObject->execute($data);
$typeName = $statmentObject->fetchAll();
//输出响应
echo json_encode($typeName);
?>