<?php

include_once('common/base.php');

//if the user is not logged in
if(empty($_SESSION['user_id'])){
	header('Location: ./signup.php');
	exit;
}else{
	header('Location: ./account.php');
	exit;
}
?>
