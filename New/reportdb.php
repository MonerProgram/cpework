<?php


#นำไฟล์ data base มาใช้
require('connect.php');
#นำไฟล์ fpdf มาใช้
require('pdf/fpdf.php');


$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->AddFont('sarabun', '', 'THSarabun.php');
$pdf->SetFont('sarabun', '', 14);
$user_id = $_GET['id'];
$dates = $_GET['q'];
mysqli_set_charset($connect, 'utf8');
$timestamp = strtotime($dates);
$datess = date('m', $timestamp);

$user = "SELECT * FROM record, record1 WHERE record.user_id = '$user_id' AND record.user_id = record1.Student_id AND MONTH(record.dates) ='$datess'";
$query_user = mysqli_query($connect, $user);
$rs_user = mysqli_fetch_assoc($query_user);

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
function MonthThai($Month)
{
    $strYears = date("Y", strtotime($Month)) + 543;
    $strMonths = date("n", strtotime($Month));
    $thaiMonthsFull = ["", 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    $MonthFull = $thaiMonthsFull[$strMonths];
    return "$MonthFull $strYears";
}


if (mysqli_num_rows($query_user) > 0) {



    $pdf->Cell(0, 7, iconv('utf-8', 'cp874', 'แบบฟอร์มลงเวลาการปฎิบัติงานของนักศึกษา ทุนจ้างงาน'), 0, 1, 'C');
    $pdf->Cell(88, 7, iconv('utf-8', 'cp874', $rs_user['department']), 0, 0, 'R');
    $pdf->Cell(25, 7, iconv('utf-8', 'cp874', MonthThai($rs_user['dates'])), 0, 0, 'L'); #ดึงมาจาก data base
    $pdf->Cell(25, 7, iconv('utf-8', 'cp874', 'ภาคการศึกษาที่'), 0, 0, 'L');
    $pdf->Cell(0, 7, iconv('utf-8', 'cp874', $rs_user['term']), 0, 1, 'L');
    $pdf->Cell(30, 7, iconv('utf-8', 'cp874', 'ชื่อ - สกุล'), 0, 0, 'R');
    $pdf->Cell(35, 7, iconv('utf-8', 'cp874', $rs_user['Name']), 0, 0, 'L'); #ดึงมาจาก data base
    $pdf->Cell(20, 7, iconv('utf-8', 'cp874', 'รหัสนักศึกษา'), 0, 0, 'L');
    $pdf->Cell(30, 7, iconv('utf-8', 'cp874', $rs_user['Student_id']), 0, 0, 'C'); #ดึงมาจาก data base
    $pdf->Cell(23, 7, iconv('utf-8', 'cp874', 'เบอร์มือถือ'), 0, 0, 'C');
    $pdf->Cell(0, 7, iconv('utf-8', 'cp874', $rs_user['Telephone']), 0, 1, 'L'); #ดึงมาจาก data base
    $pdf->Ln();


    #Head Table (w = 190)
    $pdf->Cell(10, 10, iconv('utf-8', 'cp874', 'ลำดับ'), 1, 0, 'C');
    $pdf->Cell(20, 10, iconv('utf-8', 'cp874', 'วัน/เดือน/ปี'), 1, 0, 'C');
    $pdf->Cell(31, 5, iconv('utf-8', 'cp874', 'เช้า'), 1, 0, 'C');
    $pdf->Cell(31, 5, iconv('utf-8', 'cp874', 'บ่าย'), 1, 0, 'C');
    $pdf->Cell(25, 10, iconv('utf-8', 'cp874', 'จำนวนชั่วโมง/วัน'), 1, 0, 'C');
    $pdf->Cell(0, 10, iconv('utf-8', 'cp874', 'รายละเอียดงานที่ได้รับมอบหมาย'), 1, 0, 'C');
    $pdf->Cell(0, 5, '', 0, 1);

    #2nd Head Table (w = 170)
    $pdf->Cell(30, 5, '', 0, 0);
    $pdf->Cell(15.5, 5, iconv('utf-8', 'cp874', 'เวลาเริ่ม'), 1, 0, 'C');
    $pdf->Cell(15.5, 5, iconv('utf-8', 'cp874', 'เวลาสิ้นสุด'), 1, 0, 'C');
    $pdf->Cell(15.5, 5, iconv('utf-8', 'cp874', 'เวลาเริ่ม'), 1, 0, 'C');
    $pdf->Cell(15.5, 5, iconv('utf-8', 'cp874', 'เวลาสิ้นสุด'), 1, 1, 'C');

    #data

    $counter = 1;
    foreach ($query_user as $rs_user) {

        $pdf->Cell(10, 5, iconv('utf-8', 'cp874', $counter), 1, 0, 'C');
        $pdf->Cell(20, 5, iconv('utf-8', 'cp874', DateThai($rs_user['dates'])), 1, 0, 'C');
        $pdf->Cell(15.5, 5, iconv('utf-8', 'cp874', $rs_user['timestart_morning']), 1, 0, 'C');
        $pdf->Cell(15.5, 5, iconv('utf-8', 'cp874', $rs_user['timeend_morning']), 1, 0, 'C');
        $pdf->Cell(15.5, 5, iconv('utf-8', 'cp874', $rs_user['timestart_noon']), 1, 0, 'C');
        $pdf->Cell(15.5, 5, iconv('utf-8', 'cp874', $rs_user['timeend_noon']), 1, 0, 'C');
        $pdf->Cell(25, 5, iconv('utf-8', 'cp874', $rs_user['Time']), 1, 0, 'C');
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $rs_user['work']), 1, 1, 'L');
        // $pdf->Cell(0,5,iconv('utf-8','cp874',$rs_user['work_detail']),1,1,'L');
        $counter++;
    }




    #sum_time
    $query = "SELECT SUM(TIME)  as r FROM record, record1 WHERE record.user_id = '$user_id' AND record.user_id = record1.Student_id AND MONTH(record.dates) ='$datess'";
    $conn = mysqli_connect('localhost', 'root', '', 'cpework');
    mysqli_set_charset($conn, 'utf8');
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(61, 6, iconv('utf-8', 'cp874', ''), 0, 0, 'C');
        $pdf->Cell(31, 6, iconv('utf-8', 'cp874', 'รวมชั่วโมงปฏิบัติงาน'), 1, 0, 'C');
        $pdf->Cell(25, 6, iconv('utf-8', 'cp874', $row['r']), 1, 1, 'C');
        $pdf->Cell(61, 6, iconv('utf-8', 'cp874', ''), 0, 0, 'C');
        $pdf->Cell(31, 6, iconv('utf-8', 'cp874', 'รวมเงิน'), 1, 0, 'C');

        $formattedNumber = number_format($row['r'] * 50, 2, '.', '');
        $pdf->Cell(25, 6, iconv('utf-8', 'cp874', $formattedNumber), 1, 1, 'C');
        $pdf->Ln();
    }
    #ผลการปฏิบัติงานของนักศึกษา และ หมายเหตุ
    $pdf->Cell(66, 6, iconv('utf-8', 'cp874', 'ผลการปฏิบัติงานของนักศึกษา'), 0, 0, 'L');
    $pdf->SetFont('sarabun', '', 11);
    $pdf->Cell(0, 6, iconv('utf-8', 'cp874', 'หมายเหตุ'), 0, 1, 'L');
    $pdf->SetFont('sarabun', '', 14);
    $pdf->Cell(6, 6, iconv('utf-8', 'cp874', ''), 1, 0, 'C');
    $pdf->Cell(60, 6, iconv('utf-8', 'cp874', 'ดีมาก'), 0, 0, 'L');
    $pdf->SetFont('sarabun', '', 10);
    $pdf->Cell(0, 6, iconv('utf-8', 'cp874', '1. นักศึกษาจะต้องลงเวลาทุกครั้งที่ปฏิบัติงาน และต้องส่งรายงานการปฏิบัติงานประจำทุกๆเดือน'), 0, 1, 'L');
    $pdf->Ln(2);
    $pdf->SetFont('sarabun', '', 14);
    $pdf->Cell(6, 6, iconv('utf-8', 'cp874', ''), 1, 0, 'C');
    $pdf->Cell(60, 6, iconv('utf-8', 'cp874', 'ดี'), 0, 0, 'L');
    $pdf->SetFont('sarabun', '', 10);
    $pdf->Cell(0, 6, iconv('utf-8', 'cp874', '2. อัตราจ้างงานทุนจ้างงาน ชั่วโมงละ 50 บาท แต่ไม่เกิน 300 บาทต่อวัน ไม่เกิน 40 ชั่วโมง/สัปดาห์หรือ 2,000 บาท'), 0, 1, 'L');
    $pdf->Ln(2);
    $pdf->SetFont('sarabun', '', 14);
    $pdf->Cell(6, 6, iconv('utf-8', 'cp874', ''), 1, 0, 'C');
    $pdf->Cell(60, 6, iconv('utf-8', 'cp874', 'พอใช้'), 0, 0, 'L');
    $pdf->SetFont('sarabun', '', 10);
    $pdf->Cell(0, 6, iconv('utf-8', 'cp874', '3. หน่วยงาน/ภาควิชา รวบรวมรายงานการปฏิบัติงานของนักศึกษาส่งคณะฯ ทุกสิ้นเดือน ไม่เกินวันที่ 7 ของเดือนถัดไป เพื่อเบิกทุน'), 0, 1, 'L');
    $pdf->Ln(2);
    $pdf->SetFont('sarabun', '', 14);
    $pdf->Cell(6, 6, iconv('utf-8', 'cp874', ''), 1, 0, 'C');
    $pdf->Cell(60, 6, iconv('utf-8', 'cp874', 'ควรปรับปรุง'), 0, 1, 'L');
    $pdf->Ln();


    #ลงชื่อ
    $pdf->Cell(90, 5, iconv('utf-8', 'cp874', 'ลงชื่อนักศึกษา ........................................................'), 0, 0, 'L');
    $pdf->Cell(0, 5, iconv('utf-8', 'cp874', 'ลงชื่อผู้ดูแล ........................................................'), 0, 1, 'C');
    $pdf->Cell(25, 5, iconv('utf-8', 'cp874', '('), 0, 0, 'C');
    $pdf->Cell(25.5, 5, iconv('utf-8', 'cp874', $rs_user['Name']), 0, 0, 'C');
    $pdf->Cell(30, 5, iconv('utf-8', 'cp874', ')'), 0, 0, 'C');
    $pdf->Cell(0, 5, iconv('utf-8', 'cp874', '( ................................................... )'), 0, 0, 'C');
} else {
}





$pdf->Output();
