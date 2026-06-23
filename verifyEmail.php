<?php
include 'connection.php';
$pdo = pdo_connect_mysql();
session_start();  
$email=$_SESSION['verifymail'];
$stmt = $pdo->prepare('UPDATE user SET banned = ? WHERE email = ?');
$stmt->execute([0,$email]);
$_SESSION['Goverify']="Registration successful";
header("Location: http://localhost/CNH-2/signin.php");
exit;
?>