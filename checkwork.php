<?php
include_once 'dbconfig.php';
include_once 'base.php';
$id = $_POST['id'];
$sta = $_POST['sta'];
$reason =  $_POST['reason'];
if($id){
    if($sta == 1){
        $data = array(
            "id" => $id,
            "status"=>'确认'
        );
        $statement = "UPDATE work SET status=:status WHERE id = :id";
    }elseif($sta == 2){
        $data = array(
            "id" => $id,
            "status"=>'拒绝',
            "reason"=>$reason
        );
        $statement = "UPDATE work SET status=:status,reason=:reason WHERE id = :id";
    }
    $statementObject = $pdo->prepare($statement);
    $result = $statementObject->execute($data);
    if ($result){
        header("location:jump.php?error=审核成功&url=check.php&wait=3");
    } else {
        header("location:jump.php?error=审核失败&url=check.php&wait=3");
    }
    exit();
}else{
    header("location:check.php");
}
?>