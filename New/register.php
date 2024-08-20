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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST["Name"];
    $Student_id = $_POST["Student_id"];
    $Bank_name = $_POST["Bank_name"];
    $Bank_account = $_POST["Bank_account"];
    $Telephone = $_POST["Telephone"];
    $department = $_POST["department"];
    $term = $_POST["term"];

    // ตรวจสอบว่ากรอกข้อมูลครบถ้วนหรือไม่
    if (empty($Name) || empty($Student_id) || empty($Bank_name) || empty($Bank_account) || empty($Telephone) || empty($department) || empty($term)) {
        $message = "กรุณากรอกข้อมูลให้ครบถ้วน";
        $modalType = "danger";
    } else {
        // ตรวจสอบว่ามีข้อมูลนักศึกษาที่มีชื่อและรหัสนักศึกษาเดียวกันหรือไม่
        mysqli_set_charset($conn, 'utf8');
        $sql = "SELECT * FROM record1 WHERE Name = '$Name' AND Student_id = '$Student_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $message = "มีข้อมูลนักศึกษาที่มีชื่อและรหัสนักศึกษาเดียวกันในระบบ";
            $modalType = "danger";
        } else {
            $sql = "INSERT INTO record1 (Name, Student_id, Bank_name, Bank_account, Telephone, department, term) 
            VALUES ('$Name', '$Student_id', '$Bank_name', '$Bank_account', '$Telephone', '$department', '$term')";
            echo $sql;
            if ($conn->query($sql) === true) {
                $message = "บันทึกเรียบร้อย";
                $modalType = "success";

            } else {
                $message = "การบันทึกข้อมูลลงในฐานข้อมูลล้มเหลว: " . $conn->error;
                $modalType = "danger";
            }
        }
    }
}
?>
<!-- HTML ส่วนแสดงผล -->
<?php if (!empty($message)): ?>
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">
                        <?php echo ($modalType == "success") ? "สำเร็จ" : "เกิดข้อผิดพลาด"; ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $message; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-<?php echo $modalType; ?>" data-bs-dismiss="modal" id="closeModalBtn">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        messageModal.show();

        document.getElementById('closeModalBtn').addEventListener('click', function() {
            window.location.href = 'addfrom.php'; // เปลี่ยนที่นี่เป็น URL ของหน้า login ของคุณ
        });
    </script>
<?php endif; ?>
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>
</head>

<body>

    <div class="container">
        <div class="row">
            <h1 class="text-center text-4xl font-semibold text-black mt-0 pt-0">เพิ่มข้อมูลนักศึกษา</h1>

            <div class="col-md-6 mt-0">
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="position-absolute top-[60%] start-50 translate-middle"><br>
                    <br>
                    ชื่อ นามสกุล: <input type="text" name="Name" class="form-control mb-2">
                    รหัสนักศึกษา: <input type="text" name="Student_id" class="form-control mb-2">
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
                            <select name="term" class="form-control mb-2">
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