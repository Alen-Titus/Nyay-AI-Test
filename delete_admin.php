php
<?php 
include('include/dbcon.php');
$get_id = $_GET['admin_id'];
$stmt = $con->prepare("DELETE FROM admin WHERE admin_id = ?");
$stmt->bind_param("i", $get_id);
$stmt->execute();
header('location:admin.php');	
?>