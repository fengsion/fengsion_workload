<?php
if(filter_input(INPUT_GET, 'id')){
    include_once 'dbconfig.php';
    $id = $_GET['id'];
    $data = array(
        "id"=>$id,
    );
    $statement = "delete from user where id=:id";
    $statementObject =  $pdo->prepare($statement);
    $result = $statementObject->execute($data);
    if($result){
        header("location:jump.php?error=数据删除成功&url=user.php&wait=3");
    }else{
        header("location:jump.php?error=数据删除失败&url=user.php&wait=3");
    }
    exit();
}