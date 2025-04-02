<?php

include_once("database.php");

$sql="INSERT INTO `data`(`bm`,bp,fall,ox,bt) VALUES ('".$_GET['value1']."','".$_GET['value2']."','".$_GET['value3']."','".$_GET['value4']."','".$_GET['value5']."')";
$id=DataBase::ExecuteQueryReturnID($sql);
echo "data";