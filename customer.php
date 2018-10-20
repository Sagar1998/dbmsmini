<?php
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$age = $_POST['age'];
$phoneno =$_POST['phoneno'];
$address =$_POST['address'];


if (!empty($fname) || !empty($address) ||!empty($lname) || !empty($age) || !empty($phoneno)  ) {
 $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "toursandtravels";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT phoneno From customer Where phoneno = ? Limit 1";
     $INSERT = "INSERT Into customer (fname,lname, age, phoneno,address) values( ? ,?, ?, ?, ?)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("i", $phoneno);
     $stmt->execute();
     $stmt->bind_result($phoneno);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("ssiis", $fname, $lname, $age, $phoneno,$address);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already register using this Phone Number";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>