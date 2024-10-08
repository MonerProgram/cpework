<?php
$title = "แบบฟอร์มแก้ไขข้อมูลพนักงาน";
require_once "layout/header.php";
require_once "db/connect.php";
require_once "layout/check_admin.php";

$conn = new mysqli('localhost', 'root', '', 'cpework');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET["id"])) {
    header("Location:addfrom.php");
    exit;
} else {
    $id = $_GET["id"];
    $query = "SELECT * FROM record1 WHERE Student_id='$id'";
    $conn->set_charset("utf8");
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        $data = mysqli_fetch_assoc($query_run);
    } else {
        die("Query failed: " . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขชื่อนักศึกษา</title>
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
            <h1 class="text-center text-4xl font-semibold text-black mt-0 pt-0">แบบฟอร์มแก้ไขข้อมูล</h1>

            <div class="col-md-6 mt-0">
                <form method="POST" action="update.php" class="position-absolute top-[60%] start-50 translate-middle">
                    <br>
                    ชื่อ นามสกุล: <input type="text" name="Name" class="form-control mb-2" value="<?php echo htmlspecialchars($data['Name']); ?>">
                    รหัสนักศึกษา: <input type="text" name="Student_id" class="form-control mb-2" value="<?php echo htmlspecialchars($data['Student_id']); ?>">
                    ชื่อธนาคาร:
                    <select name="Bank_name" class="form-control mb-2">
                        <option value="" disabled hidden>เลือกธนาคาร</option>
                        <option value="ธนาคารกสิกรไทย" <?php if ($data['Bank_name'] == "ธนาคารกสิกรไทย") echo 'selected'; ?>>ธนาคารกสิกรไทย</option>
                        <option value="ธนาคารกรุงเทพ" <?php if ($data['Bank_name'] == "ธนาคารกรุงเทพ") echo 'selected'; ?>>ธนาคารกรุงเทพ</option>
                        <option value="ธนาคารกรุงศรีอยุธยา" <?php if ($data['Bank_name'] == "ธนาคารกรุงศรีอยุธยา") echo 'selected'; ?>>ธนาคารกรุงศรีอยุธยา</option>
                        <option value="ธนาคารออมสิน" <?php if ($data['Bank_name'] == "ธนาคารออมสิน") echo 'selected'; ?>>ธนาคารออมสิน</option>
                        <option value="ธนาคารกรุงไทย" <?php if ($data['Bank_name'] == "ธนาคารกรุงไทย") echo 'selected'; ?>>ธนาคารกรุงไทย</option>
                        <option value="ธนาคารทหารไทยธนชาต" <?php if ($data['Bank_name'] == "ธนาคารทหารไทยธนชาต") echo 'selected'; ?>>ธนาคารทหารไทยธนชาต</option>
                        <option value="ธนาคารซีไอเอ็มบี" <?php if ($data['Bank_name'] == "ธนาคารซีไอเอ็มบี") echo 'selected'; ?>>ธนาคารซีไอเอ็มบี</option>
                        <option value="ธนาคารไทยพาณิชย์" <?php if ($data['Bank_name'] == "ธนาคารไทยพาณิชย์") echo 'selected'; ?>>ธนาคารไทยพาณิชย์</option>
                    </select>

                    <div class="flex space-x-4 mb-2">
                        <div>
                            เลือกภาคการศึกษา:
                            <select name="department" class="form-control">
                                <option value="" disabled hidden>เลือกภาคการศึกษา</option>
                                <option value="สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรปกติ)" <?php if ($data['department'] == "สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรปกติ)") echo 'selected'; ?>>สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรปกติ)</option>
                                <option value="สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรนานาชาติ)" <?php if ($data['department'] == "สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรนานาชาติ)") echo 'selected'; ?>>สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรนานาชาติ)</option>
                                <option value="สาขาวิทยาศาสตร์ข้อมูลสุขภาพ" <?php if ($data['department'] == "สาขาวิทยาศาสตร์ข้อมูลสุขภาพ") echo 'selected'; ?>>สาขาวิทยาศาสตร์ข้อมูลสุขภาพ</option>
                                <option value="สาขาวิศวกรรมคอมพิวเตอร์(พื้นที่การศึกษาราชบุรี)" <?php if ($data['department'] == "สาขาวิศวกรรมคอมพิวเตอร์(พื้นที่การศึกษาราชบุรี)") echo 'selected'; ?>>สาขาวิศวกรรมคอมพิวเตอร์(พื้นที่การศึกษาราชบุรี)</option>
                            </select>
                        </div>
                        <div>
                            เลือกเทอม:
                            <select name="term" class="form-control">
                                <option value="" disabled hidden>เลือกเทอม</option>
                                <option value="1" <?php if ($data['term'] == "1") echo 'selected'; ?>>1</option>
                                <option value="2" <?php if ($data['term'] == "2") echo 'selected'; ?>>2</option>
                                <option value="S" <?php if ($data['term'] == "S") echo 'selected'; ?>>S</option>
                            </select>
                        </div>
                    </div>

                    เลขบัญชี: <input type="text" name="Bank_account" class="form-control mb-2" value="<?php echo htmlspecialchars($data['Bank_account']); ?>">
                    เบอร์มือถือ: <input type="text" name="Telephone" class="form-control mb-0" value="<?php echo htmlspecialchars($data['Telephone']); ?>"><br>
                    <input type="submit" class="btn btn-outline-success w-full mb-4" value="บันทึกข้อมูล">
                </form>
            </div>
        </div>
    </div>

</body>

</html>
