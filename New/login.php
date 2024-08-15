<?php
    $title="แบบฟอร์มลงชื่อเข้าใช้";
    require_once "layout/header.php";
    require_once "db/connect.php";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $user_id = $_POST["user_id"];
        $user_password = $_POST["user_password"];
        $new_password = md5($user_password.$user_id);
        $result=$user->getUser($user_id,$new_password);

        if(!$result){
            echo '<div class="alert alert-danger">ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง</div>';
        }else{
            $_SESSION["user_id"]=$user_id;
            $_SESSION["user_password"]=$result["id"];
            header("Location:addfrom.php");
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
    <title>Login</title>
    <link rel="stylesheet" href="stylelog.css">
</head>
<body>
    <main>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" method="post">
        <div class="row">
            <div class="colm-logo">
                <img src="cpe.ico" alt="Logo">
            </div>
            <div class="colm-form">
                <div class="form-container">
                    <input type="text" name="user_id" value="<?php if($_SERVER["REQUEST_METHOD"]=="POST")echo $_POST["user_id"]?>" placeholder="Student ID">
                    <input type="password" name="user_password" placeholder="Password">
                    <button class="btn-login">Login</button>
                    <p><span class="icon icon--info"></span><a href="register1.php">Register</a></p>
                </div>
            </div>
        </div>
        </form>
    </main>
    
</body>
</html>