<?php 
require_once "db/connect.php";

if(!isset($_GET["id"])){
    header("Location:addfrom.php");
}
else{
    $id=$_GET["id"];
    $result=$controller->delete1($id);
    if($result){
        header("Location:head.php");
    }
}

?>