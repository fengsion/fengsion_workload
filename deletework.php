<?php
if(filter_input(INPUT_GET, 'id')){
    include_once 'dbconfig.php';
    $id = $_GET['id'];
    $ch = $_GET['ch'];
    $data = array(
        "id"=>$id,
    );
    $statement = "delete from work where id=:id";
    $statementObject =  $pdo->prepare($statement);
    $result = $statementObject->execute($data);
    if($result){
        if($ch==1) header("location:jump.php?error=数据删除成功&url=check.php&wait=3");
        else header("location:jump.php?error=数据删除成功&url=work.php&wait=3");
    }else{
        if($ch==1) header("location:jump.php?error=数据删除失败&url=check.php&wait=3");
        else header("location:jump.php?error=数据删除失败&url=work.php&wait=3");
    }
    exit();
}