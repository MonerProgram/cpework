<?php
require_once "db/connect.php";
require_once "layout/session.php"; // โหลด session เพื่อดึงข้อมูล role

if (!isset($_GET["id"])) {
    header("Location: addfrom.php");
    exit();
} else {
    $id = $_GET["id"];
    $result = $controller->delete($id);
    if ($result) {
        // ตรวจสอบว่าเป็นแอดมินหรือไม่
        if ($_SESSION['user_id'] === "admin") {
            header("Location: realsubhead.php?message=deleted"); // ถ้าเป็นแอดมิน ให้อยู่ที่หน้า realsubhead.php
        } else {
            header("Location: subhead.php?message=deleted"); // ถ้าไม่ใช่ ให้ไปที่หน้า subhead.php
        }
        exit();
    }
}
