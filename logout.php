<?php 

session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('id','',time() - 360);
setcookie('key','',time() - 360);


header("Location: login.php");
exit;

?>