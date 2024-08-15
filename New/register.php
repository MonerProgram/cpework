<?php
require_once "layout/header.php";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cpework"; //ชื่อฐานข้อมูล

$conn = mysqli_connect($servername, $username, $password, $dbname);

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลนักศึกษา</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>
</head>

<body>

    <div class="container">
        <div class="row">
            <h1 class="text-center text-4xl font-semibold text-black  mt-0 pt-0 ">เพิ่มข้อมูลนักศึกษา</h1>

            <div class="col-md-6 mt-0">
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class=" position-absolute top-[60%] start-50 translate-middle"><br>
                    <br>
                    ชื่อ นามสกุล: <input type="text" name="Name" class="form-control mb-2" required>
                    รหัสนักศึกษา: <input type="text" name="Student_id" class="form-control mb-2" required>
                    ชื่อธนาคาร:
                    <select name="Bank_name" class="form-control mb-2">
                        <option value="" disabled selected hidden>เลือกธนาคาร</option>
                        <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                        <option value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                        <option value="ธนาคารกรุงศรีอยุธยา">ธนาคารกรุงศรีอยุธยา</option>
                        <option value="ธนาคารออมสิน">ธนาคารออมสิน</option>
                        <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                        <option value="ธนาคารทหารไทยธนชาต">ธนาคารทหารไทยธนชาต</option>
                        <option value="ธนาคารซีไอเอ็มบี">ธนาคารซีไอเอ็มบี</option>
                        <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                    </select>

                    <div class="flex space-x-4 mb-2">
                        <div>
                            เลือกภาคการศึกษา:
                            <select name="department" class="form-control">
                                <option value="" disabled selected hidden>เลือกภาคการศึกษา</option>
                                <option value="สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรปกติ)">สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรปกติ)</option>
                                <option value="สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรนานาชาติ)">สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรนานาชาติ)</option>
                                <option value="สาขาวิทยาศาสตร์ข้อมูลสุขภาพ">สาขาวิทยาศาสตร์ข้อมูลสุขภาพ</option>
                                <option value="สาขาวิศวกรรมคอมพิวเตอร์(พื้นที่การศึกษาราชบุรี)">สาขาวิศวกรรมคอมพิวเตอร์(พื้นที่การศึกษาราชบุรี)</option>
                            </select>
                        </div>
                        <div>
                            เลือกเทอม:
                            <select name="term" class="form-control">
                                <option value="" disabled selected hidden>เลือกเทอม</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="S">S</option>
                            </select>
                        </div>
                    </div>

                    เลขบัญชี: <input type="text" name="Bank_account" class="form-control mb-2">
                    เบอร์มือถือ: <input type="text" name="Telephone" class="form-control mb-0"><br>
                    <input type="submit" class="btn btn-outline-success w-full mb-4" value="บันทึกข้อมูล">
                </form>
            </div>
        </div>
    </div>

</body>

</html>