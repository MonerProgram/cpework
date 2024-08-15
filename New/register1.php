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
    $user_id = $_POST["user_id"];
    $user_password = $_POST["user_password"];
    mysqli_set_charset($conn, 'utf8');
    $new_password = md5($user_password . $user_id);
    $sql = "SELECT * FROM users WHERE user_id='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger d-flex align-items-center' role='alert'>";
        echo "<i class='bi bi-exclamation-triangle-fill'></i>";
        echo "<svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>";
        echo "<div>มีข้อมูลนักศึกษาที่มีชื่อและรหัสนักศึกษาเดียวกันในฐานข้อมูล</div>";
        echo "</div>";

    } else {
        // กระบวนการบันทึกข้อมูลลงในฐานข้อมูล
        $new_password = md5($user_password . $user_id);
        $sql = "INSERT INTO users (user_id,user_password) VALUES ('$user_id','$new_password')";
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
    <link rel="stylesheet" href="style12.css">
    <script src="https://kit.fontawesome.com/5ac6f35790.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="https://www.linknacional.com.br/wp-content/uploads/2021/03/html-icon-480x480.png" type="image/x-icon">
    <title>easy sign in form</title>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1>SIGN UP</h1>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="input-group">
                    <div class="input-field">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="user_id" placeholder="Student_id ">
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="user_password" placeholder="Password">
                    </div>
                </div>
                <div class="btn-field">
                    <input type="submit" name="submit" value="Sign up" class="btn btn-primary my-3">
                    <button type="button"><a href="login.php">Login</a></button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
