<?php
header("content-type:text/html;charset=utf-8");
$typeName = $_GET["typeName"];
include_once 'dbconfig.php';
$data = array("typeName"=>$typeName);
$statement = "select distinct rank from worktype where typeName=:typeName";
$statmentObject = $pdo->prepare($statement);
$statmentObject->execute($data);
$rankName = $statmentObject->fetchAll();
//输出响应
echo json_encode($rankName);
?>