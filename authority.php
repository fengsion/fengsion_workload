<?php
function getTeacherAuthority(){
	session_start();
	if(isset($_SESSION['authority'])){
		$authority = $_SESSION['authority'];
		$userName = $authority['userName'];
		$role = $authority['role'];
		if($role!=1){
			header("location:login.php");
		}
		return $userName;
	}else {
		header("location:login.php");
	}
}

function getManageAuthority(){
	session_start();
	if(isset($_SESSION['authority'])){
		$authority = $_SESSION['authority'];
		$userName = $authority['userName'];
		$role = $authority['role'];
		if($role!=1){
			header("location:login.php");
		}
		return $userName;
	}else {
		header("location:login.php");
	}
	
}
?>