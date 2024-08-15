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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://scontent-xsp1-1.xx.fbcdn.net/v/t1.15752-9/354780589_809389650329623_8389356405749328912_n.png?_nc_cat=105&ccb=1-7&_nc_sid=ae9488&_nc_eui2=AeEqZN6E7nkuo9_Srb0Xa1HsU2ezQNG-XE1TZ7NA0b5cTe4QHCgg5hUlsLB93YkdJskMEwmQtMhkrSo8k-KACwSX&_nc_ohc=KN4031rutaoAX9Qucua&_nc_ht=scontent-xsp1-1.xx&oh=03_AdSY9bQ2f2S7aJJtFp-x98gDnV2ZpbMS-Iu1veoEmQ7CTw&oe=64B38CCD">
    <title>Register</title>
    <link rel="stylesheet" href="stylelog.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="https://www.linknacional.com.br/wp-content/uploads/2021/03/html-icon-480x480.png" type="image/x-icon">

</head>

<body>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="row">
            <div class="colm-form">
                <div class="form-container">
                    <h2 class="text-center text-3xl font-bold mt-3">Sign Up</h2>
                    <h4 class="text-center text-xl font-thin mb-3">ลงทะเบียน</h4>
                    <div class="">
                        <div class="input-field flex items-center justify-center">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="user_id" placeholder="Student_id " class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="input-field flex items-center justify-center">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="user_password" placeholder="Password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="btn-field">
                        <input type="submit" name="submit" value="Sign Up" class="bg-sky-400 text-white rounded-lg text-lg font-semibold w-2/4 cursor-pointer hover:bg-blue-600">

                        <button type="button"><a href="login.php">Login</a></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>