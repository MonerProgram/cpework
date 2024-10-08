<?php  
   require_once "layout/header.php";
   require_once "db/connect.php";
   require_once "layout/check_admin.php";
   require_once "layout/check.php";
   require_once "layout/session.php";
   $user_id=$_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1 class="text-center"><?php echo "ข้อมูลเวลาการทำงาน";?></h1>
  <h4>เรียกดูข้อมูลจากการเลือกวันที่</h4>
  <form action="subhead.php" method="get">
    <input type="month" name="q" class="form-control">
    <br>
    <button type="submit" class="btn btn-primary">ค้นหาข้อมูล</button>
  </form>

  <?php
    if (isset($_GET['q']) && isset($_SESSION['user_id'])) {
      require_once 'db/connect.php';
      $startOfMonth = $_GET['q'] . '-01';
      $endOfMonth = date('Y-m-t', strtotime($startOfMonth));

      $stmt = $pdo->prepare("SELECT * FROM record WHERE dates BETWEEN ? AND ? AND user_id=?");
      $stmt->execute([$startOfMonth, $endOfMonth, $_SESSION['user_id']]);
      $result = $stmt->fetchAll();
  ?>

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
        <td><?php echo $row['dates'];?></td>
        <td><?php echo $row['timestart_morning'];?> <?php echo $row['timeend_morning'];?></td>
        <td><?php echo $row['timestart_noon'];?> <?php echo $row['timeend_noon'];?></td>
        <td><?php echo $row['Time'];?> </td>
        <td><?php echo $row["work"]; ?></td>
        <td><?php echo $row["work_detail"]; ?></td>
        <td><a onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" href="delete.php?id=<?php echo $row["id"];?>" class="btn btn-danger">ลบข้อมูล</a></td>
      </tr>
    <?php } ?>
      <tr>
        <th>ชั่วโมงงานทั้งหมดในเดือนนี้</th>
        <th><?php echo $total; ?></th>
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
        $stmt->execute([$_SESSION['user_id']]);
        $result1 = $stmt->fetchAll(); ?>   
        <?php foreach($result1 as $row) { ?>
          <tr>
            <td><?php echo $row['dates'];?></td>
            <td><?php echo $row['timestart_morning'];?> <?php echo $row['timeend_morning'];?></td>
            <td><?php echo $row['timestart_noon'];?> <?php echo $row['timeend_noon'];?></td>
            <td><?php echo $row['Time'];?> </td>
            <td><?php echo $row["work"]; ?></td>
            <td><?php echo $row["work_detail"]; ?></td>
                        <td><a onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')"href="delete.php?id=<?php echo $row["id"];?>" class="btn btn-danger">ลบข้อมูล</a></td>
          </tr>
        <?php } ?>

        <tr>
          <th>ชั่วโมงงานทั้งหมดของทุกวันรวมกัน</th>
          <?php 
            $conn = mysqli_connect('localhost', 'root', '', 'cpework');
            mysqli_set_charset($conn, 'utf8');
            $query = "SELECT SUM(Time) as r FROM record WHERE user_id='$_SESSION[user_id]'";
            $result=mysqli_query($conn,$query);
            while ($row = mysqli_fetch_assoc($result)){?>
              <th><?php echo $row['r'];?></th>
          <?php }?>
        </tr>
      <?php }?>
    </tbody>
  </table>
</div>
</body>
</html>
