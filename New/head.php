<?php
require_once "layout/header.php";
require_once "db/connect.php";
require_once "layout/check_admin.php";
require_once "layout/check.php";
require_once "layout/session.php";
$result = $controller->getEmployeeDetail();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <title>รายชื่อของพนักงานทั้งหมด</title>
    <style>
        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>รายชื่อพนักงาน</h1>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Student ID</th>
                <th>Bank Name</th>
                <th>Bank Account</th>
                <th>Telephone</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = mysqli_connect('localhost', 'root', '', 'cpework');
            if (mysqli_connect_error()) {
                echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
                exit();
            }
            mysqli_set_charset($conn, 'utf8');

            $query = "SELECT * FROM record1";
            $result = mysqli_query($conn, $query);

            $idquery = "SELECT * FROM record";
            $idresult = mysqli_query($conn, $query);
            $counter = 1;
            ?>

            <?php foreach ($result as $row) { ?>
                <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Student_id']; ?></td>
                    <td><?php echo $row['Bank_name'] ?> </td>
                    <td><?php echo $row["Bank_account"] ?></td>
                    <td><?php echo $row["Telephone"] ?></td>
                    <td><?php echo $row["department"] . "  เทอม " . $row["term"] ?></td>
                    <td> <a href="realsubhead.php?id=<?php echo $row["Student_id"] ?>">ข้อมูลพนักงาน</a></td>
                    <td> <a onclick="return confirm('คุณต้องการแก้ไขข้อมูลหรือไม่ ?')" href="edit_employee.php?id=<?php echo $row["Student_id"]; ?>" class="btn btn-warning">แก้ไขข้อมูล</a></td>
                    <td> <a onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" href="deletereal.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">ลบข้อมูล</a></td>
                </tr>
            <?php $counter++;
            }  ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>