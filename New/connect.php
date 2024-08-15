<?php


    
    $connect = mysqli_connect('localhost','root','', 'cpework');
    if (mysqli_connect_error()) {
         echo 'Failed to connect'. mysqli_connect_error();
     }

     $query = "SELECT * FROM record ";
     $result = $connect->query($query);
     
     if ($result->num_rows > 0) {
         // Fetch the result as an associative array
         $row = $result->fetch_assoc();
         $thaiMonthsFull = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        
         // Retrieve the date/time value
         $datetime = $row['dates'];
     
        
        // Convert the date/time value to Thai format
        $thaiYear = date("Y", strtotime($datetime)) + 543;
        #ด/ป เต็ม
        $thaiMonthsYear = $thaiMonthsFull[date("n", strtotime($datetime)) - 1] . " " . $thaiYear;

        #เดือนย่อ
        // $thaiFormat = date("j ", strtotime($datetime)) . $thaiMonths[date("n", strtotime($datetime)) - 1] . "". $thaiYear;

     }



?>