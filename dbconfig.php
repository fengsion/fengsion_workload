<?php
header("content-type:text/html;charset=utf-8");
$dsn="mysql:dbname=workload;host=localhost;charset=utf8";  
$db_user='root';  
$db_pass='';  
try{  
    //如果试图连接到请求的数据库失败，则PDO::__construct() 抛出一个 PDO异常（PDOException）
    $pdo  =new PDO($dsn,$db_user,$db_pass);
    //$pdo->exec("set names utf8");
    //PDO提供了三种不同的错误处理模式，以满足不同风格的应用开发
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){  
    echo '数据库连接失败'.$e->getMessage();  
}  
?>
