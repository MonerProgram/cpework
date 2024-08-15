<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cpework"; //ชื่อฐานข้อมูล

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST["Name"];
    $Student_id = $_POST["Student_id"];
    $Bank_name = $_POST["Bank_name"];
    $Bank_account = $_POST["Bank_account"];
    $Telephone = $_POST["Telephone"];
    $department = $_POST["department"];
    $term = $_POST["term"];
    mysqli_set_charset($conn, 'utf8');
    $sql = "SELECT * FROM record1 WHERE Name = '$Name' AND Student_id = '$Student_id'";
    $result = $conn->query($sql);

        $sql = "UPDATE record1 SET Name = '$Name', Bank_name = '$Bank_name', Bank_account = '$Bank_account', Telephone = '$Telephone' , department = '$department' ,term = '$term' WHERE Student_id = '$Student_id'";

        if ($conn->query($sql) === true) {
          header("Location:head.php");
        } else {
            echo "การบันทึกข้อมูลลงในฐานข้อมูลล้มเหลว: " . $conn->error;
        }
}
?>