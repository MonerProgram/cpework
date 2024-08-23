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

$message = "";
$modalType = "";

// ตรวจสอบว่ามี user ซ้ำกันหรือเปล่า
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $user_password = $_POST["user_password"];
    mysqli_set_charset($conn, 'utf8');
    $new_password = md5($user_password . $user_id);
    $sql = "SELECT * FROM users WHERE user_id='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $message = "มีข้อมูลนักศึกษาที่มีชื่อและรหัสนักศึกษาเดียวกันในระบบ";
        $modalType = "danger";
    } else {
        $sql = "INSERT INTO users (user_id, user_password) VALUES ('$user_id', '$new_password')";
        if ($conn->query($sql) === true) {
            $message = "บันทึกเรียบร้อย";
            $modalType = "success";
        } else {
            $message = "การบันทึกข้อมูลลงในฐานข้อมูลล้มเหลว: " . $conn->error;
            $modalType = "danger";
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
            window.location.href = 'login.php'; // เปลี่ยนที่นี่เป็น URL ของหน้า login ของคุณ
        });
    </script>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://scontent-xsp1-1.xx.fbcdn.net/v/t1.15752-9/354780589_809389650329623_8389356405749328912_n.png?_nc_cat=105&ccb=1-7&_nc_sid=ae9488&_nc_eui2=AeEqZN6E7nkuo9_Srb0Xa1HsU2ezQNG-XE1TZ7NA0b5cTe4QHCgg5hUlsLB93YkdJskMEwmQtMhkrSo8k-KACwSX&_nc_ohc=KN4031rutaoAX9Qucua&_nc_ht=scontent-xsp1-1.xx&oh=03_AdSY9bQ2f2S7aJJtFp-x98gDnV2ZpbMS-Iu1veoEmQ7CTw&oe=64B38CCD">
    <title>Register</title>
    <link rel="stylesheet" href="stylelog.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="https://www.linknacional.com.br/wp-content/uploads/2021/03/html-icon-480x480.png" type="image/x-icon">
    <style>
        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            width: 100%;
            padding-right: 30px;
            /* Adjust based on the size of the icon */
        }

        .password-container i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
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

                            <input type="text" name="user_id" placeholder="Student ID " class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="password-container input-field flex items-center justify-center">

                            <input type="password" id="user_password" name="user_password" placeholder="รหัสผ่าน" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i id="togglePassword" class="fas fa-eye"></i>
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
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            var passwordField = document.getElementById('user_password');
            var type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>