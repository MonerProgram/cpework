<?php
$title = "แบบฟอร์มลงชื่อเข้าใช้";
require_once "layout/header.php";
require_once "db/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $user_password = $_POST["user_password"];
    $new_password = md5($user_password . $user_id);

    // ตรวจสอบผู้ใช้
    $result = $user->getUser($user_id, $new_password);

    if (!$result) {
        $message = "รหัสผ่านไม่ถูกต้อง";
        $modalType = "danger";
    } else {
        $_SESSION["user_id"] = $user_id;
        $_SESSION["user_password"] = $result["id"];

        // เปลี่ยนเส้นทางตาม user_id
        if ($user_id === 'admin') {
            header("Location: head.php");
        } else {
            header("Location: addfrom.php");
        }
        exit();
    }
}
?> <!-- ต้องแก้จากตรงนี้ ต้องแบ่งให้ แอดมิน loca ไป head ผู้ใช้ loca ไป addfrom -->
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://scontent-xsp1-1.xx.fbcdn.net/v/t1.15752-9/354780589_809389650329623_8389356405749328912_n.png?_nc_cat=105&ccb=1-7&_nc_sid=ae9488&_nc_eui2=AeEqZN6E7nkuo9_Srb0Xa1HsU2ezQNG-XE1TZ7NA0b5cTe4QHCgg5hUlsLB93YkdJskMEwmQtMhkrSo8k-KACwSX&_nc_ohc=KN4031rutaoAX9Qucua&_nc_ht=scontent-xsp1-1.xx&oh=03_AdSY9bQ2f2S7aJJtFp-x98gDnV2ZpbMS-Iu1veoEmQ7CTw&oe=64B38CCD">
    <title>Login</title>
    <link rel="stylesheet" href="stylelog.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
    <main>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="row">
                <div class="colm-logo">
                    <img src="cpe.ico" alt="Logo">
                </div>
                <div class="colm-form">
                    <div class="form-container">
                        <input type="text" name="user_id" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") echo $_POST["user_id"] ?>" placeholder="Student ID">
                        <div class="password-container">
                            <input type="password" id="user_password" name="user_password" placeholder="Password">
                            <i id="togglePassword" class="fas fa-eye"></i>
                        </div>

                        <button class="btn-login">Login</button>
                        <p><span class="icon icon--info"></span><a href="register1.php">Register</a></p>
                    </div>
                </div>
            </div>
        </form>
    </main>
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