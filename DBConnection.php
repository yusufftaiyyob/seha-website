<?php
  $conn = mysqli_connect('localhost','root','','systemdb');
  
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error."<br>");
  }
?>