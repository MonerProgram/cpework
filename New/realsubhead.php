<?php
require_once "layout/header.php";
require_once "db/connect.php";
require_once "layout/check_admin.php";
require_once "layout/check.php";
require_once "layout/session.php";
$user_id = $_GET['id'];
$selected_month = $_GET['q'];

// Debug: ตรวจสอบค่า user_id และ selected_month
echo "User ID: ";
var_dump($user_id);
echo "<br>Selected Month: ";
var_dump($selected_month);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1 class="text-center"><?php echo "ข้อมูลเวลาการทำงาน"; ?></h1>
  <h4>เรียกดูข้อมูลจากการเลือกวันที่</h4>

  <form action="realsubhead.php" method="get">
    <input type="month" name="q" class="form-control" inputmode="numeric" pattern="\d{4}-\d{2}" placeholder="YYYY-MM">
    <br>
    <input type="hidden" name="id" value="<?php echo $user_id; ?>">
    <button type="submit" class="btn btn-primary">ค้นหาข้อมูล</button>
  </form>

  <?php
  if (isset($_GET['q']) && isset($user_id)) {
    require_once 'db/connect.php';
    $startOfMonth = $_GET['q'] . '-01';
    $endOfMonth = date('Y-m-t', strtotime($startOfMonth));

    // Debug: ตรวจสอบค่า startOfMonth และ endOfMonth
    echo "Start of Month: ";
    var_dump($startOfMonth);
    echo "<br>End of Month: ";
    var_dump($endOfMonth);

    $stmt = $pdo->prepare("SELECT * FROM record WHERE dates BETWEEN ? AND ? AND user_id=?");
    $stmt->execute([$startOfMonth, $endOfMonth, $user_id]);

    // Debug: ตรวจสอบ SQL Error (หากมี)
    if ($stmt->errorInfo()[0] != '00000') {
      echo "SQL Error";
      var_dump($stmt->errorInfo());
    }

    $result = $stmt->fetchAll();

    // Debug: ตรวจสอบผลลัพธ์จาก query
    echo "<br>Query Result:";
    var_dump($result);

    if (empty($result)) {
      echo "<p>No records found for the given month and user ID.</p>";
    } else {
      // แสดงผลลัพธ์ตามปกติ
    }

  ?>

    <?php
    $stmt = $pdo->prepare("SELECT * FROM record WHERE dates BETWEEN ? AND ? AND user_id=?");
    $startOfMonth = $_GET['q'] . '-01';
    $endOfMonth = date('Y-m-t', strtotime($startOfMonth));
    $stmt->execute([$startOfMonth, $endOfMonth, $user_id]);
    $result = $stmt->fetchAll();
    $dates = $_GET['q'];
    ?>

    <form action="reportdb.php" method="get">
      <input type="hidden" name="q" value="<?php echo $dates;  ?>">
      <input type="hidden" name="id" value="<?php echo $user_id;  ?>">
      <button type="submit" class="btn btn-primary">PDF</button>
    </form>

    <br>
    <h3>รายการเช็คเวลาในเดือน: <?= $_GET['q']; ?></h3>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">วันที่ปฏิบัติงาน</th>
          <th scope="col">เวลาปฏิบัติงานช่วงที่ 1</th>
          <th scope="col">เวลาปฏิบัติงานช่วงที่ 2</th>
          <th scope="col">ชั่วโมงปฎิบัติงาน</th>
          <th scope="col">ลักษณะงานที่ปฏิบัติ</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0; // Variable to store the total working hours

        foreach ($result as $row) {
          $total += $row['Time'];
        ?>
          <tr>
            <td><?php echo $row['dates']; ?></td>
            <td><?php echo $row['timestart_morning']; ?> <?php echo $row['timeend_morning']; ?></td>
            <td><?php echo $row['timestart_noon']; ?> <?php echo $row['timeend_noon']; ?></td>
            <td><?php echo $row['Time']; ?> </td>
            <td><?php echo $row["work"]; ?></td>
            <td><?php echo $row["work_detail"]; ?></td>
            <td><a onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" href="delete.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">ลบข้อมูล</a></td>
          </tr>
        <?php } ?>
        <tr>
          <th>ชั่วโมงงานทั้งหมดในเดือนนี้</th>
          <th><?php echo $total; ?></th>
        </tr>
        <tr>
          <th>เงินรวมเดือนนี้</th>
          <th><?php echo $total * 50; ?></th>
        </tr>
      </tbody>
    </table>
  <?php } else { ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">วันที่ปฏิบัติงาน</th>
          <th scope="col">เวลาปฏิบัติงานช่วงที่ 1</th>
          <th scope="col">เวลาปฏิบัติงานช่วงที่ 2</th>
          <th scope="col">ชั่วโมงปฎิบัติงาน</th>
          <th scope="col">ลักษณะงานที่ปฏิบัติ</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php require_once 'db/connect.php';
        $stmt = $pdo->prepare("SELECT * FROM record WHERE user_id=?");
        $stmt->execute([$user_id]);
        $result1 = $stmt->fetchAll(); ?>
        <?php foreach ($result1 as $row) { ?>
          <tr>
            <td><?php echo $row['dates']; ?></td>
            <td><?php echo $row['timestart_morning']; ?> <?php echo $row['timeend_morning']; ?></td>
            <td><?php echo $row['timestart_noon']; ?> <?php echo $row['timeend_noon']; ?></td>
            <td><?php echo $row['Time']; ?> </td>
            <td><?php echo $row["work"]; ?></td>
            <td><?php echo $row["work_detail"]; ?></td>
            <td><a onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" href="delete.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">ลบข้อมูล</a></td>
          </tr>
        <?php } ?>

        <tr>
          <th>ชั่วโมงงานทั้งหมดของทุกวันรวมกัน</th>
          <?php
          $conn = mysqli_connect('localhost', 'root', '', 'cpework');
          mysqli_set_charset($conn, 'utf8');
          $query = "SELECT SUM(Time) as r FROM record WHERE user_id='$user_id'";
          $result = mysqli_query($conn, $query);
          while ($row = mysqli_fetch_assoc($result)) { ?>
            <th><?php echo $row['r']; ?></th>
          <?php } ?>
        </tr>
        <tr>
        </tr>
      <?php } ?>
      </tbody>
    </table>
    </div>
</body>

</html>