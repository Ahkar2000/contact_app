<?php
require_once "base.php";

$id = $_GET['id'];
$sql = "SELECT * FROM contact_list WHERE id='$id'";
$query = mysqli_query(con(), $sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);