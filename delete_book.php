php
<?php 
include('include/dbcon.php');
$get_id = $_GET['book_id'];
$stmt = mysqli_prepare($con, "DELETE FROM book WHERE book_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $get_id);
mysqli_stmt_execute($stmt) or die(mysqli_error($con));
header('location:book.php');	
?>