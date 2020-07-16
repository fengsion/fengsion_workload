<?php
header("content-type:text/html;charset=utf-8");
$typeName = $_GET["typeName"];
$rank = $_GET["rank"];
include_once 'dbconfig.php';
$data = array(
    "typeName" => $typeName,
    "rank" => $rank
);
$statement = "select distinct classHour,price from worktype where typeName=:typeName and rank=:rank";
$statmentObject = $pdo->prepare($statement);
$statmentObject->execute($data);
$limitRange = $statmentObject->fetch();
//输出响应
echo json_encode($limitRange);
?>