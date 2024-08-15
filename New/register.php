<?php
require_once "layout/header.php";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cpework"; //ชื่อฐานข้อมูล

$conn = mysqli_connect($servername,$username,$password,$dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// รับข้อมูลพิ่มลงในฐานข้อมูล
// ตรวจสอบว่ามีข้อมูลนักศึกษาที่มีชื่อและรหัสนักศึกษาเดียวกันหรือไม่
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

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger d-flex align-items-center' role='alert'>";
        echo "<i class='bi bi-exclamation-triangle-fill'></i>";
        echo "<svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>";
        echo "<div>มีข้อมูลนักศึกษาที่มีชื่อและรหัสนักศึกษาเดียวกันในฐานข้อมูล</div>";
        echo "</div>";

    } else {
        // กระบวนการบันทึกข้อมูลลงในฐานข้อมูล
        $sql = "INSERT INTO record1 (Name, Student_id, Bank_name, Bank_account, Telephone,department,term) VALUES ('$Name', '$Student_id', '$Bank_name' ,'$Bank_account', '$Telephone','$department','$term')";

        if ($conn->query($sql) === true) {
            echo "<div class='alert alert-success d-flex align-items-center' role='alert'>";
            echo "<i class='bi bi-check-circle-fill'></i>";
            echo " <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>";
            echo "<div>บันทึกเรียบร้อย</div>";
            echo "</div>";
        } else {
            echo "การบันทึกข้อมูลลงในฐานข้อมูลล้มเหลว: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>เพิ่มข้อมูลนักเรียน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>



    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class=" position-absolute top-50 start-50 translate-middle"><br>
                    <h4>เพิ่มข้อมูลนักศึกษา</h4>
                    ชื่อ นามสกุล (ใส่คำนำหน้า): <input type="text" name="Name" class="form-control" required>
                    รหัสนักศึกษา : <input type="text" name="Student_id" class="form-control" required>
                    ชื่อธนาคาร :
                    <select name="Bank_name" class="form-control" required>
                        <option value="">เลือกธนาคาร</option>
                        <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                        <option value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                        <option value="ธนาคารกรุงศรีอยุธยา">ธนาคารกรุงศรีอยุธยา</option>
                        <option value="ธนาคารกสิกรไทย">ธนาคารออมสิน</option>
                        <option value="ธนาคารกรุงเทพ">ธนาคารกรุงไทย</option>
                        <option value="ธนาคารกรุงศรีอยุธยา">ธนาคารทหารไทยธนชาต</option>
                        <option value="ธนาคารกสิกรไทย">ธนาคารซีไอเอ็มบี</option>
                        <option value="ธนาคารกรุงเทพ">ธนาคารไทยพาณิชย์</option>
                    </select>

                    เลือกภาคการศึกษา :
                    <select name="department" class="form-control" required>
                        <option value="">เลือกภาคการศึกษา</option>
                        <option value="สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรปกติ)">สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรปกติ)</option>
                        <option value="สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรนานาชาติ)">สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรนานาชาติ)</option>
                        <option value="สาขาวิทยาศาสตร์ข้อมูลสุขภาพ">สาขาวิทยาศาสตร์ข้อมูลสุขภาพ</option>
                        <option value="สาขาวิศวกรรมคอมพิวเตอร์(พื้นที่การศึกษาราชบุรี)">สาขาวิศวกรรมคอมพิวเตอร์(พื้นที่การศึกษาราชบุรี)</option>
                    </select>

           <select name="term" class="form-control" >
              <option value="">เลือกเทอม</option>
              <option value="1">1</option>
            <option value="2">2</option>
           <option value="S">S</option>
           </select>


                    เลขบัญชี : <input type="text" name="Bank_account" class="form-control" required>
                    เบอร์มือถือ : <input type="text" name="Telephone" class="form-control" required><br>
                    <input type="submit" class="btn btn-outline-success" value="บันทึกข้อมูล">
                </form>
            </div>
        </div>
    </div>


</body>

</html>