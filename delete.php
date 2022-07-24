<?php
require "base.php";
$id = $_GET['id'];
$sql = "SELECT * FROM contact_list WHERE id='$id'";
$query = mysqli_query(con(), $sql);
$row = mysqli_fetch_assoc($query);
unlink($row['photo']);
$sql = "DELETE FROM contact_list WHERE id='$id'";
if(mysqli_query(con(), $sql)){
    echo "success";
};

