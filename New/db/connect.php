<?php 

$host="localhost";
$username="root";
$password="";
$db="cpework";
$dsn="mysql:host=$host;dbname=$db;charset=utf8";

try{
    $pdo = new PDO($dsn,$username,$password);
}catch(PDOException $e){
    echo $e->getMessage();
}
require_once "db/controller.php";
require_once "db/user.php";
$controller = new Controller($pdo);
$user = new User($pdo);

$result=$controller->getEmployeeDetail();
?>