<?php
$title = "หน้าแรกของเว็บไซต์";
require_once "layout/header.php";
require_once "db/connect.php";
require_once "layout/check_admin.php";
require_once "layout/session.php";
$conn = new mysqli('localhost', 'root', '', 'cpework');
if (isset($_POST['submit'])) {
  $timestart_morning = $_POST['timestart_morning'];
  $timeend_morning = $_POST['timeend_morning'];
  $timestart_noon = $_POST['timestart_noon'];
  $timeend_noon = $_POST['timeend_noon'];
  $work = $_POST['work'];
  $work_detail = $_POST['work_detail'];
  $dates = date('Y-m-d', strtotime($_POST['dates']));
  // ตรวจสอบว่ามีการกรอกข้อมูลครบถ้วนหรือไม่
  if (empty($timestart_morning) || empty($timeend_morning) || empty($timestart_noon) || empty($timeend_noon) || empty($work) || empty($work_detail)) {
    echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน');</script>";
    exit;
  }
  $t1 = strtotime($timestart_morning);
  $t2 = strtotime($timeend_morning);
  $h1 = round(abs($t2 - $t1) / 3600, 2);
  $t3 = strtotime($timestart_noon);
  $t4 = strtotime($timeend_noon);
  $h2 = round(abs($t4 - $t3) / 3600, 2);
  $result = $h1 + $h2;
  $Time = $result;
  mysqli_set_charset($conn, 'utf8');
  $sql = "SELECT user_id FROM users";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    if ($_SESSION['user_id'] === $row['user_id']) {
      $user_id = $_SESSION["user_id"];
      $Student_id = $row["user_id"];
      $conn->set_charset("utf8");
      $isWithinNoonRange = ($t1 >= strtotime('12:00') && $t2 <= strtotime('13:00')) || ($t3 >= strtotime('12:00') && $t4 <= strtotime('13:00'));
      if ($isWithinNoonRange || $Time > 6) {
        $message = "ไม่สามารถบันทึกข้อมูลในช่วงเวลา 12:00 โมง - 13:00 โมงได้ หรือ ไม่สามารถบันทึกชั่วโมงงานเกิน 6 ได้";
        require_once "layout/error_message.php";
      } else {
        $query = "INSERT INTO record (timestart_morning,timeend_morning,timestart_noon,timeend_noon,work,work_detail,dates,Time,user_id)
            VALUES ('$timestart_morning','$timeend_morning','$timestart_noon','$timeend_noon','$work','$work_detail','$dates','$Time','$row[user_id]')";
        $query_run = mysqli_query($conn, $query);
        if ($query_run) {
          $message = "บันทึกข้อมูลเรียบร้อย";
          require_once "layout/success_message.php";
        } else {
          $message = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
          require_once "layout/error_message.php";
        }
      }

?>
<?php }
  }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
    $(function() {
      $("#datepicker").datepicker();
    });
  </script>
</head>

