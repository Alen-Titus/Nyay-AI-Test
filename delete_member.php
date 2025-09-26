php
<?php 

include('include/dbcon.php');

$get_id = $_GET['user_id'];

$stmt = $con->prepare("DELETE FROM user WHERE user_id = ?");
$stmt->bind_param("i", $get_id);
$stmt->execute();

header('location:member.php');
?>