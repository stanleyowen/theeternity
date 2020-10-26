<?php
include('../global-validation/security-crud.php');

$id 	= mysqli_real_escape_string($connect, $_POST['id']);
$rank 	= mysqli_real_escape_string($connect, $_POST['rank']);
$name 	= mysqli_real_escape_string($connect, $_POST['name']);
$link 	= mysqli_real_escape_string($connect, $_POST['link']);

$sql = "INSERT INTO certificate (id, squad_name, link, rank) VALUES ('$id','$name','<a href=".$link.">Click Here</a>','$rank');";

if ($connect->query($sql) === TRUE) {
  echo '<script>alert("Record Added Successfully!");window.history.back();</script>';
} else {
  echo '<script>alert("Error, cannot add the record. Please try again!");window.history.back();</script>';
}

$connect->close();
?>