<body>
  <?php
  ?>

  <form method="POST" action="addfrom.php">
    <table class="table table-dark text-center">
      <tr>
        <td class="col col-lg-1">ลำดับ</td>
        <td class="col col-lg-2">วันที่ปฏิบัติงาน</td>
        <td class="col col-lg-2">เวลาปฏิบัติงานช่วงที่ 1</td>
        <td class="col col-lg-2">เวลาปฏิบัติงานช่วงที่ 2</td>
        <td class="col col-lg-0">ชั่วโมง</td>
        <td colspan="2">ลักษณะงานที่ปฏิบัติ</td>
      </tr>
      <tbody class="text-center">
        <tr class="table table-dark">
          <td colspan="2"></td>
          <td>เวลามา เวลากลับ</td>
          <td>เวลามา เวลากลับ</td>
          <td class="col col-lg-1">ปฏิบัติงาน</td>
          <td colspan="3">รายละเอียดการปฏิบัติงาน</td>
        </tr>

        <div class="1">
          <tr class="table-active">
            <td> <?php echo "1" ?>
            </td>
            <td>
              <input type="text" name="dates" id="datepicker">
            </td>
            </td>
            <div>
              <td>
                <select class="col col-lg-4" name="timestart_morning" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") echo $_POST["timestart_morning"] ?>">
                  <option selected>เลือกเวลา</option>
                  <option value="8:00">8:00</option>
                  <option value="8:30">8:30</option>
                  <option value="9:00">9:00</option>
                  <option value="9:30">9:30</option>
                  <option value="10:00">10:00</option>
                  <option value="10:30">10:30</option>
                  <option value="11:00">11:00</option>
                  <option value="11:30">11:30</option>
                  <option value="12:00">12:00</option>
                  <option value="12:30">12:30</option>
                  <option value="13:00">13:00</option>
                  <option value="13:30">13:30</option>
                  <option value="14:00">14:00</option>
                  <option value="14:30">14:30</option>
                  <option value="15:00">15:00</option>
                  <option value="15:30">15:30</option>
                  <option value="16:00">16:00</option>
                  <option value="16:30">16:30</option>
                  <option value="17:00">17:00</option>
                  <option value="17:30">17:30</option>
                  <option value="18:00">18:00</option>
                  <option value="18:30">18:30</option>
                  <option value="19:00">19:00</option>
                  <option value="19:30">19:30</option>
                  <option value="20:00">20:00</option>
                  <option value="20:30">20:30</option>
                  <option value="21:00">21:00</option>

                </select>

                <select class="col col-lg-4" name="timeend_morning" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") echo $_POST["timeend_morning"] ?>">
                  <option selected>เลือกเวลา</option>
                  <option value="8:00">8:00</option>
                  <option value="8:30">8:30</option>
                  <option value="9:00">9:00</option>
                  <option value="9:30">9:30</option>
                  <option value="10:00">10:00</option>
                  <option value="10:30">10:30</option>
                  <option value="11:00">11:00</option>
                  <option value="11:30">11:30</option>
                  <option value="12:00">12:00</option>
                  <option value="12:30">12:30</option>
                  <option value="13:00">13:00</option>
                  <option value="13:30">13:30</option>
                  <option value="14:00">14:00</option>
                  <option value="14:30">14:30</option>
                  <option value="15:00">15:00</option>
                  <option value="15:30">15:30</option>
                  <option value="16:00">16:00</option>
                  <option value="16:30">16:30</option>
                  <option value="17:00">17:00</option>
                  <option value="17:30">17:30</option>
                  <option value="18:00">18:00</option>
                  <option value="18:30">18:30</option>
                  <option value="19:00">19:00</option>
                  <option value="19:30">19:30</option>
                  <option value="20:00">20:00</option>
                  <option value="20:30">20:30</option>
                  <option value="21:00">21:00</option>

                </select>

              </td>
              <td>
                <select class="col col-lg-4" name="timestart_noon" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") echo $_POST["timestart_noon"] ?>">
                  <option selected>เลือกเวลา</option>
                  <option value="8:00">8:00</option>
                  <option value="8:30">8:30</option>
                  <option value="9:00">9:00</option>
                  <option value="9:30">9:30</option>
                  <option value="10:00">10:00</option>
                  <option value="10:30">10:30</option>
                  <option value="11:00">11:00</option>
                  <option value="11:30">11:30</option>
                  <option value="12:00">12:00</option>
                  <option value="12:30">12:30</option>
                  <option value="13:00">13:00</option>
                  <option value="13:30">13:30</option>
                  <option value="14:00">14:00</option>
                  <option value="14:30">14:30</option>
                  <option value="15:00">15:00</option>
                  <option value="15:30">15:30</option>
                  <option value="16:00">16:00</option>
                  <option value="16:30">16:30</option>
                  <option value="17:00">17:00</option>
                  <option value="17:30">17:30</option>
                  <option value="18:00">18:00</option>
                  <option value="18:30">18:30</option>
                  <option value="19:00">19:00</option>
                  <option value="19:30">19:30</option>
                  <option value="20:00">20:00</option>
                  <option value="20:30">20:30</option>
                  <option value="21:00">21:00</option>
                </select>

                <select class="col col-lg-4" name="timeend_noon" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") echo $_POST["timeend_noon"] ?>">
                  <option selected>เลือกเวลา</option>
                  <option value="8:00">8:00</option>
                  <option value="8:30">8:30</option>
                  <option value="9:00">9:00</option>
                  <option value="9:30">9:30</option>
                  <option value="10:00">10:00</option>
                  <option value="10:30">10:30</option>
                  <option value="11:00">11:00</option>
                  <option value="11:30">11:30</option>
                  <option value="12:00">12:00</option>
                  <option value="12:30">12:30</option>
                  <option value="13:00">13:00</option>
                  <option value="13:30">13:30</option>
                  <option value="14:00">14:00</option>
                  <option value="14:30">14:30</option>
                  <option value="15:00">15:00</option>
                  <option value="15:30">15:30</option>
                  <option value="16:00">16:00</option>
                  <option value="16:30">16:30</option>
                  <option value="17:00">17:00</option>
                  <option value="17:30">17:30</option>
                  <option value="18:00">18:00</option>
                  <option value="18:30">18:30</option>
                  <option value="19:00">19:00</option>
                  <option value="19:30">19:30</option>
                  <option value="20:00">20:00</option>
                  <option value="20:30">20:30</option>
                  <option value="21:00">21:00</option>

                </select>
                <?php
                // บรรทัดนี้จะปิดการแสดงข้อผิดพลาดที่อาจเกิดขึ้นในระหว่างการทำงานของสคริปต์
                error_reporting(0);
                ini_set('display_errors', 0);
                $timestart_morning = $_POST['timestart_morning'];
                $timeend_morning = $_POST['timeend_morning'];
                $timestart_noon = $_POST['timestart_noon'];
                $timeend_noon = $_POST['timeend_noon'];
                $t1 = strtotime($timestart_morning);
                $t2 = strtotime($timeend_morning);
                $number1 = round(abs($t2 - $t1) / 3600, 2);
                $t3 = strtotime($timestart_noon);
                $t4 = strtotime($timeend_noon);
                $number2 = round(abs($t4 - $t3) / 3600, 2);
                $total = $number1 + $number2; ?>
                <?php if ($total > 6) {
                  echo '<td>' . 'ไม่สามารถทำงานเกิน 6 ชั่วโมงได้' . '</td>'; ?>
                <?php } else {
                  echo '<td>' . $total . '</td>';
                }  ?>
              <td>
                <select class="col col-lg-7" name="work">
                  <option selected>เลือก...</option>
                  <option value="งานด้านเอกสาร สารบรรณ และธุรการทั่วไป">งานด้านเอกสาร สารบรรณ และธุรการทั่วไป</option>
                  <option value="งานด้านการออกแบบสื่อประชาสัมพันธ์">งานด้านการออกแบบสื่อประชาสัมพันธ์</option>
                  <option value="งานในห้องปฏิบัติการและทักษะเฉพาะด้าน">งานในห้องปฏิบัติการและทักษะเฉพาะด้าน</option>
                  <option value="งานบริการด้านวิชาการ">งานบริการด้านวิชาการ</option>
                  <option value="งานด้านการใช้ทักษะภาษาอังกฤษ">งานด้านการใช้ทักษะภาษาอังกฤษ</option>
                  <input type="text" name="work_detail" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") echo $_POST["work_detail"] ?>" class="col col-lg-4">
              </td>
  </form>
  </div>
  </tr>
  </div>
  </tr>
  </div>


  </tbody>
  </table>
  <input type="submit" name="submit" value="บันทึก" class="btn btn-primary my-3">
  </form>
</body>

</html>